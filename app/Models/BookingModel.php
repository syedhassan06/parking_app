<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    protected $table = "bookings";
    protected $fillable = ['booking_date','start_time','end_time','location_id','area_id','booking_status','user_id','slot_id'];
    protected $hidden = ['created_at','updated_at'];
    protected $dates = ['booking_date'];
    protected $casts = [
        'start_time'  => 'time:g:ia',
        'end_time'  => 'time:g:ia',
        'booking_date'  => 'date:Y-m-d',
    ];
    protected $appends = ['formatted_start_time','formatted_end_time','full_booking_date'];

    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    public function location(){
        return $this->belongsTo('App\Models\LocationModel','location_id');
    }

    public function area(){
        return $this->belongsTo('App\Models\AreaModel','area_id');
    }

    public function slot(){
        return $this->belongsTo('App\Models\ParkingSlotModel','slot_id');
    }

    public function getFormattedStartTimeAttribute(){
        return date("h:i A",strtotime($this->start_time));
    }

    public function getFormattedEndTimeAttribute(){
        return date("h:i A",strtotime($this->end_time));
    }

    public function getFullBookingDateAttribute(){
        return $this->booking_date->format('d M, Y');
    }

    public function scopeGetAll($query,$user){
        if($user->role=='customer'){
            $query->where('user_id',$user->id);
        }else{
            $query->select('*');
        }
        return $query;
    }

    public function scopeGetTimeSlotBookings($query,$data){
        return $query->with('user','location','area','slot')
            ->where(function($query) use($data){
                return $query->where([
                    ['start_time','>=',$data['start_time']],
                    ['end_time','<=',$data['end_time']]
                ])->orWhere([
                    ['end_time','>=',$data['start_time']],
                    ['end_time','<=',$data['end_time']]
                ]);
            })
            ->where([
                [ 'location_id','=',$data['location_id'] ],
                [ 'area_id','=',$data['area_id'] ],
                [ 'booking_date','=',$data['booking_date'] ],
                ['booking_status','=','booked']
            ]);
    }

}
