<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class UserModel extends Authenticatable
{
    use HasApiTokens , Notifiable;

    protected $table = "users";
    protected $fillable = ['name','email','password','phone','address','phone','username','role'];
    protected $hidden = ['created_at','updated_at','password'];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    public function scopeCustomerRole($query)
    {
        return $query->where('role','customer');
    }

    public function scopeExceptCurrentUser($query, $currentUserID)
    {
        return $query->where([['id','<>',$currentUserID]]);
    }

    public function bookings(){
        return $this->hasMany('App\Models\BookingModel','user_id');
    }

    public function feedbacks(){
        return $this->hasMany('App\Models\UserFeedbackModel','user_id');
    }
}
