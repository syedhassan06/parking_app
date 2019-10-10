<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaModel extends Model
{
    protected $table = "areas";
    protected $guarded = [];
    protected $hidden = ['created_at','updated_at'];

    public function bookings(){
        return $this->hasMany('App\Models\AreaModel','area_id');
    }
}
