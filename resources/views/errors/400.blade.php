@extends('layouts.master')
@section('styles')
    <style>

    </style>
@endsection

@section('content')

    <div class="content-body">
        <section class="flexbox-container">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="col-md-4 col-10 p-0">
                    <div class="card-header bg-transparent border-0">
                        <h2 class="error-code text-center mb-2">400</h2>
                        <h3 class="text-uppercase text-center">BAD REQUEST</h3>
                    </div>
                    <div class="card-content">

                        <div class="row py-2">
                            <div class="col-12 col-sm-6 col-md-6 offset-sm-3">
                                <a href="{{url('/')}}" class="btn btn-primary btn-block"><i class="ft-home"></i> Back to Home</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>

@endsection

@section('scripts')
    <script src="{{asset('dist/js/pages/datatable/chunk2.js')}}"></script>
@endsection