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
    <div class="content-body">
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
                    @include('layouts.table-header-action')
                    <table class="table table-bordered compact cgi-dt" id="user-table">
                        <thead class="bg-grey bg-lighten-1 white">
                        <tr>
                            <th class="centered-cell">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th>{{trans('general.name')}}</th>
                            <th>{{trans('general.userid')}}</th>
                            <th>{{trans('general.email')}}</th>
                            <th>{{trans('general.contact_no')}}</th>
                            <th>{{trans('general.address')}}</th>
                            <th  class="centered-cell">{{trans('general.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>

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
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('dist/js/pages/datatable/chunk2.js')}}"></script>
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
                {"data": "username","name":"username"},
                {"data": "email","name":"email"},
                {"data": "phone","name":"phone"},
                {"data": "address","name":"address","orderable": false},
                {"data": "action","name":"action","className":"centered-cell"}
            ],
            rowCallback:function(row, data){
                $(row).attr("data-customer",data.user_id);
                return row;
            },
            dom: '<"pull-left" B><"clearfix"><"row mt-1" <"col-md-6 " l> <"col-md-6" f> >rtip',
            buttons: [
                { extend: 'print', className: 'btn-outline-grey ' },
                { extend: 'excel', className: 'btn-outline-grey ' },
                { extend: 'pdf', className: 'btn-outline-grey ' }
            ]
        };
        var userActivateRoute = "{{ route('user_activate') }}";
        var CSRF_TOKEN = "{!! csrf_token() !!}";
        var dt = AppSetting.datatable.init($('#user-table'), datatableconfig);

        yadcf.init(dt,[
            {column_number:1,filter_type:"text",filter_default_label:"[{{trans('general.name')}}]"},
            {column_number:2,filter_type:"text",filter_default_label:"[{{trans('general.userid')}}]"},
            {column_number:3,filter_type:"text",filter_default_label:"[{{trans('general.email')}}]"},
            {column_number:4,filter_type:"text",filter_default_label:"[{{trans('general.contact_no')}}]",searchable: false,sortable:false},
        ],"footer");

        var userController = (function(){
            var _this;
            return {
            _token : CSRF_TOKEN,
            route : {
                "customerActivate" : userActivateRoute
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
                  _this.attachEventHandlers();
              }
            };
        })().init();
    </script>
    @yield('user.package-popup')
@endsection
