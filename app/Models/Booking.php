<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = [];

    public function pricingBreakdowns()
    {
        return $this->hasMany(PricingBreakdown::class);
    }

    public function passengers()
    {
        return $this->hasMany(PassengerOrGuest::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
