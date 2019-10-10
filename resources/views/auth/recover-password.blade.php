<!DOCTYPE html>
<html>

@include('layouts.header')

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
                        <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                            <div class="card-header border-0 pb-0">
                                <div class="card-title text-center">
                                    <img src="{{asset('images/logo/logo-dark.png')}}" alt="branding logo">
                                </div>
                                <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                    <span>We will send you a link to reset password.</span>
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
                                    @if (\Session::has('authSuccess'))
                                        <div class="alert round bg-success alert-icon-left alert-arrow-left alert-dismissible  mb-1" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                            <span>{{ \Session::get('authSuccess') }}</span>
                                        </div>
                                    @endif
                                    <form class="form-horizontal" action="{{url('password/email')}}" novalidate method="POST">
                                        {{ csrf_field() }}
                                        <fieldset class="form-group position-relative has-icon-left">
                                            <input type="email" class="form-control form-control-lg input-lg" id="user-email"
                                                   placeholder="Your Email Address" required name="email">
                                            <div class="form-control-position">
                                                <i class="ft-mail"></i>
                                            </div>
                                        </fieldset>
                                        <button type="submit" class="btn btn-outline-info btn-lg btn-block"><i class="ft-unlock"></i> Recover Password</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-footer border-0">
                                    <a href="{{url('login')}}" class="btn btn-float btn-outline-info btn-square">
                                                <i class="la la-angle-double-left"></i></a>
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