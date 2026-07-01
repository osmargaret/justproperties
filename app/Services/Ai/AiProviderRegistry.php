<?php

namespace App\Services\Ai;

use App\Models\Setting;
use Illuminate\Support\Str;

class AiProviderRegistry
{
    /**
     * @return array<string, array{label: string, key: ?string, base_url: string, models: array<int, string>, compatible: bool, configured: bool}>
     */
    public function all(): array
    {
        $providers = [];

        foreach (config('ai.providers', []) as $key => $config) {
            $providers[$key] = [
                'label' => (string) ($config['label'] ?? Str::headline($key)),
                'env_key' => (string) ($config['env_key'] ?? strtoupper($key).'_API_KEY'),
                'key' => $config['key'] ?? null,
                'base_url' => rtrim((string) ($config['base_url'] ?? ''), '/'),
                'models' => array_values($config['models'] ?? []),
                'compatible' => (bool) ($config['compatible'] ?? true),
                'configured' => filled($config['key'] ?? null),
            ];
        }

        return $providers;
    }

    /**
     * @return array<string, array{label: string, key: ?string, base_url: string, models: array<int, string>, compatible: bool, configured: bool}>
     */
    public function configured(): array
    {
        return array_filter($this->all(), fn (array $provider) => $provider['configured']);
    }

    public function isConfigured(string $provider): bool
    {
        return (bool) ($this->all()[$provider]['configured'] ?? false);
    }

    public function label(string $provider): string
    {
        return (string) ($this->all()[$provider]['label'] ?? Str::headline($provider));
    }

    /**
     * @return array<int, string>
     */
    public function suggestedModels(string $provider): array
    {
        return $this->all()[$provider]['models'] ?? [];
    }

    /**
     * @return array{id: string, provider: string, model: string, label: string, is_default: bool}|null
     */
    public function defaultContentProvider(): ?array
    {
        $providers = $this->contentProviders();

        if ($providers === []) {
            return null;
        }

        foreach ($providers as $row) {
            if (! empty($row['is_default']) && $this->isConfigured((string) $row['provider'])) {
                return $row;
            }
        }

        foreach ($providers as $row) {
            if ($this->isConfigured((string) $row['provider'])) {
                return $row;
            }
        }

        return $providers[0] ?? null;
    }

    /**
     * @return list<array{id: string, provider: string, model: string, label: string, is_default: bool}>
     */
    public function contentProviders(): array
    {
        $stored = Setting::getValue('ai.content_providers', []);

        if (is_array($stored) && $stored !== []) {
            return $this->normalizeContentProviders($stored);
        }

        $legacyProvider = (string) Setting::getValue('ai.provider', 'openai');
        $legacyModel = (string) Setting::getValue('ai.model', 'gpt-4o-mini');

        if ($legacyProvider === '' || $legacyModel === '') {
            return [];
        }

        return [[
            'id' => 'legacy-default',
            'provider' => $legacyProvider,
            'model' => $legacyModel,
            'label' => $this->label($legacyProvider),
            'is_default' => true,
        ]];
    }

    /**
     * @param  list<array<string, mixed>>  $rows
     * @return list<array{id: string, provider: string, model: string, label: string, is_default: bool}>
     */
    public function normalizeContentProviders(array $rows): array
    {
        $normalized = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $provider = (string) ($row['provider'] ?? '');
            $model = trim((string) ($row['model'] ?? ''));

            if ($provider === '' || $model === '') {
                continue;
            }

            $normalized[] = [
                'id' => (string) ($row['id'] ?? Str::uuid()->toString()),
                'provider' => $provider,
                'model' => $model,
                'label' => trim((string) ($row['label'] ?? '')),
                'is_default' => (bool) ($row['is_default'] ?? false),
            ];
        }

        if ($normalized !== [] && ! collect($normalized)->contains(fn (array $row) => $row['is_default'])) {
            $normalized[0]['is_default'] = true;
        }

        return $normalized;
    }

    /**
     * @return array{provider: string, model: string, label: string, key: string, base_url: string, compatible: bool}
     */
    public function resolveDefaultConnection(): array
    {
        $selected = $this->defaultContentProvider();

        if (! $selected) {
            throw new \RuntimeException('No AI content provider configured.');
        }

        return $this->resolveConnection((string) $selected['provider'], (string) $selected['model']);
    }

    /**
     * @return array{provider: string, model: string, label: string, key: string, base_url: string, compatible: bool}
     */
    public function resolveConnection(string $provider, string $model): array
    {
        $config = $this->all()[$provider] ?? null;

        if (! $config || ! $config['configured']) {
            throw new \RuntimeException("AI provider [{$provider}] is not configured.");
        }

        if (! $config['compatible']) {
            throw new \RuntimeException("AI provider [{$provider}] is not yet supported for content generation.");
        }

        return [
            'provider' => $provider,
            'model' => $model,
            'label' => $config['label'],
            'key' => (string) $config['key'],
            'base_url' => $config['base_url'],
            'compatible' => $config['compatible'],
        ];
    }
}
