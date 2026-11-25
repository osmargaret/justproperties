<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['currency_code', 'currency_name', 'currency_symbol', 'payment_gateway', 'bank_details'])]
class Currency extends Model
{
    protected function casts(): array
    {
        return [
            'bank_details' => 'array',
        ];
    }

    public function promotionPlanPrices(): HasMany
    {
        return $this->hasMany(PromotionPlanPrice::class);
    }

    public function advertisementPlanPrices(): HasMany
    {
        return $this->hasMany(AdvertisementPlanPrice::class);
    }

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class, 'currency_code', 'currency_code');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'currency_code', 'currency_code')->withTrashed();
    }
}
