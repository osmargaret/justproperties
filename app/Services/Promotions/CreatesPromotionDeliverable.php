<?php

namespace App\Services\Promotions;

use App\Models\FeaturedProperty;
use App\Models\Newsletter;
use App\Models\Post;
use App\Models\Promotion;
use App\Models\PromotionPlan;

class CreatesPromotionDeliverable
{
    public function createFor(Promotion $promotion): void
    {
        $promotion->loadMissing('property.category', 'plan');

        $planType = $promotion->plan?->type;

        if ($planType === 'featured') {
            $deliverable = FeaturedProperty::query()->create([
                'property_id' => $promotion->property_id,
                'target_type' => $promotion->target_type ?: 'clicks',
                'target_count' => max(0, (int) $promotion->target_count),
                'start_at' => now(),
                'status' => 'active',
            ]);

            $promotion->update([
                'promotable_type' => FeaturedProperty::class,
                'promotable_id' => $deliverable->id,
            ]);

            return;
        }

        if ($planType === 'blog_post') {
            if ($promotion->promotable_type && $promotion->promotable_id) {
                return;
            }

            $post = Post::query()->create([
                'user_id' => $promotion->user_id,
                'category_id' => $promotion->property?->category_id,
                'property_id' => $promotion->property_id,
                'title' => 'Promotion post: '.$promotion->property?->name,
                'slug' => 'promotion-post-'.$promotion->id,
                'excerpt' => null,
                'content' => 'Content will be provided shortly.',
                'content_source' => 'manual',
                'status' => 'draft',
                'tags' => [],
            ]);

            $promotion->update([
                'promotable_type' => Post::class,
                'promotable_id' => $post->id,
            ]);

            return;
        }

        if ($planType === 'newsletter') {
            if ($promotion->promotable_type && $promotion->promotable_id) {
                return;
            }

            $newsletter = Newsletter::query()->create([
                'user_id' => $promotion->user_id,
                'title' => 'Promotion newsletter: '.$promotion->property?->name,
                'subject' => null,
                'content' => 'Content will be provided shortly.',
                'audience_type' => 'auto_prioritized',
                'audience_snapshot' => $promotion->audience_config ?: ['strategy' => 'viewers_first_then_others'],
                'content_source' => 'manual',
                'status' => 'draft',
            ]);

            $promotion->update([
                'promotable_type' => Newsletter::class,
                'promotable_id' => $newsletter->id,
            ]);
        }
    }
}
