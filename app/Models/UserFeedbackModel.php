<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFeedbackModel extends Model
{
    protected $table = "user_feedbacks";
    protected $fillable = ['comment','user_id','date'];
    protected $hidden = ['created_at','updated_at'];

    public function replies(){
        return $this->hasMany('App\Models\FeedbackRepliesModel','feedback_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\UserModel','user_id');
    }

    public function scopeGetOnlyUser($query,$user){
        return $query->with('replies')->where('user_id',$user->id)->get();
    }

    public function scopeGetOnlyUserRepliesByID($query,$userID){
        return $query->with('replies')->where('user_id',$userID)->get();
    }

}
