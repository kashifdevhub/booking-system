<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassengerOrGuest extends Model
{
    protected $table = 'passengers_or_guests';

    protected $guarded = [];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
