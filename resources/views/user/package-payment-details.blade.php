@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/pages/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/pages/jquery.dataTables.yadcf.css') }}">
    <style>
        .modal .blockElement{
            z-index: 1150 !important
        }
        .modal .blockOverlay{
            z-index: 1130 !important;
        }
        .pad-5{
            padding-top: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="content-detached content-right">
        <div class="content-body">
            <!-- Description -->
            <section class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-head">
                            <div class="card-header">
                                <h4 class="card-title">Payment History</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <button class="btn btn-primary btn-sm user-package-activate-btn"><i class="la la-money white font-medium-2" style="padding-right: 5px;"></i>Add Payment</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Task List table -->
                                <div class="table-responsive">
                                    <table id="users-contacts" class="table table-white-space table-bordered row-grouping display no-wrap icheck table-middle">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Package</th>
                                            <th>Date</th>
                                            <th class="text-right">Payment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($userPackages)>0)
                                                @foreach($userPackages as $userPackage)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="input-chk">
                                                        </td>
                                                        <td>
                                                            <div class="media">
                                                                <div class="media-body media-middle">
                                                                    <a href="javascript:void(0)" class="media-heading">{{$userPackage->package}}</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td >
                                                            <h6 class="m-0">{{Carbon\Carbon::parse($userPackage->payment_date)->format('d F, Y')}}</h6>
                                                        </td>
                                                        <td class="text-right">{{number_format($userPackage->payment_received,2)}}</td>

                                                    </tr>
                                                @endforeach
                                            @endif

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Package</th>
                                            <th>Date</th>
                                            <th class="text-right">Payment</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--/ Description -->
        </div>
    </div>
    <div class="sidebar-detached sidebar-left" ,=",">
        <div class="sidebar">
            <div class="sidebar-content card d-none d-lg-block">
                <div class="card-body">
                    <div class="media p-1 border-bottom-blue-grey border-top-lighten-5">
                        <div class="media-body media-middle">
                            <h3 class="media-heading m-0"><i class="icon-user mr-1"></i>{{ucwords($user->name)}}</h3>
                        </div>
                    </div>
                    <div class="mt-1"></div>
                    <div class="row mb-1">
                        <div class="col-2"><i class="la la-envelope"></i></div>
                        <div class="col-10"><span>{{$user->email}}</span></div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-2"><i class="la la-map-marker"></i></div>
                        <div class="col-10"><span>{{$user->address}}</span></div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-2"><i class="la la-credit-card"></i></div>
                        <div class="col-10"><span>{{$user->cnic ?: '-'}}</span></div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-2"><i class="la la-phone"></i></div>
                        <div class="col-10">
                            @foreach($user->contacts as $contact)
                                <div style="margin-bottom:5px">{{$contact}}</div>
                            @endforeach
                        </div>
                    </div>
                    <hr>
                    @if($activatePackage)
                    <div class="text-muted mb-2">
                        <span class="text-bold-600 blue-grey lighten-1 font-medium-1">Activate Package</span>
                        <span class="float-right">
                            <h6 class="badge badge-success" style="    padding: 6px 8px;">{{$activatePackage->package}}</h6>
                      </span>
                    </div>
                    <hr>
                    <div class="text-muted mb-2">
                        <span class="text-bold-600 blue-grey lighten-1 font-medium-1">Activation Date</span>
                        <span class="float-right">
                            <h6 class="badge badge-warning" style="    padding: 6px 8px;">{{$activatePackage->activation_date}}</h6>
                      </span>
                    </div>
                    <hr>
                    @endif
                    <!-- /Ratings sample -->
                </div>
            </div>
        </div>
    </div>
    <div class="content-body d-none">
        <div class="card" id="user-listing-card">
            <div class="card-header border-separator">
                <h3>{!! $page['icon'] !!}{{$page['title']}}</h3>
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
                    <div class="reporting-action-crud pull-right nav-item">
                        <a href="#" class="btn btn-float btn-round bg-blue white" data-toggle="dropdown"><i class="icon-list"></i></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><i class="icon-plus"></i><span>Add New</span></a>
                            <a class="dropdown-item" href="#"><i class="icon-trash"></i><span>Delete</span></a>
                        </div>
                    </div>
                    <table class="table table-bordered compact cgi-dt" id="vendor-table">
                        <thead class="bg-blue white">
                        <tr>
                            <th class="centered-cell">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th>{{trans('general.name')}}</th>
                            <th>{{trans('general.email')}}</th>
                            <th>{{trans('general.contact_no')}}</th>
                            <th>{{trans('general.cnic')}}</th>
                            <th>{{trans('general.address')}}</th>
                            <th>{{trans('general.status')}}</th>
                            <th  class="centered-cell">{{trans('general.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>

                        {{--@forelse ($users as $user)
                            <tr>
                                <td>{{ $user->vendor_name }}</td>
                                <td>{{ $user->vendor_email }}</td>
                                <td>{{ $user->vendor_other_email }}</td>
                                <td>{{ $user->vendor_contact }}</td>
                                <td>{{ $user->vendor_address }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle  btn-sm" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"><i class="la la-cog"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item "  href="{{route('vendor_edit',[$user->id])}}"><i class="la la-edit"></i> Edit</a>
                                            --}}{{--<div class="dropdown-divider"></div>
                                            <a class="dropdown-item"  href="{{route('vendor_edit',[$user->id])}}"><i class="la la-remove"></i> Delete</a>--}}{{--
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No Record Found</td>
                            </tr>

                        @endforelse--}}

                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('user.user-package-payment-popup',['userPackages'=>$userPackages,'activatePackage'=>$activatePackage,'user'=>$user])
@endsection

@section('scripts')
    {{--<script src="{{asset('dist/js/pages/datatable/chunk0.js')}}"></script>--}}
    <script src="{{asset('dist/js/pages/datatable/chunk2.js')}}"></script>
    {{--<script src="{{asset('dist/js/pages/jquery.dataTables.yadcf.js')}}"></script>--}}
    {{--<script src="{{asset('dist/custom.js')}}"></script>--}}
    <script>
        var datatableconfig = {
            ajax: '{{route("user_list")}}',
            "pageLength": 10,
            "columns": [
                {"data": "user_id","name":"user_id",
                    "orderable": false,
                    "searchable": false ,
                    "className": "centered-cell",
                    "render":checkbox
                },
                {"data": "name","name":"name"},
                {"data": "email","name":"email"},
                {"data": "contacts","name":"contacts"},
                {"data": "cnic","name":"cnic"},
                {"data": "address","name":"address"},
                {"data": "active","name":"active",
                    "orderable": false,
                    "searchable": false ,
                    "className": "centered-cell",
                    "render":inputSwitcher
                },
                {"data": "action","name":"action","className":"centered-cell"}
            ],
            rowCallback:function(row, data){
                $(row).attr("data-customer",data.user_id);
                return row;
            },
            dom: '<"pull-left" B><"clearfix"><"row mt-1" <"col-md-6 " l> <"col-md-6" f> >rtip',
            buttons: [
                { extend: 'print', className: 'bg-blue' },
                { extend: 'excel', className: 'bg-blue' },
                { extend: 'pdf', className: 'bg-blue' }
            ]
        };
        var customerActivateRoute = "{{ route('user_activate') }}";
        var CSRF_TOKEN = "{!! csrf_token() !!}";
        var dt = AppSetting.datatable.init($('#vendor-table'), datatableconfig);

        yadcf.init(dt,[
            {column_number:1,filter_type:"text",filter_default_label:"[{{trans('general.name')}}]"},
            {column_number:2,filter_type:"text",filter_default_label:"[{{trans('general.email')}}]"},
            {column_number:3,filter_type:"text",filter_default_label:"[{{trans('general.contact_no')}}]",searchable: false,sortable:false},
            {column_number:4,filter_type:"text",filter_default_label:"[{{trans('general.cnic')}}]",searchable: false,sortable:false}
        ],"footer");

        var userController = (function(){
            var _this;
            return {
                _token : CSRF_TOKEN,
                userPackages : ({!! json_encode($userPackages) !!}),
                route : {
                    "customerActivate" : customerActivateRoute
                },
                onToggleCustomerActivation : function(e){
                    var params = {
                        "customer_id": $(this).closest("tr").data("customer"),
                        "active": e.target.checked?1:0,
                        "_token":CSRF_TOKEN
                    };
                    $(this).val(params.active);
                    AppSetting.initBlockUI($("#user-listing-card"));

                    AppSetting.httpPost(_this.route.customerActivate, (params))
                        .then(
                            function(res){
                                AppSetting.stopBlockUI($("#user-listing-card"));
                                if(res.status){
                                    AppSetting.growler('success',res.message,'Success');
                                }else{
                                    AppSetting.growler('error',res.message,'Sorry');
                                }
                            },
                            function (err) {
                                AppSetting.stopBlockUI($("#user-listing-card"));
                                AppSetting.growler('error',(err && err.message)
                                    || (err && err.responseJSON && err.responseJSON.message)
                                    || 'Something went wrong','Sorry');
                            }
                        );
                },
                attachEventHandlers : function(){
                    $("body").on('change','.switchery',_this.onToggleCustomerActivation);
                },
                init : function () {
                    _this = this;
                    console.log(_this.userPackages);
                    _this.attachEventHandlers();
                }
            };
        })().init();
        //$('.dataTables_scrollBody tfoot tr').addClass('hidden')
        //        function yadcfAddBootstrapClass() {
        //            var filterInput = $('.yadcf-filter, .yadcf-filter-range, .yadcf-filter-date'),
        //                filterReset = $('.yadcf-filter-reset-button');
        //
        //            filterInput.addClass('form-control input-sm');
        //            filterReset.addClass('btn btn-default').html('&#10005;');
        //        };
        //
        //        yadcfAddBootstrapClass();
        //$('.bootstrap-3').DataTable();
    </script>
    @yield('user.user-package-payment-popup')
@endsection
