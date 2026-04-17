<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $fillable = ['property_id', 'user_id', 'date', 'time', 'status'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
