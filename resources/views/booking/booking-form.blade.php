@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{asset('dist/css/custom.css')}}">
    <style>
        @media (min-width: 1200px) {
            .app-content.container {
                max-width: 95%;
            }
        }
        .select2-results__option{
            font-size: 0.9rem !important;
        }
        .car-slots-row  {
            border: 0.5px solid lightgrey;
            box-shadow: 0 0 6px #bac3ee;
            padding: 1em;
        }
        .car-slots-col{
            text-align: center;
        }
        .car-slots-col i{
            font-size: 2.5rem !important;
            border-radius: 5px !important;
            padding: 3px 4px !important;
            background: #aef0ad;
            cursor: pointer;
        }
        .car-slots-col i.booked{
            background: #f4ef60 !important;
            cursor: not-allowed;
        }
        .slot-label{
            margin: 5px 0px;
        }
        label.error {
            font-size: 0.8rem;
            margin-top: 5px;
        }
        .horizontal-layout .navbar-fixed {
            z-index: 1132 !important;
        }
        .select2-container {
            z-index: 1040 !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="card border-left-primary border-left-3 no-border-top-left-radius no-border-bottom-left-radius">
            <div class="card-header border-bottom-1 border-bottom-grey">
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
                <div class="card-body" id="booking-section">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="booking-form" class="form" novalidate action="{{route('booking_save')}}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                @if (isset($booking->id))
                                    {!! Form::hidden('id', $booking->id) !!}
                                @endif
                                <div class="form-body">
                                    <div class="row ">
                                        <div  class="col-md-3 col-lg-3 col-sm-12 sales-col">
                                            <label class="label-control input-label font-small-3 text-bold-700" for="booking_date">Date</label>
                                            <input id="booking_date" placeholder="dd/mm/yy" data-msg-required="Booking Date is required" type="text"  class="form-control form-control-sm pickadate booking_date font-sans"
                                                   name="booking_date" value="">
                                            <input type="hidden" name="slot_id">
                                        </div>
                                        <div  class="col-md-3 col-lg-3 col-sm-12 sales-col">
                                            <label class="label-control input-label font-small-3 text-bold-700" for="invoice_serial">Duration</label>
                                            <div class="row no-gutters">
                                                <div class="col-md-6">
                                                    <input   type="text" id="start_time" name="start_time" placeholder="Start Time" class="form-control form-control-sm timepicker booking_date font-sans">
                                                </div>
                                                <div class="col-md-6">
                                                    <input data-msg-required=" " type="text" id="end_time" name="end_time" placeholder="End Time" class="form-control form-control-sm timepicker booking_date font-sans">
                                                </div>
                                            </div>
                                        </div>
                                        <div  class="col-md-3 col-lg-3 col-sm-12 sales-col">
                                            <label class="label-control input-label font-small-3 text-bold-700" for="invoice_serial">Location</label>
                                            <div class="form-group">
                                                <select data-msg-required="Location is required" data-placeholder="Select Location" class="app-select2 locationselect select2-size-xs form-control" name="location_id">
                                                    @foreach($dataSource['locations'] as $location)
                                                        <option value="">Select Location</option>
                                                        <option value="{{$location->id}}">{{$location->location_name}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="error-block help-block"></div>
                                            </div>

                                        </div>
                                        <div  class="col-md-3 col-lg-3 col-sm-12 sales-col">
                                            <label class="label-control input-label font-small-3 text-bold-700" for="invoice_serial">Area</label>
                                            <div class="form-group">
                                                <select data-msg-required="Area is required" data-placeholder="Select Area" class="app-select2 areaselect select2-size-xs form-control" name="area_id" required>
                                                    @foreach($dataSource['areas'] as $area)
                                                        <option value="">Select Area</option>
                                                        <option value="{{$area->id}}">{{$area->area_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>


                                </div>

                            </form>
                            <div class="col-12">
                                <div class="text-center mb-2 mt-0">
                                    <button type="button" class="btn btn-outline-primary btn-min-width box-shadow-1 text-uppercase btn-search">
                                        <i class="la la-search"></i> SEARCH
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row car-slots-wrapper align-items-center justify-content-center" style="display: none;">
                        <div class="col-md-8">
                            <div class="row car-slots-row align-items-center justify-content-center" >
                                <h5 class="text-center text-bold-600 col-12 mb-2 text-uppercase">All Parking Slots</h5>
                                <section id="slot-section" class="row">
                                    @if($dataSource['slots'] && count($dataSource['slots'])>0)
                                        @foreach($dataSource['slots'] as $slot)
                                            <div class="col-md-3 car-slots-col mb-2">
                                                <i class="la la-car slot-booking-btn"></i>
                                                <div class="font-sans text-bold-500 text-uppercase slot-label">{{$slot->display_name}}</div>
                                            </div>
                                        @endforeach
                                    @else
                                        <h4>Sorry, No Slot Available</h4>
                                    @endif
                                </section>



                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal animated bounceInRight text-left " id="bookingModal" tabindex="-1" role="dialog"
         aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index: 1170;">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="user-package-modal-container">
                <div class="modal-header">
                    <h2 class="modal-title"><i class="la la-gavel font-large-1 mr-1"></i><span>Booking Confirmation</span></h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="booking-details-form" class="form form-horizontal form-bordered">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="col-md-12">

                            <div class="row booking-details" id="booking-details">
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">Booking Date</label>
                                    <div class="col-md-7">
                                        <h4 class="pad-5 text-bold-500 m-0 blue-grey darken-2 font-medium-1 booking_date_text">09 Oct, 2019</h4>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">Location</label>
                                    <div class="col-md-7">
                                        <h4 class="pad-5 text-bold-500 m-0 blue-grey darken-2 font-medium-1 location_text"></h4>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">Area</label>
                                    <div class="col-md-7">
                                        <h4 class="pad-5 text-bold-500 m-0 blue-grey darken-2 font-medium-1 area_text"></h4>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">Parking Slot</label>
                                    <div class="col-md-7">
                                        <h4 class="pad-5 text-bold-500 m-0 blue-grey darken-2 font-medium-1 parking_slot_text"></h4>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-5 label-control input-label text-bold-500 blue-grey lighten-1">Duration</label>
                                    <div class="col-md-7">
                                        <h4 class="pad-5 text-bold-500 m-0 blue-grey darken-2 font-medium-1">
                                            <span class="start_time_text pr-1">09:00 A.M</span>
                                            to
                                            <span class="end_time_text pl-1">12:00 P.M</span>
                                        </h4>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer row border-top-0 pt-0">
                        <div class=" col-md-12 border-top border-light pt-1">
                            <button type="button" class="btn btn-primary btn-booking-submit btn-min-width box-shadow-2 float-right">Submit Booking</button>
                            <button type="button" class="btn btn-secondary btn-user-package-cancel btn-min-width box-shadow-2 float-left mr-1" data-dismiss="modal">Cancel</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('dist/js/pages/booking.js')}}"></script>
@endsection