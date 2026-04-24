<?php

namespace App\Livewire\Settings\TwoFactor;

use Livewire\Attributes\Locked;
use Livewire\Component;

class RecoveryCodes extends Component
{
    #[Locked]
    public array $recoveryCodes = [];

    public function mount(): void
    {
        $this->recoveryCodes = [];
    }

    public function regenerateRecoveryCodes(): void
    {
        // Two-factor recovery is not wired in this build.
        session()->flash('status', __('Recovery codes are not available in this build.'));
    }

    public function render()
    {
        return view('livewire.buyer.settings.two-factor.recovery-codes');
    }
}
