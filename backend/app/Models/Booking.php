<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = "bookings";



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function event() {
    return $this->belongsTo(Event::class, 'event_id', 'event_id');
}
}
