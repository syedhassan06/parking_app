@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{asset('dist/css/custom.css')}}">
    <style>
        @media (min-width: 1200px) {
            .app-content.container {
                max-width: 95%;
            }
        }
        .feedback-wrapper{
            border-left: 2px solid #c5001a;
            border-top: 1px solid #eaeaea;
            border-bottom: 1px solid #eaeaea;
            padding: 10px 0px;
        }
        .media-wrapper{
            border-bottom: 1px solid #eaeaea;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .media-wrapper:last-child{
            border-bottom: 0px;
        }
        #feedback-wrapper{
            min-height: 200px;
        }
        .comment-section textarea{
            font-size: 0.8rem;
            line-height: 17px;
        }
        .user-col{
            padding: 10px;
            border-bottom: 1px solid;
            margin-bottom: 15px;
            background: #f7f7f9 !important;
        }
        .user-col.user-selected{
            background: #95d2df !important;
            font-weight: 600;
            color: white;
        }
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="card ">
            <div class="card-header border-bottom-1 border-bottom-grey">
                <h3 ><i class="la la-comment-o"></i> Feedback & Reply</h3>
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
                        <div class="col-md-4">
                            <div class="row user-row">
                                @foreach($users as $user)
                                    <div class="col-12 user-col font-sans">
                                        <span class="cursor-pointer user-action" data-id="{{$user->id}}">{{$user->name}}</span>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                            <div class="col-md-8" id="replies-user-section" >
                                <div class="feedback-wrapper" id="feedback-wrapper">

                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('dist/js/pages/feedback.js')}}"></script>
@endsection