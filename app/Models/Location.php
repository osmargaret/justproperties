<?php

namespace App\Models;

use App\Models\State;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['ip','country_id','country_name','country_code','continent','state_id','state','city','is_proxy','is_vpn','proxy_checked_at','country_dial','suspended_at','suspension_reason','released_at','released_by'];

    protected $casts = [
        'suspended_at' => 'datetime',
        'released_at' => 'datetime',
        'proxy_checked_at' => 'datetime',
        'is_proxy' => 'boolean',
        'is_vpn' => 'boolean',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }

    public function scopeBlocked($query){
        return $query->whereNotNull('suspended_at')
                     ->where(function ($q) {
                         $q->whereNull('released_at')
                           ->orWhere('released_at', '>', now());
                     });
    }

    public function scopeReleased($query){
        return $query->whereNotNull('released_at')
                     ->where('released_at', '<=', now());
    }

    public function releasedBy(){
        return $this->belongsTo(User::class, 'released_by');
    }

    
}
