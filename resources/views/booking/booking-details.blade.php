@extends('layouts.master')
@section('styles')
    <style>
        .booking-row{
            padding: 10px 0px;
            border-bottom: 1px solid lightgrey;
        }
        .booking-row .booking-label{
            font-weight: 600;
            letter-spacing: 1px;
        }
    </style>
@endsection

@section('content')

    <div class="content-body order-details" id="booking-details-section">
        <div class="card ">
            <div class="card-header border-separator border-bottom-shadow py-1 bg-gradient-x2-red">
                <h2 class="m-0 p-0">
                    <div class="d-flex justify-content-center align-content-center">
                        <div class="align-self-center text-bold-700 ml-1 white">Parking Details</div>
                    </div>

                </h2>
            </div>
            <div class="card-content collpase show">
                <div class="card-body">
                    <div class="container-fluid h-100">
                        <div class="row h-100 justify-content-center align-items-center">
                            <div class="col-12 mb-1 d-print-none">
                                <a data-repeater-create class="btn btn-sm btn-secondary btn-glow  box-shadow-2 round btn-min-width pull-right" href="javascript:void(0)" onclick="window.print()">
                                    <i class="la la-print font-small-3"></i> Print
                                </a>
                            </div>
                            <div class="col-md-8" id="sales-section">
                                <div class="row booking-row">
                                    <div class="col-md-4 font-sans booking-label">Booking Date</div>
                                    <div class="col-md-7 font-sans text-bold-500">{{$booking->full_booking_date}}</div>
                                </div>
                                <div class="row booking-row">
                                    <div class="col-md-4 font-sans booking-label">Location</div>
                                    <div class="col-md-7 font-sans text-bold-500">
                                        @if($booking->location)
                                            <span>{{ucwords($booking->location->location_name)}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row booking-row">
                                    <div class="col-md-4 font-sans booking-label">Area</div>
                                    <div class="col-md-7 font-sans text-bold-500">
                                        @if($booking->area)
                                            <span>{{ucwords($booking->area->area_name)}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row booking-row">
                                    <div class="col-md-4 font-sans booking-label">Slot</div>
                                    <div class="col-md-7  font-sans text-bold-500">
                                        @if($booking->slot)
                                            <span>{{ucwords($booking->slot->display_name)}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row booking-row">
                                    <div class="col-md-4 font-sans booking-label">Duration</div>
                                    <div class="col-md-7 font-sans text-bold-500">
                                        @if($booking->formatted_start_time)
                                            <span class="pr-1">{{$booking->formatted_start_time}}</span>
                                        @endif
                                        <span>to</span>
                                        @if($booking->formatted_end_time)
                                             <span class="pl-1">{{$booking->formatted_end_time}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row booking-row">
                                    <div class="col-md-4 font-sans booking-label">Status</div>
                                    <div class="col-md-7 font-sans booking_status_text">
                                        @if($booking->booking_status=='booked')
                                            <span class="badge badge-success">Booked</span>
                                        @endif
                                        @if($booking->booking_status=='cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </div>
                                </div>
                                @if($booking->booking_status=='booked')
                                    <div class="row booking-row border-0">
                                        <div class="col-6 ">
                                            <button type="button" class="btn btn-outline-primary btn-min-width box-shadow-1 round btn-sm cancel-booking-btn">
                                                Cancel Booking
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal animated fade text-left" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel52" aria-hidden="true" id="deleteConfirmBookingModal">
        <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel52">Alert</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="m-0">Are you sure want to cancel this booking?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary white cancel-btn" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger confirm-cancel-btn">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('dist/js/pages/booking-details.js')}}"></script>
@endsection