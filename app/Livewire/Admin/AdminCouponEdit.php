<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use Illuminate\Validation\Rule;
use Livewire\Component;

class AdminCouponEdit extends Component
{
    public Coupon $coupon;

    public string $name = '';

    public string $code = '';

    public int $quantity = 1;

    public ?int $limit_per_user = null;

    public ?int $limit_for_user = null;

    public ?string $start_at = null;

    public ?string $expires_at = null;

    public bool $is_percentage = false;

    public string $discount = '0';

    public ?string $discount_cap = null;

    public ?string $minimum_spend = null;

    public bool $is_published = false;

    public function mount(Coupon $coupon): void
    {
        $this->coupon = $coupon;
        $this->name = $coupon->name;
        $this->code = $coupon->code;
        $this->quantity = (int) $coupon->quantity;
        $this->limit_per_user = $coupon->limit_per_user;
        $this->limit_for_user = $coupon->limit_for_user;
        $this->start_at = $coupon->start_at?->format('Y-m-d\TH:i');
        $this->expires_at = $coupon->expires_at?->format('Y-m-d\TH:i');
        $this->is_percentage = (bool) $coupon->is_percentage;
        $this->discount = (string) $coupon->discount;
        $this->discount_cap = $coupon->discount_cap !== null ? (string) $coupon->discount_cap : null;
        $this->minimum_spend = $coupon->minimum_spend !== null ? (string) $coupon->minimum_spend : null;
        $this->is_published = (bool) $coupon->is_published;
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:64', Rule::unique('coupons', 'code')->ignore($this->coupon->id)],
            'quantity' => ['required', 'integer', 'min:1'],
            'limit_per_user' => ['nullable', 'integer', 'min:1'],
            'limit_for_user' => ['nullable', 'integer', 'min:1'],
            'start_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'is_percentage' => ['boolean'],
            'discount' => ['required', 'numeric', 'min:0'],
            'discount_cap' => ['nullable', 'numeric', 'min:0'],
            'minimum_spend' => ['nullable', 'numeric', 'min:0'],
            'is_published' => ['boolean'],
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->coupon->update([
            'name' => $this->name,
            'code' => strtoupper(trim($this->code)),
            'quantity' => $this->quantity,
            'limit_per_user' => $this->limit_per_user,
            'limit_for_user' => $this->limit_for_user,
            'start_at' => $this->start_at ?: null,
            'expires_at' => $this->expires_at ?: null,
            'is_percentage' => $this->is_percentage,
            'discount' => $this->discount,
            'discount_cap' => $this->discount_cap,
            'minimum_spend' => $this->minimum_spend,
            'is_published' => $this->is_published,
        ]);

        session()->flash('status', __('Coupon updated.'));
    }

    public function render()
    {
        return view('livewire.admin.admin-coupon-form', [
            'heading' => __('Edit coupon'),
            'submitLabel' => __('Save'),
        ]);
    }
}
