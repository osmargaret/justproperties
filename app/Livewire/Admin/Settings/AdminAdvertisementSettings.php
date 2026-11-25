<?php

namespace App\Livewire\Admin\Settings;

use App\Models\AdvertisementPlan;
use App\Models\AdvertisementSpace;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class AdminAdvertisementSettings extends Component
{
    use WithPagination;

    public string $activeTab = 'spaces';

    public string $search = '';

    public bool $showSpaceModal = false;

    public ?int $editingSpaceId = null;

    public string $spaceName = '';

    public string $spaceSlug = '';

    public string $spaceDescription = '';

    public string $spaceFormat = '';

    public string $spaceDimensions = '';

    public string $spaceIcon = '';

    public int $spaceSortOrder = 0;

    public bool $spaceIsActive = true;

    public bool $showPlanModal = false;

    public ?int $editingPlanId = null;

    public string $planName = '';

    public string $planSlug = '';

    public string $planDescription = '';

    public string $planFeatures = '';

    public int $billingQuantity = 1;

    public string $billingPeriod = 'week';

    public string $impressionsIncluded = '';

    public bool $planIsActive = true;

    /** @var list<int|string> */
    public array $selectedSpaceIds = [];

    /** @var list<array{currency_id: int|string, amount: string, is_default: bool}> */
    public array $priceRows = [];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['spaces', 'plans'], true)) {
            $this->activeTab = $tab;
            $this->resetPage();
        }
    }

    public function openCreateSpace(): void
    {
        $this->resetSpaceForm();
        $this->resetValidation();
        $this->showSpaceModal = true;
    }

    public function openEditSpace(int $id): void
    {
        $space = AdvertisementSpace::query()->findOrFail($id);
        $this->editingSpaceId = $space->id;
        $this->spaceName = $space->name;
        $this->spaceSlug = $space->slug;
        $this->spaceDescription = (string) ($space->description ?? '');
        $this->spaceFormat = (string) ($space->format ?? '');
        $this->spaceDimensions = (string) ($space->dimensions ?? '');
        $this->spaceIcon = (string) ($space->icon ?? '');
        $this->spaceSortOrder = $space->sort_order;
        $this->spaceIsActive = $space->is_active;
        $this->resetValidation();
        $this->showSpaceModal = true;
    }

    public function saveSpace(): void
    {
        $this->spaceSlug = Str::slug($this->spaceSlug !== '' ? $this->spaceSlug : $this->spaceName);
        $this->validate([
            'spaceName' => ['required', 'string', 'max:255'],
            'spaceSlug' => ['required', 'string', 'max:255', Rule::unique('advertisement_spaces', 'slug')->ignore($this->editingSpaceId)],
            'spaceDescription' => ['nullable', 'string'],
            'spaceFormat' => ['nullable', 'string', 'max:255'],
            'spaceDimensions' => ['nullable', 'string', 'max:255'],
            'spaceIcon' => ['nullable', 'string', 'max:255'],
            'spaceSortOrder' => ['required', 'integer', 'min:0', 'max:65535'],
            'spaceIsActive' => ['boolean'],
        ]);

        AdvertisementSpace::query()->updateOrCreate(
            ['id' => $this->editingSpaceId],
            [
                'name' => $this->spaceName,
                'slug' => $this->spaceSlug,
                'description' => $this->spaceDescription ?: null,
                'format' => $this->spaceFormat ?: null,
                'dimensions' => $this->spaceDimensions ?: null,
                'icon' => $this->spaceIcon ?: null,
                'sort_order' => $this->spaceSortOrder,
                'is_active' => $this->spaceIsActive,
            ]
        );

        $this->showSpaceModal = false;
        session()->flash('status', __('Advertising space saved.'));
    }

    public function deleteSpace(int $id): void
    {
        $space = AdvertisementSpace::query()->findOrFail($id);
        if ($space->plans()->exists()) {
            session()->flash('error', __('Remove this space from its advertising plans before deleting it.'));

            return;
        }

        $space->delete();
        session()->flash('status', __('Advertising space deleted.'));
    }

    public function openCreatePlan(): void
    {
        $this->resetPlanForm();
        $currencyId = $this->defaultCurrencyId();
        $this->priceRows = $currencyId === null
            ? []
            : [['currency_id' => $currencyId, 'amount' => '0', 'is_default' => true]];
        $this->resetValidation();
        $this->showPlanModal = true;
    }

    public function openEditPlan(int $id): void
    {
        $plan = AdvertisementPlan::query()->with(['spaces', 'prices'])->findOrFail($id);
        $this->editingPlanId = $plan->id;
        $this->planName = $plan->name;
        $this->planSlug = $plan->slug;
        $this->planDescription = (string) ($plan->description ?? '');
        $this->planFeatures = implode("\n", $plan->features ?? []);
        $this->billingQuantity = $plan->billing_quantity;
        $this->billingPeriod = $plan->billing_period;
        $this->impressionsIncluded = (string) ($plan->impressions_included ?? '');
        $this->planIsActive = $plan->is_active;
        $this->selectedSpaceIds = $plan->spaces->pluck('id')->all();
        $this->priceRows = $plan->prices->map(fn ($price): array => [
            'currency_id' => $price->currency_id,
            'amount' => (string) $price->amount,
            'is_default' => $price->is_default,
        ])->all();
        $this->resetValidation();
        $this->showPlanModal = true;
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
    }

    public function savePlan(): void
    {
        $this->planSlug = Str::slug($this->planSlug !== '' ? $this->planSlug : $this->planName);
        $this->validate([
            'planName' => ['required', 'string', 'max:255'],
            'planSlug' => ['required', 'string', 'max:255', Rule::unique('advertisement_plans', 'slug')->ignore($this->editingPlanId)],
            'planDescription' => ['nullable', 'string'],
            'planFeatures' => ['nullable', 'string'],
            'billingQuantity' => ['required', 'integer', 'min:1', 'max:65535'],
            'billingPeriod' => ['required', Rule::in(['day', 'week', 'month', 'year', 'email'])],
            'impressionsIncluded' => ['nullable', 'integer', 'min:0'],
            'planIsActive' => ['boolean'],
            'selectedSpaceIds' => ['nullable', 'array'],
            'selectedSpaceIds.*' => ['required', 'integer', 'distinct', 'exists:advertisement_spaces,id'],
            'priceRows' => ['required', 'array', 'min:1'],
            'priceRows.*.currency_id' => ['required', 'integer', 'distinct', 'exists:currencies,id'],
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

        DB::transaction(function (): void {
            $plan = AdvertisementPlan::query()->updateOrCreate(
                ['id' => $this->editingPlanId],
                [
                    'name' => $this->planName,
                    'slug' => $this->planSlug,
                    'description' => $this->planDescription ?: null,
                    'features' => array_values(array_filter(
                        array_map('trim', preg_split('/\r\n|\r|\n/', $this->planFeatures) ?: []),
                        fn (string $feature): bool => $feature !== ''
                    )),
                    'billing_quantity' => $this->billingQuantity,
                    'billing_period' => $this->billingPeriod,
                    'impressions_included' => $this->impressionsIncluded === '' ? null : $this->impressionsIncluded,
                    'is_active' => $this->planIsActive,
                ]
            );

            $plan->spaces()->sync(collect($this->selectedSpaceIds)
                ->mapWithKeys(fn ($id): array => [(int) $id => ['quantity' => 1]])
                ->all());
            $plan->prices()->delete();

            foreach ($this->priceRows as $row) {
                $plan->prices()->create([
                    'currency_id' => $row['currency_id'],
                    'amount' => $row['amount'],
                    'is_default' => filter_var($row['is_default'], FILTER_VALIDATE_BOOLEAN),
                ]);
            }
        });

        $this->showPlanModal = false;
        session()->flash('status', __('Advertising plan saved.'));
    }

    public function deletePlan(int $id): void
    {
        $plan = AdvertisementPlan::query()->findOrFail($id);
        if ($plan->advertisements()->exists()) {
            session()->flash('error', __('Cannot delete a plan that has advertisement requests.'));

            return;
        }

        DB::transaction(function () use ($plan): void {
            $plan->prices()->delete();
            $plan->spaces()->detach();
            $plan->delete();
        });

        session()->flash('status', __('Advertising plan deleted.'));
    }

    public function render()
    {
        $spaces = AdvertisementSpace::query()
            ->when(trim($this->search) !== '', function ($query): void {
                $search = '%'.trim($this->search).'%';
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', $search)->orWhere('slug', 'like', $search);
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(10, ['*'], 'spacesPage');

        $plans = AdvertisementPlan::query()
            ->with(['spaces', 'prices.currency'])
            ->when(trim($this->search) !== '', function ($query): void {
                $search = '%'.trim($this->search).'%';
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', $search)->orWhere('slug', 'like', $search);
                });
            })
            ->orderBy('name')
            ->paginate(10, ['*'], 'plansPage');

        return view('livewire.admin.settings.admin-advertisement-settings', [
            'spaces' => $spaces,
            'plans' => $plans,
            'allSpaces' => AdvertisementSpace::query()->orderBy('sort_order')->orderBy('name')->get(),
            'currencies' => Currency::query()->orderBy('currency_code')->get(),
        ]);
    }

    private function defaultCurrencyId(): ?int
    {
        $currencyId = Currency::query()->where('currency_code', 'USD')->value('id')
            ?? Currency::query()->orderBy('currency_code')->value('id');

        return $currencyId === null ? null : (int) $currencyId;
    }

    private function resetSpaceForm(): void
    {
        $this->editingSpaceId = null;
        $this->spaceName = '';
        $this->spaceSlug = '';
        $this->spaceDescription = '';
        $this->spaceFormat = '';
        $this->spaceDimensions = '';
        $this->spaceIcon = '';
        $this->spaceSortOrder = 0;
        $this->spaceIsActive = true;
    }

    private function resetPlanForm(): void
    {
        $this->editingPlanId = null;
        $this->planName = '';
        $this->planSlug = '';
        $this->planDescription = '';
        $this->planFeatures = '';
        $this->billingQuantity = 1;
        $this->billingPeriod = 'week';
        $this->impressionsIncluded = '';
        $this->planIsActive = true;
        $this->selectedSpaceIds = [];
        $this->priceRows = [];
    }
}
