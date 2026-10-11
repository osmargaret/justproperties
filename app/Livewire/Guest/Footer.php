<?php

namespace App\Livewire\Guest;

use App\Models\Category;
use App\Models\BlogSubscription;
use Livewire\Component;

class Footer extends Component
{
    public string $email = '';
    public ?int $categoryId = null;
    public ?string $statusMessage = null;
    public ?string $errorMessage = null;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email:rfc,dns', 'max:255'],
            'categoryId' => ['required', 'integer', 'exists:categories,id'],
        ];
    }

    public function subscribe(): void
    {
        $this->validate();

        try {
            $email = mb_strtolower(trim($this->email));
            $exists = BlogSubscription::query()
                ->where('email', $email)
                ->where('category_id', $this->categoryId)
                ->exists();

            if ($exists) {
                $this->errorMessage = 'You are already subscribed to this category.';
                $this->statusMessage = null;
                return;
            }

            BlogSubscription::query()->create([
                'email' => $email,
                'category_id' => $this->categoryId,
                'get_new_posts' => true,
                'get_comments' => false,
            ]);

            $this->reset(['email', 'categoryId']);
            $this->statusMessage = 'Successfully subscribed to property alerts!';
            $this->errorMessage = null;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Footer subscription error: ' . $e->getMessage());
            $this->errorMessage = 'An error occurred while subscribing. Please try again later.';
            $this->statusMessage = null;
        }
    }

    public function render()
    {
        $propertyCategories = Category::query()->where('is_property', true)->orderBy('name', 'asc')->get();
        $nonPropertyCategories = Category::query()->where('is_property', false)->orderBy('name', 'asc')->get();
        
        return view('livewire.guest.footer', [
            'propertyCategories' => $propertyCategories,
            'nonPropertyCategories' => $nonPropertyCategories,
        ]);
    }
}
