<?php

namespace App\Http\Controllers;

use App\Traits\HTMLPresenter;
use Illuminate\Http\Request;
use App\Models\UserModel;
use DB;
use Matrix\Exception;
use Yajra\DataTables\Facades\DataTables;
use Carbon;

class UserController extends Controller
{
    use HTMLPresenter;

    private $request;
    private $authUser;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->authUser = \Auth::user();
            return $next($request);
        });
        $this->request = $request;
    }

    function index(){
        $users = UserModel::all();
        $page = $this->pageDetails('manage');
        return view('user/customer',compact('users','page'));
    }

    public function buildFormValidation($formType=''){
        $userID = ($this->authUser && $this->authUser->role=="customer")? $this->authUser->id : $this->request->input('id');
        $validationRules = [
            'user_id' => 'sometimes|required',
            'name' => 'required',
            'email' => 'email|unique:users,email,' . $userID . ',id',
            'username' => 'nullable|unique:users,username,' . $userID . ',id'
        ];
        $validationMsgs = [
            'username.unique' => 'The User ID has already been taken.'
        ];

        if($formType==='PROFILE'){
            $validationRules = array_collapse([
                $validationRules,
                [
                    'password' => 'nullable|min:6|same:cpassword',
                    'cpassword' => 'nullable|min:6'
                ]
            ]);
        }
        $this->validate($this->request, $validationRules,$validationMsgs);
    }

    public function create($id = null){
        if ($id) {
            $userEntity = UserModel::find($id);
        } else {
            $userEntity = new UserModel;
        }
        $page = $this->pageDetails($userEntity->id ? 'edit' : 'add');
        return view('user/customer-form', compact('userEntity','page'));
    }

    private function pageDetails($action)
    {
        if ($action == "add") {
            return [
                'action'=>'add',
                'successMsg' => trans('user.added'),
                'title' => trans('user.addCustomer'),
                'icon'=>'<i class="icon-user-follow"></i> '
            ];
        }else if ($action == "edit") {
            return [
                'action'=>'update',
                'successMsg' => trans('user.updated'),
                'title' => trans('user.editCustomer'),
                'icon'=>'<i class="icon-user-following"></i> '
            ];
        }else if ($action == "manage") {
            return [
                'action'=>'manage',
                'successMsg' => trans('user.updated'),
                'title' => trans('user.manageCustomer'),
                'icon'=>'<i class="icon-users"></i> '
            ];
        }
    }

    function save()
    {
        $this->buildFormValidation();
        $data = $this->request->all();
        $data['password'] = bcrypt($data['password']);
        unset($data['cpassword']);
        if (isset($data['id'])) {
            $user = UserModel::find($data['id']);
        } else {
            $user = new UserModel();
            $user->role="admin";
        }
        $user->fill($data);
        $page = $this->pageDetails($user->id ? 'edit' : 'add');
        if ($user->save()) {
            return redirect()->route('user_manage')->with('success', $page['successMsg']);
        }
    }

    function getAll(){
        $users = UserModel::exceptCurrentUser($this->user->id);
        return Datatables::eloquent($users)
            ->addColumn('action', function(UserModel $userModel) {
                $template = '
                     <a data-toggle="tooltip" data-placement="left" title="Edit" class="primary cgi-tooltip" href="'. route('user_edit',[$userModel->id]) .'"><i  class="la la-pencil-square"></i></a>
                    ';
                return $template;
            })
            ->make(true);
    }

    function activate(){
        try{
            $data = $this->request->all();
            $fields = [
                'active'=>$data['active']
            ];
            $user = UserModel::find($data['customer_id']);
            $user->fill($fields);
            $result = $user->update();
            if($result){
                $meta = ['name'=>ucwords($user->name)];
                return response()->json([
                    'status'=>true,
                    'data'=>$user,
                    'message'=>$fields['active']?trans('user.activated',$meta):trans('user.deActivated',$meta)
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'data'=>null,
                    'message'=>'Something went wrong'
                ],200);
            }
        }catch(Exception $e){
            return response()->json([
                'status'=>false,
                'data'=>null,
                'message'=>$e->getMessage()
            ],200);
        }

    }


}