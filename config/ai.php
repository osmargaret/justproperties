<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI provider registry
    |--------------------------------------------------------------------------
    |
    | Add providers here. API keys stay in .env; admins pick provider + model
    | combinations in General settings. All providers use OpenAI-compatible
    | chat/completions endpoints unless noted otherwise.
    |
    */

    'providers' => [
        'openai' => [
            'label' => 'OpenAI',
            'env_key' => 'OPENAI_API_KEY',
            'key' => env('OPENAI_API_KEY'),
            'base_url' => env('OPENAI_BASE_URL', 'https://api.openai.com/v1'),
            'models' => [
                'gpt-4o-mini',
                'gpt-4o',
                'gpt-4.1-mini',
                'gpt-4.1',
            ],
        ],

        'deepseek' => [
            'label' => 'DeepSeek',
            'env_key' => 'DEEPSEEK_API_KEY',
            'key' => env('DEEPSEEK_API_KEY'),
            'base_url' => env('DEEPSEEK_BASE_URL', 'https://api.deepseek.com/v1'),
            'models' => [
                'deepseek-v4-flash',
                'deepseek-chat',
                'deepseek-reasoner',
            ],
        ],

        'anthropic' => [
            'label' => 'Anthropic',
            'env_key' => 'ANTHROPIC_API_KEY',
            'key' => env('ANTHROPIC_API_KEY'),
            'base_url' => env('ANTHROPIC_BASE_URL', 'https://api.anthropic.com/v1'),
            'compatible' => false,
            'models' => [
                'claude-sonnet-4-20250514',
                'claude-3-5-haiku-20241022',
            ],
        ],

        'google' => [
            'label' => 'Google Gemini',
            'env_key' => 'GEMINI_API_KEY',
            'key' => env('GEMINI_API_KEY', env('GOOGLE_AI_API_KEY')),
            'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta/openai'),
            'models' => [
                'gemini-2.0-flash',
                'gemini-1.5-pro',
            ],
        ],
    ],

];
