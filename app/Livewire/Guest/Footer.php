<?php

namespace App\Livewire\Guest;

use App\Models\Category;
use App\Models\PropertyAlert;
use App\Models\User;
use App\Notifications\PropertyAlertWelcomeNotification;
use Illuminate\Support\Str;
use Livewire\Component;

class Footer extends Component
{
    public string $email = '';
    public string $categoryId = '';

    public ?string $statusMessage = null;
    public ?string $errorMessage = null;

    public function subscribe()
    {
        $this->validate([
            'email' => 'required|email|max:150',
            'categoryId' => 'required|exists:categories,id',
        ]);

        try {
            $user = User::query()->where('email', $this->email)->first();
            $password = null;

            if (! $user) {
                $password = Str::random(12);

                $user = User::query()->create([
                    'name' => Str::before($this->email, '@') ?: 'Subscriber',
                    'email' => $this->email,
                    'password' => bcrypt($password),
                    'email_verified_at' => now(),
                    'active_role' => 'buyer',
                ]);
            }

            PropertyAlert::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'category_id' => $this->categoryId,
                ],
                [
                    'type' => 'category',
                    'status' => 'active',
                ]
            );

            if ($password) {
                $user->notify(new PropertyAlertWelcomeNotification($user, $password));
            }

            $this->reset(['email', 'categoryId']);
            $this->statusMessage = 'Thank you! You have successfully subscribed to property alerts.';
            $this->errorMessage = null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Footer subscription error: ' . $e->getMessage());
            $this->errorMessage = 'An error occurred while subscribing. Please try again later.';
            $this->statusMessage = null;
        }
    }

    public function render()
    {
        return view('livewire.guest.footer', [
            'categories' => Category::all()
        ]);
    }
}
