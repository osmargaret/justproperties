<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::setValue('ai.enabled', true, 'boolean');
        Setting::setValue('content.generation_mode', 'manual', 'string');
        Setting::setValue('content.manual_timeframe_hours', 24, 'integer');
        Setting::setValue('content.min_word_count', 400, 'integer');
        Setting::setValue('content.max_word_count', 1200, 'integer');
        Setting::setValue('ai.content_providers', [], 'json');
        Setting::setValue('ai.temperature', '0.7', 'string');
        Setting::setValue('ai.max_tokens', 1200, 'integer');
        Setting::setValue('ai.timeout_seconds', 30, 'integer');
        Setting::setValue('ai.rate_limit_per_user_per_day', 20, 'integer');
    }
}
