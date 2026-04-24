<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwoFactorChallengeTest extends TestCase
{
    use RefreshDatabase;

    public function test_two_factor_challenge_page_can_be_rendered(): void
    {
        $this->get(route('two-factor.login'))
            ->assertOk()
            ->assertSee('Two-step verification');
    }
}
