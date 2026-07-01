<?php

namespace App\Services\Content;

use App\Models\PromotionPlan;
use App\Models\Property;
use App\Models\Setting;
use App\Services\Ai\AiChatCompletionClient;
use App\Services\Ai\AiProviderRegistry;
use Illuminate\Support\Str;

class ContentGenerationService
{
    public function __construct(
        protected AiProviderRegistry $providerRegistry,
        protected AiChatCompletionClient $chatClient,
    ) {}

    /**
     * @return array<int, array{key: string, title: string, body: string}>
     */
    public function generateVariants(Property $property, PromotionPlan $plan, ?string $brief = null): array
    {
        if ($this->shouldUseProvider()) {
            try {
                $variants = $this->generateViaProvider($property, $plan, $brief);
                if ($variants !== []) {
                    return $variants;
                }
            } catch (\Throwable) {
                // Fall back to local templates when provider is unavailable.
            }
        }

        return $this->generateTemplateVariants($property, $plan, $brief);
    }

    public function shouldUseProvider(): bool
    {
        if (! (bool) Setting::getValue('ai.enabled', true)) {
            return false;
        }

        if ((string) Setting::getValue('content.generation_mode', 'manual') !== 'ai') {
            return false;
        }

        $default = $this->providerRegistry->defaultContentProvider();

        return $default !== null
            && $this->providerRegistry->isConfigured((string) $default['provider']);
    }

    /**
     * @return array<int, array{key: string, title: string, body: string}>
     */
    protected function generateViaProvider(Property $property, PromotionPlan $plan, ?string $brief): array
    {
        $temperature = (float) Setting::getValue('ai.temperature', '0.7');
        $maxTokens = (int) Setting::getValue('ai.max_tokens', 1200);
        $timeout = (int) Setting::getValue('ai.timeout_seconds', 30);
        $minWords = (int) Setting::getValue('content.min_word_count', 400);
        $maxWords = (int) Setting::getValue('content.max_word_count', 1200);

        $property->loadMissing(['category', 'features', 'media']);

        $context = $this->buildPropertyContext($property, $brief);
        $contentType = $plan->type === 'newsletter' ? 'newsletter email' : 'blog post';

        $system = "You write detailed, comprehensive real-estate marketing copy. Return strict JSON only: {\"variants\":[{\"key\":\"a\",\"title\":\"...\",\"body\":\"...\"},{\"key\":\"b\",\"title\":\"...\",\"body\":\"...\"}]}. The body MUST be long and detailed, strictly between {$minWords} and {$maxWords} words. Use HTML paragraphs and formatting.";

        $content = $this->chatClient->chat([
            ['role' => 'system', 'content' => $system],
            ['role' => 'user', 'content' => "Create two distinct, comprehensive {$contentType} variants for this property. Ensure you incorporate the property features and category naturally into the text:\n\n{$context}"],
        ], options: [
            'temperature' => $temperature,
            'max_tokens' => $maxTokens,
            'timeout' => $timeout,
        ]);

        $decoded = json_decode($content, true);

        if (! is_array($decoded) || ! isset($decoded['variants']) || ! is_array($decoded['variants'])) {
            throw new \RuntimeException('Invalid AI JSON payload.');
        }

        $variants = [];
        foreach ($decoded['variants'] as $index => $variant) {
            if (! is_array($variant)) {
                continue;
            }
            $key = (string) ($variant['key'] ?? chr(97 + $index));
            $title = trim((string) ($variant['title'] ?? ''));
            $body = trim((string) ($variant['body'] ?? ''));
            if ($title === '' || $body === '') {
                continue;
            }
            $variants[] = ['key' => $key, 'title' => $title, 'body' => $body];
        }

        return array_slice($variants, 0, 2);
    }

    /**
     * @return array<int, array{key: string, title: string, body: string}>
     */
    protected function generateTemplateVariants(Property $property, PromotionPlan $plan, ?string $brief): array
    {
        $titleBase = $property->name;
        $category = $property->category?->name ?? 'Property';
        $location = $property->display_location;
        $briefText = trim((string) $brief);

        if ($plan->type === 'blog_post') {
            return [
                [
                    'key' => 'a',
                    'title' => "Inside {$titleBase}: features and neighborhood highlights",
                    'body' => "Discover {$titleBase} in {$location}. This article covers standout amenities, pricing context, and buyer-fit details.\n\nCategory: {$category}.\n".($briefText !== '' ? "Seller direction: {$briefText}\n" : '')."\nContact the seller for a private walkthrough.",
                ],
                [
                    'key' => 'b',
                    'title' => "{$titleBase}: buyer checklist before you make an offer",
                    'body' => "Thinking about {$titleBase}? This guide gives a practical checklist: layout review, location fit in {$location}, and financing readiness.\n\nCategory: {$category}.\n".($briefText !== '' ? "Seller direction: {$briefText}\n" : '')."\nSchedule a visit to verify your shortlist.",
                ],
            ];
        }

        return [
            [
                'key' => 'a',
                'title' => "Subject: New listing update for {$titleBase}",
                'body' => "Hello,\n\nA new opportunity just opened: {$titleBase} ({$category}) in {$location}.\n".($briefText !== '' ? "Seller note: {$briefText}\n\n" : "\n")."We are prioritizing buyers who have shown interest in this property.\n\nReply to book a viewing.",
            ],
            [
                'key' => 'b',
                'title' => "Subject: Your shortlist alert — {$titleBase}",
                'body' => "Hi there,\n\n{$titleBase} is now available and may match your recent preferences around {$location}.\n".($briefText !== '' ? "Seller note: {$briefText}\n\n" : "\n")."Early inquiries get priority responses.\n\nClick through to review details and schedule a tour.",
            ],
        ];
    }

    protected function buildPropertyContext(Property $property, ?string $brief): string
    {
        $features = $property->features
            ->map(fn ($feature) => "{$feature->feature}: {$feature->value}")
            ->implode(', ');

        $lines = [
            "Name: {$property->name}",
            'Description: '.Str::limit($property->description, 1200),
            'Category: '.($property->category?->name ?? 'N/A'),
            "Location: {$property->display_location}",
            'Price: '.$property->cost,
            'Features: '.($features !== '' ? $features : 'N/A'),
        ];

        if (trim((string) $brief) !== '') {
            $lines[] = 'Seller direction: '.$brief;
        }

        return implode("\n", $lines);
    }
}
