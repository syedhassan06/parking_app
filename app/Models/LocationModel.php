<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocationModel extends Model
{
    protected $table = "locations";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function bookings(){
        return $this->hasMany('App\Models\BookingModel','location_id');
    }
}
