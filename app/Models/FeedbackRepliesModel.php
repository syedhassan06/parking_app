<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackRepliesModel extends Model
{
    protected $table = "feedback_replies";
    protected $fillable = ['feedback_id','reply','date'];
    protected $hidden = ['created_at','updated_at'];
    protected $dates = ['booking_date'];

    public function userFeedback(){
        return $this->belongsTo('App\Models\UserFeedbackModel','feedback_id');
    }
}
