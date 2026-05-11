<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Currency;
use App\Models\Price;
use App\Models\PromotionPlan;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class PromotionPlans extends Component
{
    public const TYPES = [
        'blog_post' => 'Blog post',
        'featured' => 'Featured (views & clicks)',
        'newsletter' => 'Newsletters',
    ];

    public bool $showModal = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $slug = '';

    public string $type = 'blog_post';

    public int $days = 30;

    public string $featuresJson = '{}';

    /** @var list<array{currency_id: int|null, amount: string}> */
    public array $priceRows = [];

    public function openCreate(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->slug = '';
        $this->type = 'blog_post';
        $this->days = 30;
        $this->featuresJson = '{}';
        $defaultCurrency = Currency::query()->where('is_active', true)->orderByDesc('is_default')->orderBy('code')->value('id');
        $this->priceRows = [['currency_id' => $defaultCurrency, 'amount' => '0']];
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $plan = PromotionPlan::query()->with(['prices' => fn ($q) => $q->whereNull('country_id')])->findOrFail($id);
        $this->editingId = $plan->id;
        $this->name = $plan->name;
        $this->slug = (string) ($plan->slug ?? '');
        $this->type = in_array($plan->type, array_keys(self::TYPES), true) ? $plan->type : 'blog_post';
        $this->days = (int) $plan->days;
        $this->featuresJson = json_encode($plan->features ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $this->priceRows = [];
        foreach ($plan->prices as $p) {
            $this->priceRows[] = ['currency_id' => $p->currency_id, 'amount' => (string) $p->amount];
        }
        if ($this->priceRows === []) {
            $defaultCurrency = Currency::query()->where('is_active', true)->orderByDesc('is_default')->orderBy('code')->value('id');
            $this->priceRows = [['currency_id' => $defaultCurrency, 'amount' => '0']];
        }
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->editingId = null;
    }

    public function addPriceRow(): void
    {
        $defaultCurrency = Currency::query()->where('is_active', true)->orderByDesc('is_default')->orderBy('code')->value('id');
        $this->priceRows[] = ['currency_id' => $defaultCurrency, 'amount' => '0'];
    }

    public function removePriceRow(int $index): void
    {
        unset($this->priceRows[$index]);
        $this->priceRows = array_values($this->priceRows);
        if ($this->priceRows === []) {
            $this->addPriceRow();
        }
    }

    public function savePlan(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'type' => ['required', Rule::in(array_keys(self::TYPES))],
            'days' => ['required', 'integer', 'min:1'],
            'featuresJson' => ['nullable', 'string'],
            'priceRows' => ['required', 'array', 'min:1'],
            'priceRows.*.currency_id' => ['required', 'integer', 'exists:currencies,id'],
            'priceRows.*.amount' => ['required', 'numeric', 'min:0'],
        ]);

        $decoded = json_decode(trim($this->featuresJson) ?: '{}', true);
        if (! is_array($decoded)) {
            $this->addError('featuresJson', __('Must be valid JSON.'));

            return;
        }

        $slug = $this->slug !== '' ? Str::slug($this->slug) : Str::slug($this->name);

        if ($this->editingId) {
            $plan = PromotionPlan::query()->findOrFail($this->editingId);
            $plan->update([
                'name' => $this->name,
                'slug' => $slug,
                'type' => $this->type,
                'days' => $this->days,
                'features' => $decoded,
            ]);
        } else {
            $plan = PromotionPlan::query()->create([
                'name' => $this->name,
                'slug' => $slug,
                'type' => $this->type,
                'days' => $this->days,
                'features' => $decoded,
            ]);
        }

        $plan->prices()->whereNull('country_id')->delete();

        foreach ($this->priceRows as $row) {
            if (! isset($row['currency_id'], $row['amount'])) {
                continue;
            }
            Price::query()->create([
                'priceable_type' => PromotionPlan::class,
                'priceable_id' => $plan->id,
                'country_id' => null,
                'currency_id' => (int) $row['currency_id'],
                'amount' => $row['amount'],
            ]);
        }

        session()->flash('status', __('Promotion plan saved.'));
        $this->closeModal();
    }

    public function deletePlan(int $id): void
    {
        $plan = PromotionPlan::query()->findOrFail($id);
        if ($plan->promotions()->exists()) {
            session()->flash('error', __('Cannot delete a plan that has promotions.'));

            return;
        }
        $plan->prices()->delete();
        $plan->delete();
        session()->flash('status', __('Plan deleted.'));
    }

    public function render()
    {
        $plans = PromotionPlan::query()
            ->with(['prices' => fn ($q) => $q->whereNull('country_id')->with('currency')])
            ->orderBy('name')
            ->get();

        $currencies = Currency::query()->where('is_active', true)->orderBy('code')->get();

        return view('livewire.admin.settings.promotion-plans', [
            'plans' => $plans,
            'currencies' => $currencies,
            'planTypes' => self::TYPES,
        ]);
    }
}
