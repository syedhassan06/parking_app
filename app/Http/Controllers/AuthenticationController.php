<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\SignupRequest;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function authenticate(AuthRequest $request)
    {
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL )? 'email': 'username';
        $credentials = collect([
            'password'		=>  $request->input('password')
        ]);
        $remember = ($request->input('remember_me'))?true:false;
        $credentials->put($loginType , $request->input('login'));

        if ( Auth::attempt($credentials->toArray(),$remember) ){
            $user = Auth::user()->toArray();
            $request->session()->put(config('app.user_sess'),$user);
            return redirect()->route('booking_manage');
        }else{
            return redirect()->back()->withInput()->withErrors(['error'=>trans('auth.failed')]);
        }
    }

    public function signup(SignupRequest $request){
        $user = new UserModel(
            array_merge($request->all(),['role'=>'customer'])
        );
        if($user->save()){
            return redirect()->route('get_login')->with('success', trans('auth.account_created'));
        }else{
            return redirect()->back()->withInput()->withErrors(['error'=>trans('auth.account_created_failed')]);
        }
    }

    public function getLogin(){
        return view('auth.login');
    }

    public function getSignup(){
        //$this->middleware(['guest']);
        //dd(session()->get('user'));
        return view('auth.signup');
    }

    public function logout(){
        //dd(session()->get(config('app.user_sess')));
        Auth::logout();
        Session::flush();
        return redirect('login');
    }
}
