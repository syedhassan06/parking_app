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
        #deleteConfirmModal .cancel-btn{
            color: white !important;
        }
        @media (min-width: 1200px) {
            .app-content.container {
                max-width: 95%;
            }
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
                    @include('booking.table-header')
                    <table class="table table-bordered compact cgi-dt" id="vendor-table">
                        <thead class="bg-grey bg-lighten-1 white">
                        <tr>
                            <th class="centered-cell">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th>{{trans('general.name')}}</th>
                            <th>{{trans('general.date')}}</th>
                            <th>{{trans('general.location')}}</th>
                            <th>{{trans('general.area')}}</th>
                            <th>{{trans('general.slot_no')}}</th>
                            <th>{{trans('general.start_time')}}</th>
                            <th>{{trans('general.end_time')}}</th>
                            <th>{{trans('general.status')}}</th>
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
            ajax: '{{route("booking_list")}}',
            "pageLength": 10,
            "columns": [
                {"data": "id","name":"id",
                    "orderable": false,
                    "searchable": false ,
                    "className": "centered-cell",
                    "render":checkbox
                },
                {"data": "user","name":"user",render:function(val){return (val&&val.name || '')}, 'className':window.authenticatedUser.role!='admin'?'d-none':'' },
                {"data": "booking_date","name":"booking_date","className": "font-sans"},
                {
                    "data": "location","name":"location",
                    "render":function(val){
                        return (val && val.location_name)||''
                    }
                },
                {
                    "data": "area","name":"area",
                    "render":function(val){
                        return (val && val.area_name)||''
                    }
                },
                {
                    "data": "slot","name":"slot",
                    "render":function(val){
                        return (val && val.display_name)||''
                    }
                },
                {"data": "formatted_start_time","name":"formatted_start_time","className": "font-sans"},
                {"data": "formatted_end_time","name":"formatted_end_time","className": "font-sans"},
                {"data": "booking_status","name":"booking_status",
                    "render":function(val){
                        if(val=='booked') {
                            return '<div class="text-center"><span class="badge  badge-success font-small-2">Booked</span></div>';
                        }else if(val=='cancelled') {
                            return '<div class="text-center"><span class="badge bg-danger white font-small-2">Cancelled</span></div>';
                        }else{
                            return '';
                        }
                        //return ( val && snakeToTileCase(val.template_type,"_"," ") || "")
                    }
                },
                {"data": "action","name":"action","className":"centered-cell"}
            ],
            rowCallback:function(row, data){
                $(row).attr("data-staff",data.id);
                return row;
            },
            dom: '<"pull-left" B><"clearfix"><"row mt-1" <"col-md-6 " l> >rtip',
            buttons: []
        };
        var dt = AppSetting.datatable.init($('#vendor-table'), datatableconfig);

        yadcf.init(dt,[
            /*{column_number:1,filter_type:"text",filter_default_label:"[{{trans('general.name')}}]"},
            {column_number:2,filter_type:"text",filter_default_label:"[{{trans('general.location')}}]"},
            {column_number:3,filter_type:"text",filter_default_label:"[{{trans('general.name')}}]"},*/
        ],"footer");

    </script>
    @yield('user.package-popup')
@endsection
