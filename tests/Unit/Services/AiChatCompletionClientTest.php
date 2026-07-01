<?php

namespace Tests\Unit\Services;

use App\Models\Setting;
use App\Services\Ai\AiChatCompletionClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AiChatCompletionClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_uses_default_provider_from_settings(): void
    {
        config()->set('ai.providers.deepseek.key', 'secret');
        config()->set('ai.providers.deepseek.base_url', 'https://api.deepseek.com/v1');

        Setting::setValue('ai.content_providers', [[
            'id' => 'ds-1',
            'provider' => 'deepseek',
            'model' => 'deepseek-chat',
            'label' => 'DeepSeek',
            'is_default' => true,
        ]], 'json');

        Http::fake([
            'api.deepseek.com/v1/chat/completions' => Http::response([
                'choices' => [
                    ['message' => ['content' => '{"variants":[]}']],
                ],
            ]),
        ]);

        $content = app(AiChatCompletionClient::class)->chat([
            ['role' => 'user', 'content' => 'Hello'],
        ]);

        $this->assertStringContainsString('variants', $content);

        Http::assertSent(function ($request) {
            return str_contains($request->url(), 'api.deepseek.com/v1/chat/completions')
                && $request['model'] === 'deepseek-chat';
        });
    }
}
