<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'image',
    'description',
    'placement',
    'company',
    'email',
    'amount',
    'payment_method',
    'payment_status',
    'receipt',
    'start_date',
    'end_date',
])]
class Advertisement extends Model
{
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'amount' => 'decimal:2',
        ];
    }
}
