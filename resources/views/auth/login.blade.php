<!DOCTYPE html>
<html>

@include('layouts.header')

<link href="{{asset('dist/css/pages/login-register.css')}}" rel="stylesheet" />

<body class="horizontal-layout horizontal-menu 1-column bg-login-screen-image  menu-expanded blank-page blank-page"
      data-open="hover" data-menu="horizontal-menu" data-col="1-column">

<div class="app-content content">
    <div class="content-wrapper">

        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-md-4 col-10 box-shadow-2 p-0">
                        <div class="card border-grey border-lighten-3 m-0 login-card">
                            <div class="card-header border-0">
                                <div class="card-title text-center">
                                    <div class="p-1">
                                        <h4 class="primary text-bold-500">Parking Booking System</h4>
                                    </div>
                                </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2 primary darken-2 border-bottom-primary border-bottom-darken-2 text-bold-500 font-medium-2">
                                    <span>Login with {{config('app.short_name')}}</span>
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
                                        @if(Session::has('success'))
                                            <div class="col-md-12 pl-0">
                                                <div class="alert round bg-success alert-icon-left alert-arrow-left alert-dismissible mb-1"
                                                     role="alert">
                                                    <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    <span>{{ Session::get('success') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    <form autocomplete="off" class="form-horizontal" method="POST" action="{{ url('login') }}" novalidate>
                                        {{ csrf_field() }}
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input style="opacity: 0;position: absolute;">
                                            <input autocomplete="email" data-validation-required-message="Email or UserID is required" name="login" value="{{ old('login') }}" class="form-control form-control-lg input-lg" id="user-name" placeholder="Email or UserID"
                                                   required>
                                            <div class="form-control-position">
                                                <i class="ft-user"></i>
                                            </div>
                                            <div class=" text-center help-block font-small-3"></div>
                                        </fieldset>
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input autocomplete="new-password" data-validation-required-message="Password is required" name="password" type="password" class="form-control form-control-lg input-lg" id="user-password"
                                                   placeholder="Password" required  >
                                            <div class="form-control-position">
                                                <i class="la la-key"></i>
                                            </div>
                                            <div class=" text-center  help-block font-small-3"></div>
                                        </fieldset>

                                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i> Login</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="">
                                    <p class="float-sm-right text-center m-0">Create new account? <a href="{{route('get_signup')}}" class="card-link">Sign Up</a></p>
                                </div>
                            </div>
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