<?php

namespace Tests\Unit\Services;

use App\Models\Setting;
use App\Services\Ai\AiProviderRegistry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AiProviderRegistryTest extends TestCase
{
    use RefreshDatabase;

    public function test_stores_and_resolves_default_content_provider(): void
    {
        Setting::setValue('ai.content_providers', [
            [
                'id' => 'openai-1',
                'provider' => 'openai',
                'model' => 'gpt-4o-mini',
                'label' => 'OpenAI fast',
                'is_default' => false,
            ],
            [
                'id' => 'deepseek-1',
                'provider' => 'deepseek',
                'model' => 'deepseek-chat',
                'label' => 'DeepSeek',
                'is_default' => true,
            ],
        ], 'json');

        config()->set('ai.providers.openai.key', 'test-openai');
        config()->set('ai.providers.deepseek.key', 'test-deepseek');

        $default = app(AiProviderRegistry::class)->defaultContentProvider();

        $this->assertSame('deepseek', $default['provider']);
        $this->assertSame('deepseek-chat', $default['model']);
    }

    public function test_normalizes_rows_and_assigns_default_when_missing(): void
    {
        $normalized = app(AiProviderRegistry::class)->normalizeContentProviders([
            ['provider' => 'openai', 'model' => 'gpt-4o'],
        ]);

        $this->assertCount(1, $normalized);
        $this->assertTrue($normalized[0]['is_default']);
    }
}
