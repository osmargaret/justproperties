<?php

namespace App\Livewire\Seller;

use App\Livewire\Seller\Concerns\ManagesPropertyListingFields;
use App\Models\Category;
use App\Models\City;
use App\Models\Currency;
use App\Models\Media;
use App\Models\Newsletter;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Promotion;
use App\Models\PromotionPlan;
use App\Models\Property;
use App\Models\Setting;
use App\Models\State;
use App\Models\Subscription;
use App\Services\Content\ContentGenerationService;
use App\Services\Pricing\ResolvesPlanPrice;
use App\Services\Subscriptions\ManagesSubscriptionProperties;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class PropertyDetails extends Component
{
    use ManagesPropertyListingFields;
    use WithFileUploads;

    public Property $property;

    public ?Payment $pendingPayment = null;

    public string $activeTab = 'overview';

    /** @var array<int, UploadedFile> */
    public array $uploadedImages = [];

    public string $editName = '';

    public string $editDescription = '';

    public ?float $editCost = null;

    public ?int $editCategoryId = null;

    public ?int $editStateId = null;

    public ?int $editCityId = null;

    public string $editAddress = '';

    public string $editNeighborhood = '';

    public bool $editShowAddress = true;

    public string $editContactName = '';

    public string $editContactPhone = '';

    public string $editContactEmail = '';

    public string $editContactWhatsapp = '';

    public bool $showPromotionWizard = false;

    public string $promotionTypeFilter = 'all';

    public ?int $selectedPromotionPlanId = null;

    public ?string $selectedPromotionType = null;

    public string $contentBrief = '';

    /** @var array<int, array{key: string, title: string, body: string}> */
    public array $contentVariants = [];

    public ?string $selectedVariantKey = null;

    public bool $isGeneratingContent = false;

    public ?int $previewNewsletterId = null;

    public ?int $editingPromotionId = null;

    public ?int $selectedSubscriptionId = null;

    public ?int $previewPromotionId = null;

    public function mount(Property $property): void
    {
        abort_unless($property->user_id === Auth::id(), 403);

        $this->property = $property->load([
            'category.settings',
            'country',
            'state',
            'city',
            'media',
            'features',
            'subscribedPropertyLinks.subscription.plan',
            'promotions.plan',
            'promotions.promotable',
            'promotions.payments',
            'posts.media',
            'latestModeration.moderator',
        ])->loadCount([
            'viewedByUsers',
            'savedByUsers',
            'alerts',
            'reports',
            'promotions',
        ]);

        $this->hydrateDynamicAttributesFromProperty($this->property);
        $this->syncEditFieldsFromProperty();

        $this->pendingPayment = Payment::query()
            ->where('paymentable_type', Property::class)
            ->where('paymentable_id', $property->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $requestedTab = request()->query('tab');
        if (is_string($requestedTab) && in_array($requestedTab, ['overview', 'promotions', 'details'], true)) {
            $this->activeTab = $requestedTab;
        }
    }

    public function switchTab(string $tab): void
    {
        if (! in_array($tab, ['overview', 'promotions', 'details'], true)) {
            return;
        }

        $this->activeTab = $tab;
    }

    public function openPromotionWizard(): void
    {
        $this->showPromotionWizard = true;
        $this->resetPromotionWizard();
    }

    public function closePromotionWizard(): void
    {
        $this->showPromotionWizard = false;
        $this->resetPromotionWizard();
    }

    public function resetPromotionWizard(): void
    {
        $this->editingPromotionId = null;
        $this->promotionTypeFilter = 'all';
        $this->selectedPromotionPlanId = null;
        $this->selectedPromotionType = null;
        $this->contentBrief = '';
        $this->contentVariants = [];
        $this->selectedVariantKey = null;
        $this->isGeneratingContent = false;
        $this->resetErrorBag([
            'selectedPromotionPlanId',
            'contentBrief',
            'selectedVariantKey',
        ]);
    }

    public function choosePromotionType(string $filter): void
    {
        if (! in_array($filter, ['all', 'blog_post', 'newsletter', 'featured'], true)) {
            return;
        }

        $this->promotionTypeFilter = $filter;
    }

    public function selectPromotionPlan(int $planId): void
    {
        $plan = PromotionPlan::query()->find($planId);
        if (! $plan) {
            return;
        }

        $this->selectedPromotionPlanId = $plan->id;
        $this->selectedPromotionType = $plan->type;
        $this->contentVariants = [];
        $this->selectedVariantKey = null;
    }

    public function resumePendingPromotion(int $promotionId): void
    {
        $promotion = $this->findEditablePromotion($promotionId);
        if (! $promotion) {
            return;
        }

        $this->editingPromotionId = $promotion->id;
        $this->showPromotionWizard = true;
        $this->selectedPromotionPlanId = $promotion->promotion_plan_id;
        $this->selectedPromotionType = $promotion->plan?->type;
        $this->contentBrief = (string) ($promotion->content_brief ?? '');
        $this->promotionTypeFilter = $promotion->plan?->type ?? 'all';
        $this->contentVariants = [];
        $this->selectedVariantKey = null;

        if ($promotion->promotable instanceof Post) {
            $this->contentVariants = [[
                'key' => 'a',
                'title' => $promotion->promotable->title,
                'body' => (string) $promotion->promotable->content,
            ]];
            $this->selectedVariantKey = 'a';
        } elseif ($promotion->promotable instanceof Newsletter) {
            $this->contentVariants = [[
                'key' => 'a',
                'title' => $promotion->promotable->subject ?: $promotion->promotable->title,
                'body' => (string) $promotion->promotable->content,
            ]];
            $this->selectedVariantKey = 'a';
        }
    }

    public function continuePromotionPayment(int $promotionId): mixed
    {
        $promotion = $this->findEditablePromotion($promotionId);
        if (! $promotion) {
            $this->addError('promotion', __('This promotion cannot be paid for.'));

            return null;
        }

        $payment = $promotion->pendingPayment();
        if (! $payment) {
            $this->addError('promotion', __('No pending payment found. Resume setup to create a new checkout.'));

            return null;
        }

        return redirect()->route('seller.checkout', ['payment' => $payment->id]);
    }

    public function cancelPendingPromotion(int $promotionId): void
    {
        $promotion = $this->findEditablePromotion($promotionId);
        if (! $promotion) {
            return;
        }

        $promotion->payments()->where('status', 'pending')->update(['status' => 'cancelled']);
        $promotion->update(['status' => 'cancelled']);

        $this->property->load([
            'promotions.plan',
            'promotions.promotable',
            'promotions.payments',
        ]);

        session()->flash('status', __('Unpaid promotion cancelled.'));
    }

    protected function findEditablePromotion(int $promotionId): ?Promotion
    {
        $promotion = Promotion::query()
            ->whereKey($promotionId)
            ->where('property_id', $this->property->id)
            ->where('user_id', Auth::id())
            ->with(['plan', 'promotable', 'payments'])
            ->first();

        if (! $promotion?->isEditable()) {
            return null;
        }

        return $promotion;
    }

    public function generateContentOptions(): void
    {
        $plan = $this->selectedPromotionPlan;
        if (! $plan || ! in_array($plan->type, ['blog_post', 'newsletter'], true)) {
            return;
        }

        $this->isGeneratingContent = true;

        try {
            $this->contentVariants = app(ContentGenerationService::class)->generateVariants(
                $this->property,
                $plan,
                $this->contentBrief !== '' ? $this->contentBrief : null,
            );
            $this->selectedVariantKey = $this->contentVariants[0]['key'] ?? null;
        } finally {
            $this->isGeneratingContent = false;
        }
    }

    public function showNewsletterPreview(int $newsletterId): void
    {
        $linked = $this->property->promotions
            ->contains(fn (Promotion $promotion) => $promotion->promotable_type === Newsletter::class
                && (int) $promotion->promotable_id === $newsletterId);

        if (! $linked) {
            return;
        }

        $this->previewNewsletterId = $newsletterId;
    }

    public function closeNewsletterPreview(): void
    {
        $this->previewNewsletterId = null;
    }

    public function showPromotionPreview(int $promotionId): void
    {
        $this->previewPromotionId = $promotionId;
    }

    public function closePromotionPreview(): void
    {
        $this->previewPromotionId = null;
    }

    public function confirmPromotionPurchase(): mixed
    {
        $this->validate([
            'selectedPromotionPlanId' => ['required', 'exists:promotion_plans,id'],
            'contentBrief' => ['nullable', 'string', 'max:500'],
        ]);

        $plan = $this->selectedPromotionPlan;
        if (! $plan) {
            $this->addError('selectedPromotionPlanId', __('Please select a promotion plan.'));

            return null;
        }

        $quote = $this->selectedPromotionQuote;
        if (! $quote || ! $quote['currency_id']) {
            $this->addError('selectedPromotionPlanId', __('Unable to resolve price for your country/currency.'));

            return null;
        }

        if ($this->generationMode === 'ai' && in_array($plan->type, ['blog_post', 'newsletter'], true)) {
            if ($this->contentVariants === []) {
                $this->addError('selectedVariantKey', __('Generate and select one content option before checkout.'));

                return null;
            }

            $this->validate([
                'selectedVariantKey' => ['required', 'string'],
            ]);
        }

        $target = $plan->primaryTarget();

        if ($this->editingPromotionId) {
            $promotion = $this->findEditablePromotion($this->editingPromotionId);
            if (! $promotion) {
                $this->addError('selectedPromotionPlanId', __('This promotion can no longer be edited.'));

                return null;
            }

            $promotion->update([
                'promotion_plan_id' => $plan->id,
                'target_type' => $target['type'] ?? null,
                'target_count' => $target['count'] ?? 0,
                'content_brief' => $this->contentBrief !== '' ? $this->contentBrief : null,
            ]);
        } else {
            $promotion = Promotion::query()->create([
                'user_id' => Auth::id(),
                'property_id' => $this->property->id,
                'promotion_plan_id' => $plan->id,
                'start_at' => now(),
                'status' => 'pending_payment',
                'target_type' => $target['type'] ?? null,
                'target_count' => $target['count'] ?? 0,
                'content_brief' => $this->contentBrief !== '' ? $this->contentBrief : null,
                'audience_config' => ['strategy' => 'viewers_first_then_others'],
                'usage' => [],
            ]);
        }

        if ($this->generationMode === 'ai' && in_array($plan->type, ['blog_post', 'newsletter'], true)) {
            $variant = collect($this->contentVariants)->firstWhere('key', $this->selectedVariantKey);
            if ($variant) {
                if ($plan->type === 'blog_post') {
                    $post = Post::query()->create([
                        'user_id' => Auth::id(),
                        'category_id' => $this->property->category_id,
                        'property_id' => $this->property->id,
                        'title' => $variant['title'],
                        'slug' => 'promotion-post-'.Str::lower(Str::random(8)),
                        'excerpt' => Str::limit($variant['body'], 180),
                        'content' => $variant['body'],
                        'content_source' => 'ai',
                        'ai_generated_at' => now(),
                        'status' => 'published',
                        'tags' => [],
                    ]);

                    $primaryMedia = $this->property->media()->where('is_primary', true)->first() ?? $this->property->media()->first();
                    if ($primaryMedia) {
                        $newMedia = $primaryMedia->replicate();
                        $newMedia->mediable_type = Post::class;
                        $newMedia->mediable_id = $post->id;
                        $newMedia->save();
                    }

                    $promotion->update([
                        'promotable_type' => Post::class,
                        'promotable_id' => $post->id,
                    ]);
                } else {
                    $subject = Str::startsWith($variant['title'], 'Subject: ')
                        ? Str::after($variant['title'], 'Subject: ')
                        : $variant['title'];

                    $newsletter = Newsletter::query()->create([
                        'user_id' => Auth::id(),
                        'title' => 'Promotion newsletter: '.$this->property->name,
                        'subject' => $subject,
                        'content' => $variant['body'],
                        'audience_type' => 'auto_prioritized',
                        'audience_snapshot' => ['strategy' => 'viewers_first_then_others'],
                        'status' => 'draft',
                        'content_source' => 'ai',
                        'ai_generated_at' => now(),
                    ]);

                    $promotion->update([
                        'promotable_type' => Newsletter::class,
                        'promotable_id' => $newsletter->id,
                    ]);
                }
            }
        }

        $vatRate = 7.5;
        $amount = (float) $quote['amount'];
        $vatValue = round(($amount * $vatRate) / 100, 2);
        $total = round($amount + $vatValue, 2);

        $payment = $promotion->pendingPayment();

        $paymentPayload = [
            'user_id' => Auth::id(),
            'currency_id' => (int) $quote['currency_id'],
            'paymentable_id' => $promotion->id,
            'paymentable_type' => Promotion::class,
            'amount' => $amount,
            'coupon_value' => 0,
            'vat_rate' => $vatRate,
            'vat_value' => $vatValue,
            'total' => $total,
            'status' => 'pending',
        ];

        if ($payment) {
            $payment->update($paymentPayload);
        } else {
            $payment = Payment::query()->create(array_merge($paymentPayload, [
                'reference' => 'PROMO-'.Str::upper(Str::random(12)),
                'request_id' => null,
                'method' => null,
            ]));
        }

        $this->closePromotionWizard();
        session()->flash('status', __('Promotion created. Complete payment to activate it.'));

        return redirect()->route('seller.checkout', ['payment' => $payment->id]);
    }

    public function updatedEditCategoryId(mixed $value): void
    {
        $categoryId = $value !== null && $value !== '' ? (int) $value : null;
        $this->resetDynamicAttributesForCategory($categoryId);
    }

    public function updatedEditStateId(): void
    {
        $this->editCityId = null;
    }

    protected function syncEditFieldsFromProperty(): void
    {
        $this->editName = $this->property->name;
        $this->editDescription = $this->property->description;
        $this->editCost = (float) $this->property->cost;
        $this->editCategoryId = $this->property->category_id;
        $this->editStateId = $this->property->state_id;
        $this->editCityId = $this->property->city_id;
        $this->editAddress = (string) $this->property->address;
        $this->editNeighborhood = (string) ($this->property->neighborhood ?? '');
        $this->editShowAddress = (bool) $this->property->show_address;
        $this->editContactName = (string) $this->property->contact_name;
        $this->editContactPhone = (string) $this->property->contact_phone;
        $this->editContactEmail = (string) $this->property->contact_email;
        $this->editContactWhatsapp = (string) ($this->property->contact_whatsapp ?? '');
    }

    public function removeImage(int $index): void
    {
        if (isset($this->uploadedImages[$index])) {
            unset($this->uploadedImages[$index]);
            $this->uploadedImages = array_values($this->uploadedImages);
        }
    }

    public function removeExistingMedia(int $mediaId): void
    {
        $media = Media::query()
            ->where('mediable_type', Property::class)
            ->where('mediable_id', $this->property->id)
            ->whereKey($mediaId)
            ->first();

        if (! $media) {
            return;
        }

        $remaining = $this->property->media()->where('id', '!=', $mediaId)->count()
            + count($this->uploadedImages);

        if ($remaining < 1) {
            $this->addError('uploadedImages', __('At least one property image is required.'));

            return;
        }

        $media->deleteStoredFile();

        $media->delete();
        $this->property->load('media');
        $this->property->unsetRelation('media');
        $this->property->load('media');
    }

    public function updateProperty(): void
    {
        $existingMediaCount = $this->property->media()->count();
        $newCount = count($this->uploadedImages);
        $maxNew = max(0, 10 - $existingMediaCount);

        $this->validate([
            'editName' => ['required', 'string', 'max:255'],
            'editDescription' => ['required', 'string', 'min:20'],
            'editCost' => ['required', 'numeric', 'min:0'],
            'editCategoryId' => ['required', 'exists:categories,id'],
            'editStateId' => ['required', 'exists:states,id'],
            'editCityId' => ['required', 'exists:cities,id'],
            'editAddress' => ['required', 'string', 'max:255'],
            'editNeighborhood' => ['nullable', 'string', 'max:255'],
            'editShowAddress' => ['boolean'],
            'editContactName' => ['required', 'string', 'max:255'],
            'editContactPhone' => ['required', 'string', 'max:40'],
            'editContactEmail' => ['required', 'email', 'max:255'],
            'editContactWhatsapp' => ['nullable', 'string', 'max:40'],
            'uploadedImages' => ['nullable', 'array', 'max:'.$maxNew],
            'uploadedImages.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [], [
            ...$this->propertyListingValidationAttributes(),
            'editName' => 'property title',
            'editCategoryId' => 'listing category',
            'editCost' => 'cost',
            'editStateId' => 'state',
            'editCityId' => 'city/LGA',
        ]);

        if ($existingMediaCount + $newCount < 1) {
            $this->addError('uploadedImages', __('At least one property image is required.'));

            return;
        }

        $category = Category::query()->with('settings')->find($this->editCategoryId);
        $dynamicRules = $this->buildDynamicRules($category?->settings ?? collect());
        if ($dynamicRules !== []) {
            $this->validate($dynamicRules, [], $this->propertyListingValidationAttributes());
        }

        $this->property->update([
            'name' => $this->editName,
            'description' => $this->editDescription,
            'cost' => $this->editCost,
            'category_id' => $this->editCategoryId,
            'state_id' => $this->editStateId,
            'city_id' => $this->editCityId,
            'address' => $this->editAddress,
            'neighborhood' => $this->editNeighborhood !== '' ? $this->editNeighborhood : null,
            'show_address' => $this->editShowAddress,
            'location' => trim($this->editAddress.' '.$this->editNeighborhood),
            'contact_name' => $this->editContactName,
            'contact_phone' => $this->editContactPhone,
            'contact_email' => $this->editContactEmail,
            'contact_whatsapp' => $this->editContactWhatsapp !== '' ? $this->editContactWhatsapp : null,
        ]);

        $this->syncPropertyFeatures($this->property);
        $this->persistNewMedia();

        $this->uploadedImages = [];
        $this->property->refresh();
        $this->property->load(['media', 'features', 'category.settings']);
        $this->hydrateDynamicAttributesFromProperty($this->property);
        $this->syncEditFieldsFromProperty();

        session()->flash('status', __('Property updated successfully.'));
    }

    public function togglePublishStatus(): void
    {
        $this->property->update([
            'is_published' => !$this->property->is_published,
        ]);

        $status = $this->property->is_published ? 'published' : 'saved as draft';
        session()->flash('status', __("Property successfully {$status}."));
    }

    #[Computed]
    public function activeSubscription(): ?Subscription
    {
        return $this->currentSubscriptionAssignment;
    }

    #[Computed]
    public function currentSubscriptionAssignment(): ?Subscription
    {
        $link = $this->property->activeSubscribedPropertyLink;

        return $link?->subscription?->loadMissing('plan');
    }

    #[Computed]
    public function assignableSubscriptions()
    {
        $userId = Auth::id();
        $propertyId = $this->property->id;

        return Subscription::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->where('end_at', '>=', now())
            ->with('plan')
            ->withCount('subscribedProperties')
            ->orderByDesc('end_at')
            ->get()
            ->filter(function (Subscription $subscription) use ($propertyId) {
                $onThisPlan = $subscription->subscribedProperties()
                    ->where('property_id', $propertyId)
                    ->exists();

                return $onThisPlan || $subscription->remainingSeats() > 0;
            })
            ->values();
    }

    public function assignPropertyToSubscription(): void
    {
        $this->validate([
            'selectedSubscriptionId' => ['required', 'integer', 'exists:subscriptions,id'],
        ]);

        $subscription = Subscription::query()
            ->whereKey($this->selectedSubscriptionId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        app(ManagesSubscriptionProperties::class)->assign(
            $this->property,
            $subscription,
            Auth::user(),
        );

        $this->property->load(['subscribedPropertyLinks.subscription.plan']);
        $this->selectedSubscriptionId = null;
        unset($this->currentSubscriptionAssignment, $this->activeSubscription, $this->assignableSubscriptions);

        session()->flash('status', __('Property assigned to subscription.'));
    }

    public function removePropertyFromSubscription()
    {
        $subscription = $this->currentSubscriptionAssignment;
        if (! $subscription) {
            return;
        }

        app(ManagesSubscriptionProperties::class)->remove(
            $this->property,
            $subscription,
            Auth::user(),
        );

        $this->property->load(['subscribedPropertyLinks.subscription.plan']);
        unset($this->currentSubscriptionAssignment, $this->activeSubscription, $this->assignableSubscriptions);
        session()->flash('status', __('Property removed from subscription.'));
        return redirect(request()->header('Referer'));
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

    #[Computed]
    public function overviewStats(): array
    {
        return [
            'views' => (int) $this->property->viewed_by_users_count,
            'saves' => (int) $this->property->saved_by_users_count,
            'alerts' => (int) $this->property->alerts_count,
            'reports_count' => (int) $this->property->reports_count,
            'active_promotions' => $this->activePromotions->count(),
        ];
    }

    #[Computed]
    public function allPromotions()
    {
        return $this->property->promotions->sortByDesc('created_at')->values();
    }

    #[Computed]
    public function activePromotions()
    {
        return $this->allPromotions->filter(fn ($promotion) => $promotion->isInProgress());
    }

    #[Computed]
    public function pendingPaymentPromotions()
    {
        return $this->allPromotions->filter(fn ($promotion) => $promotion->isPendingPayment());
    }

    #[Computed]
    public function inactivePromotions()
    {
        return $this->allPromotions->filter(fn ($promotion) => ! $promotion->isInProgress() && ! $promotion->isPendingPayment());
    }

    #[Computed]
    public function orphanPosts()
    {
        $linkedPostIds = $this->allPromotions
            ->filter(fn ($p) => $p->promotable_type === Post::class && $p->promotable_id)
            ->pluck('promotable_id')
            ->all();

        return $this->property->posts
            ->reject(fn (Post $post) => in_array($post->id, $linkedPostIds, true))
            ->values();
    }

    #[Computed]
    public function recentReports()
    {
        return $this->property->reports()
            ->with('user:id,name')
            ->latest()
            ->limit(3)
            ->get();
    }

    #[Computed]
    public function featureLabels(): array
    {
        $labels = [];
        foreach ($this->property->category?->settings ?? [] as $setting) {
            $labels[$setting->key] = $setting->label;
        }

        return $labels;
    }

    #[Computed]
    public function activeCategorySettings()
    {
        if (! $this->editCategoryId) {
            return collect();
        }

        return Category::query()
            ->with('settings')
            ->find($this->editCategoryId)
            ?->settings ?? collect();
    }

    #[Computed]
    public function generationMode(): string
    {
        if (! (bool) Setting::getValue('ai.enabled', true)) {
            return 'manual';
        }

        $mode = (string) Setting::getValue('content.generation_mode', 'manual');

        return in_array($mode, ['manual', 'ai'], true) ? $mode : 'manual';
    }

    #[Computed]
    public function previewNewsletter(): ?Newsletter
    {
        if (! $this->previewNewsletterId) {
            return null;
        }

        return Newsletter::query()
            ->with('recipients')
            ->find($this->previewNewsletterId);
    }

    #[Computed]
    public function promotionPlans()
    {
        $plans = PromotionPlan::query()
            ->whereIn('type', ['featured', 'blog_post', 'newsletter'])
            ->orderBy('name', 'asc')
            ->get();

        if ($this->promotionTypeFilter !== 'all') {
            $plans = $plans->where('type', $this->promotionTypeFilter)->values();
        }

        $resolver = app(ResolvesPlanPrice::class);
        $user = Auth::user();
        if (! $user) {
            return collect();
        }

        return $plans->map(function (PromotionPlan $plan) use ($resolver, $user) {
            $quote = $resolver->forUser(PromotionPlan::class, $plan->id, $user);

            return [
                'plan' => $plan,
                'targets' => $plan->targetsForDisplay(),
                'quote' => $quote,
            ];
        });
    }

    #[Computed]
    public function selectedPromotionPlan(): ?PromotionPlan
    {
        if (! $this->selectedPromotionPlanId) {
            return null;
        }

        return PromotionPlan::query()->find($this->selectedPromotionPlanId);
    }

    #[Computed]
    public function selectedPromotionQuote(): ?array
    {
        $plan = $this->selectedPromotionPlan;
        $user = Auth::user();
        if (! $plan || ! $user) {
            return null;
        }

        return app(ResolvesPlanPrice::class)->forUser(PromotionPlan::class, $plan->id, $user);
    }

    protected function persistNewMedia(): void
    {
        $existingCount = $this->property->media()->count();

        foreach ($this->uploadedImages as $index => $file) {
            $storedPath = $file->store('properties', 'public');
            $extension = pathinfo($storedPath, PATHINFO_EXTENSION);

            $sequence = $existingCount + $index + 1;

            Media::query()->create([
                'user_id' => Auth::id(),
                'mediable_id' => $this->property->id,
                'mediable_type' => Property::class,
                'name' => Media::propertyImageLabel($this->property->name, $sequence),
                'path' => $storedPath,
                'type' => 'image',
                'mime_type' => $file->getMimeType(),
                'size' => (string) $file->getSize(),
                'extension' => $extension ?: null,
                'is_primary' => $existingCount === 0 && $index === 0,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.seller.property-details', [
            'categories' => Category::query()->with('settings')->orderBy('name', 'asc')->get(),
            'states' => State::query()->where('is_active', true)->orderBy('name', 'asc')->get(),
            'cities' => City::query()
                ->where('is_active', true)
                ->when($this->editStateId, fn ($q) => $q->where('state_id', $this->editStateId))
                ->orderBy('name', 'asc')
                ->get(),
        ]);
    }
}
