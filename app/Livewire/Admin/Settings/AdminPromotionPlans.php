<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Currency;
use App\Models\PromotionPlan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AdminPromotionPlans extends Component
{
    public const TYPES = [
        'blog_post' => 'Blog post',
        'featured' => 'Featured (views & clicks)',
        'newsletter' => 'Newsletters',
    ];

    public const FEATURE_KEYS = [
        'clicks',
        'posts',
        'emails',
        'recipients',
    ];

    public bool $showModal = false;

    public ?int $editingId = null;

    public string $name = '';

    public string $slug = '';

    public string $type = 'blog_post';

    public int $days = 30;

    /** @var list<array{key: string, value: string}> */
    public array $featureRows = [];

    /** @var list<array{currency_id: int|string, amount: string, is_default: bool}> */
    public array $priceRows = [];

    public function openCreate(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->slug = '';
        $this->type = 'blog_post';
        $this->days = 30;
        $this->featureRows = array_map(
            fn ($key) => ['key' => $key, 'value' => ''],
            self::FEATURE_KEYS
        );
        $defaultCurrencyId = $this->defaultCurrencyId();
        $this->priceRows = $defaultCurrencyId
            ? [['currency_id' => $defaultCurrencyId, 'amount' => '0', 'is_default' => true]]
            : [];
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function openEdit(int $id): void
    {
        $plan = PromotionPlan::query()->with('prices.currency')->findOrFail($id);
        $this->editingId = $plan->id;
        $this->name = $plan->name;
        $this->slug = (string) ($plan->slug ?? '');
        $this->type = in_array($plan->type, array_keys(self::TYPES), true) ? $plan->type : 'blog_post';
        $this->featureRows = array_map(function ($key) use ($plan) {
            $value = $plan->features[$key] ?? '';
            return ['key' => $key, 'value' => (string) $value];
        }, self::FEATURE_KEYS);
        $this->priceRows = [];
        foreach ($plan->prices as $p) {
            $this->priceRows[] = [
                'currency_id' => $p->currency_id,
                'amount' => (string) $p->amount,
                'is_default' => $p->is_default,
            ];
        }
        if ($this->priceRows === []) {
            $defaultCurrencyId = $this->defaultCurrencyId();
            $this->priceRows = $defaultCurrencyId
                ? [['currency_id' => $defaultCurrencyId, 'amount' => '0', 'is_default' => true]]
                : [];
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
        $usedCurrencyIds = array_column($this->priceRows, 'currency_id');
        $currencyId = Currency::query()
            ->whereNotIn('id', $usedCurrencyIds ?: [0])
            ->orderBy('currency_code')
            ->value('id');

        if (! $currencyId) {
            $this->addError('priceRows', __('There are no additional currencies available.'));

            return;
        }

        $this->priceRows[] = [
            'currency_id' => $currencyId,
            'amount' => '0',
            'is_default' => false,
        ];
    }

    public function removePriceRow(int $index): void
    {
        unset($this->priceRows[$index]);
        $this->priceRows = array_values($this->priceRows);
        if ($this->priceRows === []) {
            $defaultCurrencyId = $this->defaultCurrencyId();
            $this->priceRows = $defaultCurrencyId
                ? [['currency_id' => $defaultCurrencyId, 'amount' => '0', 'is_default' => true]]
                : [];
        }
    }

    public function savePlan(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'type' => ['required', Rule::in(array_keys(self::TYPES))],
            'featureRows' => ['nullable', 'array'],
            'featureRows.*.value' => ['nullable', 'string', 'max:1000'],
            'priceRows' => ['required', 'array', 'min:1'],
            'priceRows.*.currency_id' => ['required', 'integer', 'exists:currencies,id', 'distinct'],
            'priceRows.*.amount' => ['required', 'numeric', 'min:0'],
            'priceRows.*.is_default' => ['required', 'boolean'],
        ]);

        $defaultCount = collect($this->priceRows)
            ->filter(fn (array $row): bool => filter_var($row['is_default'] ?? false, FILTER_VALIDATE_BOOLEAN))
            ->count();

        if ($defaultCount !== 1) {
            $this->addError('priceRows', __('Select exactly one default price.'));

            return;
        }

        $features = [];
        foreach ($this->featureRows as $row) {
            if (isset($row['key'], $row['value'])) {
                $features[$row['key']] = $row['value'];
            }
        }

        $slug = $this->slug !== '' ? Str::slug($this->slug) : Str::slug($this->name);

        DB::transaction(function () use ($features, $slug): void {
            if ($this->editingId) {
                $plan = PromotionPlan::query()->findOrFail($this->editingId);
                $plan->update([
                    'name' => $this->name,
                    'slug' => $slug,
                    'type' => $this->type,
                    'features' => $features,
                ]);
            } else {
                $plan = PromotionPlan::query()->create([
                    'name' => $this->name,
                    'slug' => $slug,
                    'type' => $this->type,
                    'features' => $features,
                ]);
            }

            $plan->prices()->delete();

            foreach ($this->priceRows as $row) {
                $plan->prices()->create([
                    'currency_id' => $row['currency_id'],
                    'amount' => $row['amount'],
                    'is_default' => filter_var($row['is_default'], FILTER_VALIDATE_BOOLEAN),
                ]);
            }
        });

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
            ->with('prices.currency')
            ->orderBy('name','asc')
            ->get();

        $currencies = Currency::query()->orderBy('currency_code')->get();

        return view('livewire.admin.settings.admin-promotion-plans', [
            'plans' => $plans,
            'currencies' => $currencies,
            'planTypes' => self::TYPES,
        ]);
    }

    private function defaultCurrencyId(): ?int
    {
        $currencyId = Currency::query()->where('currency_code', 'USD')->value('id')
            ?? Currency::query()->orderBy('currency_code')->value('id');

        return $currencyId === null ? null : (int) $currencyId;
    }
}
