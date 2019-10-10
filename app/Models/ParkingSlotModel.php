<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSlotModel extends Model
{
    protected $table = "parking_slots";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function bookings(){
        return $this->hasMany('App\Models\BookingModel','slot_id');
    }
}
