<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Setting;
use Livewire\Component;

class AdminGeneral extends Component
{
    public string $generation_mode = 'manual';

    public int $manual_timeframe_hours = 24;

    public int $min_word_count = 400;

    public int $max_word_count = 1200;

    public function mount(): void
    {
        $this->generation_mode = (string) Setting::getValue('content.generation_mode', 'manual');
        if (! in_array($this->generation_mode, ['manual', 'ai'], true)) {
            $this->generation_mode = 'manual';
        }
        $this->manual_timeframe_hours = (int) Setting::getValue('content.manual_timeframe_hours', 24);
        $this->min_word_count = (int) Setting::getValue('content.min_word_count', 400);
        $this->max_word_count = (int) Setting::getValue('content.max_word_count', 1200);
    }

    protected function rules(): array
    {
        return [
            'generation_mode' => ['required', 'in:manual,ai'],
            'manual_timeframe_hours' => ['required', 'integer', 'min:1', 'max:8760'],
            'min_word_count' => ['required', 'integer', 'min:50', 'max:50000'],
            'max_word_count' => ['required', 'integer', 'min:50', 'max:50000', 'gte:min_word_count'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        Setting::setValue('content.generation_mode', $this->generation_mode, 'string');
        Setting::setValue('content.manual_timeframe_hours', $this->manual_timeframe_hours, 'integer');
        Setting::setValue('content.min_word_count', $this->min_word_count, 'integer');
        Setting::setValue('content.max_word_count', $this->max_word_count, 'integer');

        session()->flash('status', __('Content settings saved.'));
    }

    public function render()
    {
        return view('livewire.admin.admin-settings.general');
    }
}
