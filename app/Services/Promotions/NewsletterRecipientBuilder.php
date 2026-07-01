<?php

namespace App\Services\Promotions;

use App\Models\Newsletter;
use App\Models\NewsletterRecipient;
use App\Models\Promotion;
use App\Models\Property;
use App\Models\PropertyAlert;
use App\Models\SavedProperty;
use App\Models\ViewedProperty;
use Illuminate\Support\Collection;

class NewsletterRecipientBuilder
{
    /**
     * Build recipients in priority order: property viewers, then savers, then property-alert subscribers.
     */
    public function buildFor(Newsletter $newsletter, Promotion $promotion, ?int $limit = null): int
    {
        $propertyId = (int) $promotion->property_id;
        $limit = $limit ?? max(1, (int) $promotion->target_count);
        $emails = collect();

        $viewerEmails = $this->emailsFromViewers($propertyId);
        $emails = $emails->merge($viewerEmails);

        $saverEmails = $this->emailsFromSavers($propertyId, $emails->keys()->all());
        $emails = $emails->merge($saverEmails);

        $alertEmails = $this->emailsFromPropertyAlerts($propertyId, $emails->keys()->all());
        $emails = $emails->merge($alertEmails);

        $created = 0;
        foreach ($emails->take($limit) as $email => $meta) {
            NewsletterRecipient::query()->firstOrCreate(
                [
                    'newsletter_id' => $newsletter->id,
                    'email' => $email,
                ],
                [
                    'user_id' => $meta['user_id'] ?? null,
                    'status' => 'queued',
                    'meta' => [
                        'source' => $meta['source'] ?? 'unknown',
                        'strategy' => 'viewers_first_then_others',
                    ],
                ]
            );
            $created++;
        }

        return $created;
    }

    /**
     * @return Collection<string, array{user_id: int|null, source: string}>
     */
    protected function emailsFromViewers(int $propertyId): Collection
    {
        $rows = ViewedProperty::query()
            ->where('property_id', $propertyId)
            ->with('user:id,email')
            ->get();

        return $this->mapUserEmails($rows->map(fn ($row) => [
            'user_id' => $row->user_id,
            'email' => $row->user?->email,
        ]), 'property_viewer');
    }

    /**
     * @param  list<int|string>  $excludeKeys
     * @return Collection<string, array{user_id: int|null, source: string}>
     */
    protected function emailsFromSavers(int $propertyId, array $excludeKeys = []): Collection
    {
        $rows = SavedProperty::query()
            ->where('property_id', $propertyId)
            ->with('user:id,email')
            ->get();

        return $this->mapUserEmails($rows->map(fn ($row) => [
            'user_id' => $row->user_id,
            'email' => $row->user?->email,
        ]), 'property_saver', $excludeKeys);
    }

    /**
     * @param  list<int|string>  $excludeKeys
     * @return Collection<string, array{user_id: int|null, source: string}>
     */
    protected function emailsFromPropertyAlerts(int $propertyId, array $excludeKeys = []): Collection
    {
        $rows = PropertyAlert::query()
            ->where('property_id', $propertyId)
            ->where('status', 'active')
            ->with('user:id,email')
            ->get();

        return $this->mapUserEmails($rows->map(fn ($row) => [
            'user_id' => $row->user_id,
            'email' => $row->user?->email,
        ]), 'property_alert', $excludeKeys);
    }

    /**
     * @param  Collection<int, array{user_id: int|null, email: string|null}>  $rows
     * @param  list<int|string>  $excludeKeys
     * @return Collection<string, array{user_id: int|null, source: string}>
     */
    protected function mapUserEmails(Collection $rows, string $source, array $excludeKeys = []): Collection
    {
        $mapped = collect();

        foreach ($rows as $row) {
            $email = strtolower(trim((string) ($row['email'] ?? '')));
            if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            $key = $row['user_id'] ?? $email;
            if (in_array($key, $excludeKeys, true) || $mapped->has($email)) {
                continue;
            }

            $mapped->put($email, [
                'user_id' => $row['user_id'],
                'source' => $source,
            ]);
        }

        return $mapped;
    }
}
