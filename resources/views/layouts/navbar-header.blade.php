<nav class="header-navbar  navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center border-top-grey border-top-lighten-4">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto">
                    <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="navbar-brand  p-0" href="javascript:void(0)">
                        <h4 class="brand-text align-bottom d-none d-md-inline-block d-sm-none mt-1 ml-1">{{config('app.name')}}</h4>
                    </a>
                </li>
                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container container center-layout">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav float-right" style="z-index: 1500 !important;">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                        <span class="avatar-text">Hi,
                            <span class="user-name text-bold-600">{{trim(ucwords($user->name))}}</span>
                        </span>
                        <span class="avatar avatar-online">
                            <img src="{{asset('images/avatar/user-avatar.png')}}" alt="avatar"><i></i>
                        </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="{{ route('logout') }}"><i class="ft-power"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<div class=" font-sans header-navbar navbar-expand-sm navbar navbar-without-dd-arrow navbar-horizontal navbar-fixed navbar-dark bg-primary bg-darken-2 border-top-primary"
     role="navigation" data-menu="menu-wrapper" style="box-shadow: rgb(84, 87, 102) 1px 1px 5px;">
    <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
        <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
            {{--<li class="dropdown nav-item" data-menu="dropdown">--}}
                {{--<a class="nav-link" href="{{route('dashboard')}}"><i class="la la-home"></i>--}}
                    {{--<span>Dashboard</span>--}}
                {{--</a>--}}
            {{--</li>--}}
            @can('isAdmin')
            <li class="dropdown nav-item" data-menu="dropdown">
                <a class="dropdown-toggle nav-link" href="{{route('user_manage')}}" data-toggle="dropdown">
                    <i class="icon-user-following"></i>
                    <span>{{trans('general.users')}}</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{setActiveMenu('user_manage')}}" data-menu=""><a class="dropdown-item" href="{{route('user_manage')}}" data-toggle="dropdown">{{trans('user.manageCustomer')}}</a>
                    </li>
                    <li class="{{setActiveMenu('user_create')}}" data-menu=""><a class="dropdown-item" href="{{route('user_create')}}" data-toggle="dropdown">{{trans('user.addCustomer')}}</a>
                    </li>
                </ul>
            </li>
            @endcan
            <li class="dropdown nav-item {{setActiveMenu('booking_create')}}" data-menu="dropdown">
                <a class="nav-link" href="{{route('booking_create')}}"><i class="la la-plus-circle"></i>
                    <span>{{trans('general.new_booking')}}</span>
                </a>
            </li>
            <li class="dropdown nav-item {{setActiveMenu('booking_manage')}}" data-menu="dropdown">
                <a class="nav-link" href="{{route('booking_manage')}}"><i class="la la-book"></i>
                    @if($user->role=='customer')
                        <span>{{trans('general.my_bookings')}}</span>
                    @else
                        <span>{{trans('general.manage_bookings')}}</span>
                    @endif
                </a>
            </li>
            @can('isCustomer')
            <li class="dropdown nav-item {{setActiveMenu('feedback_write')}}" data-menu="dropdown">
                <a class="nav-link" href="{{route('feedback_write')}}"><i class="la la-comment-o"></i>
                    <span>{{trans('general.write_feedback')}}</span>
                </a>
            </li>
            @endcan
            @can('isAdmin')
            <li class="dropdown nav-item {{setActiveMenu('feedback_reply')}}" data-menu="dropdown">
                <a class="nav-link" href="{{route('feedback_reply')}}"><i class="la la-comment-o"></i>
                    <span>{{trans('general.feedback_reply')}}</span>
                </a>
            </li>
            @endcan
        </ul>
    </div>
</div>
