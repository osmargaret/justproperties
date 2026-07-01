<?php

namespace App\Services\Promotions;

use App\Models\Newsletter;
use App\Models\Promotion;
use App\Models\PromotionPlan;

class ActivatesPromotionAfterPayment
{
    public function __construct(
        protected CreatesPromotionDeliverable $createsPromotionDeliverable,
        protected NewsletterRecipientBuilder $newsletterRecipientBuilder,
    ) {}

    public function activate(Promotion $promotion): void
    {
        $promotion->loadMissing('plan');

        $hasDeliverable = $promotion->promotable_type && $promotion->promotable_id;

        if (! $hasDeliverable && $promotion->plan?->type !== 'featured') {
            $promotion->status = 'pending_content';
            $promotion->save();

            return;
        }

        if (! $hasDeliverable) {
            $this->createsPromotionDeliverable->createFor($promotion);
            $promotion->refresh();
        }

        if ($promotion->plan?->type === 'newsletter' && $promotion->promotable_type === Newsletter::class) {
            $newsletter = Newsletter::query()->find($promotion->promotable_id);
            if ($newsletter) {
                $this->newsletterRecipientBuilder->buildFor($newsletter, $promotion);
            }
        }

        $promotion->status = 'active';
        $promotion->start_at = $promotion->start_at ?? now();
        $promotion->save();
    }
}
