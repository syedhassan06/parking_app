@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/pages/tagging.css') }}">
@endsection
@section('content')
    <div class="content-body">
        <div class="card">
            <div class="card-header border-separator">
                <h3 >{!! $page['icon'] !!}{{$page['title']}}</h3>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collpase show">
                <div class="card-body">
                    <form class="form"  action="{{route('user_save')}}" method="POST" novalidate autocomplete="of">
                        {{ csrf_field() }}
                        @if (isset($userEntity->id))
                            {!! Form::hidden('id', $userEntity->id) !!}
                        @endif
                        <div class="form-body">
                            <h4 class="form-section text-bold-500"><i class="icon-credit-card"></i> User Profile</h4>
                            <div class="row">
                                <div class="form-group col-md-4 mb-2">
                                    <label >Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" required value="{{ old('name', $userEntity->name) }}">
                                    <div class="help-block font-small-3"></div>
                                </div>
                                <div class="form-group col-md-4 mb-2">
                                    <label>UserID</label>
                                    <input type="text" class="form-control" autocomplete="new-username" placeholder="UserID" name="username" value="{{ old('username', $userEntity->username) }}">
                                    <div class="help-block font-small-3"></div>
                                </div>
                                <div class="form-group col-md-4 mb-2">
                                    <label class="input-label required">Email </label>
                                    <input type="email" class="form-control" placeholder="Email" name="email" required  value="{{ old('email', $userEntity->email) }}">
                                    <div class="help-block font-small-3"></div>
                                </div>
                            </div>

                        </div>
                        <div class="form-body mb-1">
                            <h4 class="form-section text-bold-500"><i class="icon-lock"></i> Account Login</h4>
                            <div class="row">
                                <div class="form-group col-md-6 mb-2">
                                    <label for="password">Password</label>
                                    <div >
                                        <input style="opacity: 0; position: absolute" />
                                        <input type="password" id="password" class="form-control"
                                               placeholder="New Password" name="password" autocomplete="new-password">
                                        <div class="help-block font-small-3"></div>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 mb-2">
                                    <label for="cpassword">Confirm Password</label>
                                    <div >
                                        <input type="password" id="cpassword" class="form-control"
                                               placeholder="Confirm Password" name="cpassword" data-validation-match-match="password"
                                               minlength="6"
                                        >
                                        <div class="help-block font-small-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-body">
                            <h4 class="form-section text-bold-500"><i class="icon-call-in"></i> Contact Details</h4>
                            <div class="row">
                                <div class="form-group col-md-4 mb-2">
                                    <label>{{trans('general.contact_no')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('general.contact_no')}}" name="phone" value="{{ old('phone', $userEntity->phone) }}">
                                </div>
                                <div class="form-group col-md-4 mb-2">
                                    <label >{{trans('general.address')}}</label>
                                    <input type="text" class="form-control" placeholder="{{trans('general.address')}}" name="address" value="{{ old('address', $userEntity->address) }}">
                                </div>


                            </div>
                        </div>
                        <div class="form-actions center">
                            <button type="submit" class="btn btn-outline-primary btn-min-width box-shadow-1 text-uppercase">
                                <i class="la la-floppy-o"></i> Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('dist/js/pages/tagging.js')}}"></script>
    <script src="{{asset('dist/js/pages/inputmask.js')}}"></script>
    <script>
        $(".tagging-text").tagging({
            "case-sensitive": true,
            //"edit-on-delete":false
        });
        $('#cnic').inputmask("99999-9999999-9");
    </script>
@endsection