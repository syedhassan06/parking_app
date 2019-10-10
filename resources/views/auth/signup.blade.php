<!DOCTYPE html>
<html>

@include('layouts.header')

<link href="{{asset('dist/css/pages/login-register.css')}}" rel="stylesheet" />

<body class="horizontal-layout horizontal-menu 1-column   menu-expanded blank-page blank-page"
      data-open="hover" data-menu="horizontal-menu" data-col="1-column">

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-4 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0">
                            <div class="card-header border-0">
                                <div class="card-title text-center">
                                    <div class="p-1">
                                        <h4 class="primary text-bold-500">Parking Booking System</h4>
                                    </div>
                                </div>
                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2 primary darken-2 border-bottom-primary border-bottom-darken-2 text-bold-500 font-medium-2">
                                    <span>SignUp with {{config('app.short_name')}}</span>
                                </h6>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @if($errors->any())
                                        <div class="alert round bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-1" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <span>{{$errors->first()}}</span>
                                        </div>
                                    @endif
                                    @if ( \Session::has('authSuccess'))
                                        <div class="alert round bg-success alert-icon-left alert-arrow-left alert-dismissible mb-1" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <span>{{\Session::get('authSuccess')}}</span>
                                        </div>
                                    @endif
                                    <form class="form-horizontal form-simple" method="POST" action="{{ route('post_signup') }}" novalidate autocomplete="off">
                                        {{ csrf_field() }}
                                        <fieldset class="form-group position-relative has-icon-left mb-1">
                                            <input name="name" value="{{ old('name') }}"  class="form-control form-control-lg input-lg" id="name" placeholder="Name"
                                                   required>
                                            <div class="form-control-position">
                                                <i class="ft-user"></i>
                                            </div>
                                            <div class="help-block"></div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left mb-1">
                                            <input name="username" value="{{ old('username') }}"  class="form-control form-control-lg input-lg" id="username" placeholder="UserName"
                                                   >
                                            <div class="form-control-position">
                                                <i class="ft-user"></i>
                                            </div>
                                            <div class="help-block"></div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left mb-1">
                                            <input autocomplete="off" name="email" value="{{ old('email') }}"
                                                   type="email"
                                                   required
                                                   data-validation-email-message="Please enter a valid email address"
                                                   class="form-control form-control-lg input-lg" id="user-name" placeholder="Your Email"
                                                   >
                                            <div class="form-control-position">
                                                <i class="ft-mail"></i>
                                            </div>
                                            <div class="help-block"></div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left mb-1">
                                            <input autocomplete="off" name="password" type="password" class="form-control form-control-lg input-lg" id="user-password"
                                                   placeholder="Enter Password" required  minlength="6">
                                            <div class="form-control-position">
                                                <i class="la la-key"></i>
                                            </div>
                                            <div class="help-block"></div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input autocomplete="off" name="cpassword" type="password" class="form-control form-control-lg input-lg" id="cpassword"
                                                   placeholder="Confirm Password"
                                                   required data-validation-match-match="password"
                                                   minlength="6"  >
                                            <div class="form-control-position">
                                                <i class="la la-key"></i>
                                            </div>
                                            <div class="help-block"></div>
                                        </fieldset>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Signup</button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-center">Already have an account ? <a href="{{route('get_login')}}" class="card-link">Login</a></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script src="{{asset('dist/js/bundle.main.js')}}"></script>
<script src="{{asset('dist/js/pages/form-login-register.js')}}"></script>
</body>

</html>