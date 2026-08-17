<?php

namespace App\Livewire\Seller;

use App\Exports\PropertyBulkTemplateExport;
use App\Models\Category;
use App\Models\CategoryField;
use App\Models\Currency;
use App\Models\Media;
use App\Models\Payment;
use App\Models\Price;
use App\Models\Property;
use App\Models\PropertyFeature;
use App\Models\State;
use App\Models\SubscribedProperty;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ListProperty extends Component
{
    use WithFileUploads;

    public ?int $listing_category_id = null;

    public string $title = '';

    public string $description = '';

    public ?float $cost = null;

    public ?int $state_id = null;

    public ?string $city = null;

    public string $address = '';

    public string $neighborhood = '';

    public bool $show_address = true;

    public string $contact_name = '';

    public string $contact_phone = '';

    public string $contact_email = '';

    public string $contact_whatsapp = '';

    public array $uploadedImages = [];

    public ?UploadedFile $bulk_upload_file = null;

    public bool $showBulkUploadModal = false;

    public array $bulkUploadErrors = [];

    public ?int $selected_subscription_id = null;

    public ?int $selected_subscription_plan_id = null;

    /**
     * When the seller has unused subscription slots: {@see self::SUBSCRIPTION_SOURCE_EXISTING} uses a seat;
     * {@see self::SUBSCRIPTION_SOURCE_PURCHASE} buys a new plan for this listing.
     */
    public string $subscription_source = self::SUBSCRIPTION_SOURCE_EXISTING;

    public const SUBSCRIPTION_SOURCE_EXISTING = 'existing';

    public const SUBSCRIPTION_SOURCE_PURCHASE = 'purchase';

    /**
     * @var array<string, mixed>
     */
    public array $dynamicAttributes = [];

    private ?int $latestPendingPaymentId = null;

    public function mount(): void
    {
        /** @var User|null $user */
        $user = Auth::user();
        if ($user && $user->active_role !== 'seller') {
            $user->forceFill(['active_role' => 'seller'])->save();
        }

        $this->contact_name = (string) ($user?->name ?? '');
        $this->contact_phone = (string) ($user?->phone ?? '');
        $this->contact_email = (string) ($user?->email ?? '');
        $this->contact_whatsapp = (string) ($user?->phone ?? '');
        if ($this->availableSubscriptions->isNotEmpty()) {
            $this->subscription_source = self::SUBSCRIPTION_SOURCE_EXISTING;
            $this->selected_subscription_id = $this->availableSubscriptions->first()?->id;
            $this->selected_subscription_plan_id = null;
        } else {
            $this->subscription_source = self::SUBSCRIPTION_SOURCE_PURCHASE;
            $this->selected_subscription_id = null;
        }
    }

    public function updatedListingCategoryId(mixed $value): void
    {
        $this->dynamicAttributes = [];
        $id = $value !== null && $value !== '' ? (int) $value : null;
        if (! $id) {
            return;
        }
        $category = Category::query()->with('fields')->find($id);
        foreach ($category?->fields ?? [] as $field) {
            $default = $field->default_value;
            if ($field->data_type === CategoryField::TYPE_MULTI_SELECT) {
                $this->dynamicAttributes[$field->key] = is_array($default) ? $default : [];

                continue;
            }
            if ($field->data_type === CategoryField::TYPE_BOOLEAN) {
                $this->dynamicAttributes[$field->key] = (bool) ($default ?? false);

                continue;
            }

            $this->dynamicAttributes[$field->key] = is_array($default) ? null : $default;
        }
    }

    public function updatedStateId(): void
    {
        $this->city = null;
    }

    public function updatedSubscriptionSource(string $value): void
    {
        if ($value === self::SUBSCRIPTION_SOURCE_EXISTING) {
            $this->selected_subscription_plan_id = null;
            if (! (int) $this->selected_subscription_id && $this->availableSubscriptions->isNotEmpty()) {
                $this->selected_subscription_id = (int) $this->availableSubscriptions->first()->id;
            }

            return;
        }

        if ($value === self::SUBSCRIPTION_SOURCE_PURCHASE) {
            $this->selected_subscription_id = null;
        }
    }

    public function removeImage(int $index): void
    {
        if (isset($this->uploadedImages[$index])) {
            unset($this->uploadedImages[$index]);
            $this->uploadedImages = array_values($this->uploadedImages);
        }
    }

    public function openBulkUploadModal(): void
    {
        $this->showBulkUploadModal = true;
    }

    public function closeBulkUploadModal(): void
    {
        $this->showBulkUploadModal = false;
        $this->bulk_upload_file = null;
        $this->bulkUploadErrors = [];
        $this->resetValidation(['bulk_upload_file']);
    }

    public function saveDraft(): mixed
    {
        $property = $this->persistPropertyWorkflow('draft');
        session()->flash('status', __('Draft saved successfully.'));

        return redirect()->route('seller.properties.show', ['property' => $property->id]);
    }

    public function submitListing(): mixed
    {
        $property = $this->persistPropertyWorkflow('submit');
        $requiresPayment = $this->requiresPayment();

        if ($requiresPayment) {
            session()->flash('status', __('Listing saved. Complete checkout to publish it.'));
            $paymentId = $this->latestPendingPaymentId ?? Payment::query()
                ->where('user_id', Auth::id())
                ->where('paymentable_type', Subscription::class)
                ->where('status', 'pending')
                ->latest('id')
                ->value('id');

            if ($paymentId) {
                return redirect()->route('seller.checkout', ['payment' => $paymentId]);
            }
        }

        session()->flash('status', __('Listing submitted successfully.'));

        return redirect()->route('seller.properties.show', ['property' => $property->id]);
    }

    public function processBulkUpload(): mixed
    {
        $this->validate([
            'bulk_upload_file' => ['required', 'file', 'mimes:csv,xlsx,xls', 'max:10240'],
        ], [], ['bulk_upload_file' => 'bulk upload file']);

        /** @var User $user */
        $user = Auth::user();
        $rows = Excel::toArray([], $this->bulk_upload_file)[0] ?? [];
        if ($rows === []) {
            throw ValidationException::withMessages(['bulk_upload_file' => __('The uploaded file is empty.')]);
        }

        $header = collect(array_shift($rows) ?? [])->map(fn ($item) => Str::of((string) $item)->lower()->snake()->value())->values()->all();
        $this->bulkUploadErrors = [];
        $created = 0;

        foreach ($rows as $index => $rowValues) {
            $row = [];
            foreach ($header as $col => $key) {
                $row[$key] = isset($rowValues[$col]) ? trim((string) $rowValues[$col]) : null;
            }

            try {
                $category = Category::query()->where('slug', $row['category_slug'] ?? '')->with('fields')->first();
                if (! $category || empty($row['title'])) {
                    throw new \RuntimeException(__('Missing required title/category_slug values.'));
                }

                $property = Property::query()->create([
                    'name' => $row['title'],
                    'slug' => Str::slug((string) $row['title']).'-'.Str::lower(Str::random(6)),
                    'description' => (string) ($row['description'] ?? ''),
                    'cost' => (float) ($row['cost'] ?? 0),
                    'category_id' => $category->id,
                    'location' => null,
                    'country_id' => $user->country_id,
                    'state_id' => $this->lookupStateId($row['state_code'] ?? null, $row['state_name'] ?? null),
                    'city' => $row['city'] ?? null,
                    'neighborhood' => (string) ($row['neighborhood'] ?? ''),
                    'address' => (string) ($row['address'] ?? ''),
                    'show_address' => filter_var($row['show_address'] ?? true, FILTER_VALIDATE_BOOLEAN),
                    'is_published' => false,
                    'contact_name' => (string) ($row['contact_name'] ?? $user->name),
                    'contact_phone' => (string) ($row['contact_phone'] ?? $user->phone),
                    'contact_email' => (string) ($row['contact_email'] ?? $user->email),
                    'contact_whatsapp' => (string) ($row['contact_whatsapp'] ?? $user->phone),
                    'user_id' => $user->id,
                ]);

                foreach ($category->fields as $field) {
                    if (in_array($field->key, PropertyBulkTemplateExport::reservedBaseColumnKeys(), true)) {
                        continue;
                    }

                    if (! isset($row[$field->key]) || $row[$field->key] === '') {
                        continue;
                    }

                    $val = $row[$field->key];
                    if (in_array($field->data_type, [CategoryField::TYPE_MULTI_SELECT, CategoryField::TYPE_MULTI_ENUM], true)) {
                        $items = array_values(array_filter(array_map('trim', explode(',', (string) $val))));
                        $val = json_encode($items);
                    }

                    PropertyFeature::query()->create([
                        'property_id' => $property->id,
                        'feature' => $field->key,
                        'value' => (string) $val,
                        'unit' => null,
                    ]);
                }

                $created++;
            } catch (\Throwable $e) {
                $this->bulkUploadErrors[] = __('Row :row - :error', [
                    'row' => $index + 2,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if ($created === 0) {
            throw ValidationException::withMessages([
                'bulk_upload_file' => __('No valid rows were processed.'),
            ]);
        }

        $this->closeBulkUploadModal();
        session()->flash('status', __('Bulk upload completed: :count draft listing(s) saved.', ['count' => $created]));

        return redirect()->route('seller.listed-properties');
    }

    #[Computed]
    public function activeCategory(): ?Category
    {
        if (! $this->listing_category_id) {
            return null;
        }

        return Category::query()->with('fields')->find($this->listing_category_id);
    }

    #[Computed]
    public function availableSubscriptions(): Collection
    {
        $user = Auth::user();
        if (! $user) {
            return collect();
        }

        return Subscription::query()
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->where('end_at', '>=', now())
            ->with('plan')
            ->withCount('subscribedProperties')
            ->get()
            ->map(function (Subscription $subscription) {
                $remaining = max(0, (int) $subscription->seats - (int) $subscription->subscribed_properties_count);
                $subscription->remaining_slots = $remaining;

                return $subscription;
            })
            ->filter(fn (Subscription $subscription) => (int) $subscription->remaining_slots > 0)
            ->values();
    }

    #[Computed]
    public function hasUnusedSubscriptions(): bool
    {
        return $this->availableSubscriptions->isNotEmpty();
    }

    #[Computed]
    public function activeCurrency(): ?Currency
    {
        return Currency::query()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->where('is_default', true)->orWhere('code', 'NGN');
            })
            ->orderByDesc('is_default')
            ->first();
    }

    public function subscriptionAmount(): float
    {
        $purchasePlan = (int) $this->selected_subscription_plan_id > 0
            && (
                ! $this->hasUnusedSubscriptions
                || $this->subscription_source === self::SUBSCRIPTION_SOURCE_PURCHASE
            );

        if (! $purchasePlan) {
            return 0.0;
        }

        return $this->resolveAmountForPriceable(SubscriptionPlan::class, (int) $this->selected_subscription_plan_id);
    }

    public function subtotalAmount(): float
    {
        return round($this->subscriptionAmount(), 2);
    }

    public function vatRate(): float
    {
        return $this->subtotalAmount() > 0 ? 7.5 : 0.0;
    }

    public function vatAmount(): float
    {
        return round(($this->subtotalAmount() * $this->vatRate()) / 100, 2);
    }

    public function totalAmount(): float
    {
        return round($this->subtotalAmount() + $this->vatAmount(), 2);
    }

    public function requiresPayment(): bool
    {
        return $this->totalAmount() > 0;
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'listing_category_id' => ['required', 'exists:categories,id'],
            'cost' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'string', 'min:20'],
            'state_id' => ['required', 'exists:states,id'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'neighborhood' => ['nullable', 'string', 'max:255'],
            'show_address' => ['boolean'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:40'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_whatsapp' => ['nullable', 'string', 'max:40'],
            'uploadedImages' => ['required', 'array', 'min:1', 'max:10'],
            'uploadedImages.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'selected_subscription_id' => ['nullable', 'integer'],
            'selected_subscription_plan_id' => ['nullable', 'integer', 'exists:subscription_plans,id'],
            'subscription_source' => ['nullable', 'string', Rule::in([self::SUBSCRIPTION_SOURCE_EXISTING, self::SUBSCRIPTION_SOURCE_PURCHASE])],
        ];
    }

    protected function buildDynamicRules(Collection $settings): array
    {
        $rules = [];
        foreach ($settings as $field) {
            $base = $field->is_required ? ['required'] : ['nullable'];
            $path = 'dynamicAttributes.'.$field->key;
            switch ($field->data_type) {
                case CategoryField::TYPE_NUMBER:
                    $rules[$path] = [...$base, 'numeric'];
                    break;
                case CategoryField::TYPE_MULTI_SELECT:
                    $rules[$path] = [...$base, 'array'];
                    $rules[$path.'.*'] = ['string'];
                    break;
                case CategoryField::TYPE_BOOLEAN:
                    $rules[$path] = [...$base, 'boolean'];
                    break;
                case CategoryField::TYPE_DATE:
                    $rules[$path] = [...$base, 'date'];
                    break;
                default:
                    $rules[$path] = [...$base, 'string', 'max:255'];
                    break;
            }
        }

        return $rules;
    }

    protected function validationAttributes(): array
    {
        return [
            'listing_category_id' => 'listing category',
            'cost' => 'cost',
            'state_id' => 'state',
            'city' => 'city/LGA',
            'uploadedImages' => 'property images',
            'selected_subscription_id' => 'existing subscription',
            'selected_subscription_plan_id' => 'subscription plan',
            'subscription_source' => 'subscription option',
        ];
    }

    private function resolveAmountForPriceable(string $priceableType, int $priceableId): float
    {
        $currency = $this->activeCurrency;
        if (! $currency) {
            return 0.0;
        }

        $price = Price::query()
            ->where('currency_id', $currency->id)
            ->where('priceable_type', $priceableType)
            ->where('priceable_id', $priceableId)
            ->value('amount');

        return $price !== null ? (float) $price : 0.0;
    }

    private function persistFeatures(Property $property): void
    {
        foreach ($this->dynamicAttributes as $feature => $value) {
            if ($value === null || $value === '' || $value === []) {
                continue;
            }

            $stringValue = match (true) {
                is_bool($value) => $value ? '1' : '0',
                is_array($value) => json_encode(array_values($value)),
                default => (string) $value,
            };

            PropertyFeature::query()->create([
                'property_id' => $property->id,
                'feature' => $feature,
                'value' => $stringValue,
                'unit' => null,
            ]);
        }
    }

    private function persistMedia(Property $property): void
    {
        foreach ($this->uploadedImages as $index => $file) {
            $storedPath = $file->store('properties', 'public');
            $extension = pathinfo($storedPath, PATHINFO_EXTENSION);

            Media::query()->create([
                'user_id' => Auth::id(),
                'mediable_id' => $property->id,
                'mediable_type' => Property::class,
                'name' => Media::propertyImageLabel($property->name, $index + 1),
                'path' => $storedPath,
                'type' => 'image',
                'mime_type' => $file->getMimeType(),
                'size' => (string) $file->getSize(),
                'extension' => $extension ?: null,
                'is_primary' => $index === 0,
            ]);
        }
    }

    private function resolveOrCreateSubscriptionForListing(bool $requiresPayment): ?Subscription
    {
        if (
            $this->hasUnusedSubscriptions
            && $this->subscription_source === self::SUBSCRIPTION_SOURCE_EXISTING
            && (int) $this->selected_subscription_id > 0
        ) {
            return Subscription::query()
                ->where('user_id', Auth::id())
                ->whereKey((int) $this->selected_subscription_id)
                ->first();
        }

        if (! (int) $this->selected_subscription_plan_id) {
            return null;
        }

        $plan = SubscriptionPlan::query()->find($this->selected_subscription_plan_id);
        if (! $plan) {
            return null;
        }

        return Subscription::query()->create([
            'user_id' => Auth::id(),
            'subscription_plan_id' => $plan->id,
            'seats' => max(1, (int) $plan->seats),
            'days' => max(1, (int) $plan->days),
            'start_at' => now(),
            'end_at' => now()->addDays(max(1, (int) $plan->days)),
            'renew_at' => now()->addDays(max(1, (int) $plan->days)),
            'status' => $requiresPayment ? 'pending' : 'active',
        ]);
    }


    private function lookupStateId(?string $code, ?string $name): ?int
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // 1) try exact code match
        if ($code) {
            $id = State::query()->whereRaw('LOWER(code) = ?', [Str::lower($code)])->value('id');
            if ($id) {
                return (int) $id;
            }
        }

        // 2) try exact name match
        if ($name) {
            $id = State::query()->whereRaw('LOWER(name) = ?', [Str::lower($name)])->value('id');
            if ($id) {
                return (int) $id;
            }

            // 2b) fuzzy LIKE match
            $state = State::query()->where('name', 'LIKE', "%{$name}%")->first();
            if ($state) {
                return (int) $state->id;
            }
        }

        // 3) fallback to first state in the user's country (if available)
        if ($user?->country_id) {
            $first = State::query()->where('country_id', $user->country_id)->orderBy('id')->value('id');
            if ($first) {
                return (int) $first;
            }
        }

        // 4) final fallback: any first state available
        $any = State::query()->orderBy('id')->value('id');
        return $any ? (int) $any : null;
    }

    /**
     * @return array<string, list<string|ValidationRule>>
     */
    private function subscriptionSourceSubmitRules(): array
    {
        if ($this->subscription_source === self::SUBSCRIPTION_SOURCE_EXISTING) {
            return [
                'selected_subscription_id' => [
                    'required',
                    'integer',
                    Rule::exists('subscriptions', 'id')->where(fn ($query) => $query->where('user_id', Auth::id())),
                ],
                'selected_subscription_plan_id' => ['nullable', 'integer', 'exists:subscription_plans,id'],
            ];
        }

        return [
            'selected_subscription_plan_id' => ['required', 'integer', 'exists:subscription_plans,id'],
            'selected_subscription_id' => ['nullable', 'integer'],
        ];
    }

    private function persistPropertyWorkflow(string $mode): Property
    {
        if ($mode === 'submit') {
            $this->validate($this->rules(), [], $this->validationAttributes());
            $activeSettings = $this->activeCategory?->fields ?? collect();
            $dynamicRules = $this->buildDynamicRules($activeSettings);
            if ($dynamicRules !== []) {
                $this->validate($dynamicRules, [], $this->validationAttributes());
            }
            if ($this->hasUnusedSubscriptions) {
                $this->validate([
                    'subscription_source' => ['required', 'string', Rule::in([self::SUBSCRIPTION_SOURCE_EXISTING, self::SUBSCRIPTION_SOURCE_PURCHASE])],
                    ...$this->subscriptionSourceSubmitRules(),
                ], [], $this->validationAttributes());
            } else {
                $this->validate([
                    'selected_subscription_plan_id' => ['required', 'integer', 'exists:subscription_plans,id'],
                ], [], $this->validationAttributes());
            }
        } else {
            $this->validate([
                'title' => ['nullable', 'string', 'max:255'],
                'listing_category_id' => ['nullable', 'exists:categories,id'],
                'cost' => ['nullable', 'numeric', 'min:0'],
            ]);
        }

        $this->latestPendingPaymentId = null;
        $requiresPayment = $mode === 'submit' ? $this->requiresPayment() : false;
        $targetStatus = $mode === 'draft'
            ? 0
            : ($requiresPayment ? 0 : 1);

        return DB::transaction(function () use ($mode, $requiresPayment, $targetStatus): Property {
            /** @var User $user */
            $user = Auth::user();

            $property = Property::query()->create([
                'name' => $this->title !== '' ? $this->title : __('Untitled Draft Listing'),
                'slug' => Str::slug($this->title !== '' ? $this->title : 'untitled-draft-listing').'-'.Str::lower(Str::random(6)),
                'description' => $this->description,
                'cost' => (float) ($this->cost ?? 0),
                'category_id' => $this->listing_category_id,
                'location' => trim($this->address.' '.$this->neighborhood),
                'country_id' => $user->country_id,
                'state_id' => $this->state_id,
                'city' => $this->city,
                'neighborhood' => $this->neighborhood !== '' ? $this->neighborhood : null,
                'address' => $this->address,
                'show_address' => $this->show_address,
                'is_published' => $targetStatus,
                'contact_name' => $this->contact_name,
                'contact_phone' => $this->contact_phone,
                'contact_email' => $this->contact_email,
                'contact_whatsapp' => $this->contact_whatsapp,
                'user_id' => $user->id,
            ]);

            $this->persistFeatures($property);
            if ($mode === 'submit') {
                $this->persistMedia($property);
            }

            if ($mode === 'submit') {
                $subscriptionForListing = $this->resolveOrCreateSubscriptionForListing($requiresPayment);
                if ($subscriptionForListing) {
                    SubscribedProperty::query()->firstOrCreate([
                        'property_id' => $property->id,
                        'subscription_id' => $subscriptionForListing->id,
                    ]);
                }

                    if ($requiresPayment && $this->activeCurrency && $this->totalAmount() > 0 && $subscriptionForListing) {
                        $payment = Payment::query()->create([
                            'user_id' => $user->id,
                            'currency_id' => $this->activeCurrency->id,
                            'paymentable_id' => $subscriptionForListing->id,
                            'paymentable_type' => Subscription::class,
                            'reference' => 'LIST-'.Str::upper(Str::random(12)),
                            'request_id' => null,
                            'amount' => $this->subtotalAmount(),
                            'vat_rate' => $this->vatRate(),
                            'vat_value' => $this->vatAmount(),
                            'total' => $this->totalAmount(),
                            'method' => null,
                            'status' => 'pending',
                        ]);

                        $this->latestPendingPaymentId = $payment->id;
                    }
                }

            return $property;
        });
    }

    public function render(): View
    {
        $states = State::query()
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();
        $cities = Property::whereIn('state_id', $states->pluck('id'))->get()->pluck('city')->unique()->sort()->values();
        return view('livewire.seller.list-property', [
            'categories' => Category::query()->where('is_property', 1)->with('fields')->orderBy('name', 'asc')->get(),
            'states' => $states,
            'cities' => $cities,
            'subscriptionPlans' => SubscriptionPlan::query()->orderBy('name', 'asc')->get(),
            'availableSubscriptions' => $this->availableSubscriptions,
            'activeCurrency' => $this->activeCurrency,
        ]);
    }
}
