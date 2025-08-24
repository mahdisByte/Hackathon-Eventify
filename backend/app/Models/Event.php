<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'event_id';  

 
    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'name',
        'description',
        'category',
        'location',
        'price',
        'available_time',
        'created_at',
        'updated_at'
    ];
}
