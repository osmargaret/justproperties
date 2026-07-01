<?php

namespace App\Services\Ai;

use Illuminate\Support\Facades\Http;

class AiChatCompletionClient
{
    public function __construct(
        protected AiProviderRegistry $registry,
    ) {}

    /**
     * @param  list<array{role: string, content: string}>  $messages
     * @param  array{temperature?: float, max_tokens?: int, timeout?: int}  $options
     */
    public function chat(array $messages, ?string $provider = null, ?string $model = null, array $options = []): string
    {
        $connection = $provider && $model
            ? $this->registry->resolveConnection($provider, $model)
            : $this->registry->resolveDefaultConnection();

        $response = Http::withToken($connection['key'])
            ->acceptJson()
            ->timeout((int) ($options['timeout'] ?? 30))
            ->post("{$connection['base_url']}/chat/completions", [
                'model' => $connection['model'],
                'temperature' => (float) ($options['temperature'] ?? 0.7),
                'max_tokens' => (int) ($options['max_tokens'] ?? 1200),
                'messages' => $messages,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException(
                "AI request failed for {$connection['provider']} ({$response->status()})."
            );
        }

        $content = (string) data_get($response->json(), 'choices.0.message.content', '');

        if ($content === '') {
            throw new \RuntimeException('AI response was empty.');
        }

        return $content;
    }
}
