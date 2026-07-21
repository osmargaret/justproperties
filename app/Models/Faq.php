<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['question', 'answer', 'is_active', 'show_on_contact_page'])]
class Faq extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'show_on_contact_page' => 'boolean',
        ];
    }
}
