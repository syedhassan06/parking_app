<!DOCTYPE html>
<html>

@include('layouts.header')

<body class="horizontal-layout horizontal-menu 2-columns   menu-expanded" data-open="hover" data-menu="horizontal-menu"
      data-col="2-columns">

<!-- fixed-top-->
@include('layouts.navbar-header')

<div class="app-content container center-layout mt-2"><!-- remove "content" class  add class "container center-layout"-->
    <div class="content-wrapper">
        @include('layouts.flash-message')
        @if (count($errors) > 0)
            <div class="col-md-12">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        @foreach ($errors->all() as $error)
                            <div class="alert bg-danger alert-icon-right alert-arrow-right alert-dismissible mb-1" role="alert">
                                <span class="alert-icon"><i class="la la-warning"></i></span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <span>{{$error}}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @yield('content')

    </div>
</div>
<!--<div class="modern-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            .....
        </div>
        <div class="content-body">
            .....
        </div>
    </div>
</div>-->
<!-- ////////////////////////////////////////////////////////////////////////////--><!-- Begin page -->

@include('layouts.footer')

</body>

</html>
