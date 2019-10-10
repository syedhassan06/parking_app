<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Models\FeedbackRepliesModel;
use App\Models\UserFeedbackModel;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    private $request;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    function index(){
        $page = $this->pageDetails('manage');
        return view('booking/booking-list',compact('page'));
    }

    public function write($id = null){
        $feedbacks = UserFeedbackModel::getOnlyUser($this->user);
        return view('feedback/feedback-form',compact('feedbacks'));
    }

    public function save(FeedbackRequest $request){
        $data= $request->all();
        $feedback = new UserFeedbackModel();
        $feedback->fill(array_merge($data,[
            'user_id'=>$data['user_id'],
            'date'=>Carbon::parse(Carbon::now())->format('Y-m-d')
        ]));
        if ($feedback->save()) {
            return redirect()->route('feedback_write')->with('success', trans('general.feedback_success'));
        }
    }

    public function userReplies(){
        $users = UserModel::customerRole()->get();
        $dataSource = [
            'users'=>  $users,
            'routes'=>[ 'api_user_reply'=>route('api_user_reply'), 'api_post_user_reply'=>route('api_post_user_reply') ]
        ];
        \JavaScript::put($dataSource);
        return view('feedback/feedback-reply', compact('dataSource','users'));
    }

    public function getUserReplies(){
        try{
            $userId = $this->request->user_id;
            $feedbacks = UserFeedbackModel::getonlyUserRepliesByID($userId);
            return response()->json([
                'status'=>true,
                'data'=>$feedbacks,
                'message'=>''
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>$e->getMessage()
            ],200);
        }

    }

    public function postUserReplies(){
        try{
            $status = FeedbackRepliesModel::create(array_merge($this->request->all(),['date'=>Carbon::parse(Carbon::now())->format('Y-m-d')]));
            $feedbacks = [];
            if($this->request->input('user_id')){
                $feedbacks = UserFeedbackModel::getonlyUserRepliesByID($this->request->input('user_id'));
            }
            return response()->json([
                'status'=>true,
                'data'=>$feedbacks,
                'message'=>trans('general.comment_success')
            ],200);
        }catch(Exception $e){
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>$e->getMessage()
            ],200);
        }

    }
}
