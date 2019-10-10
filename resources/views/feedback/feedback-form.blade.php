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
    </style>
@endsection
@section('content')
    <div class="content-body">
        <div class="card ">
            <div class="card-header border-bottom-1 border-bottom-grey">
                <h3 ><i class="la la-comment-o"></i> Your Feedbacks</h3>
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
                            <form id="booking-form" class="form" novalidate action="{{route('feedback_save')}}" method="POST" autocomplete="off">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="row ">
                                        <div  class="col-md-12">
                                            <label class="label-control input-label font-small-3 text-bold-700" for="comment">Write Feedback</label>
                                            <input type="hidden" name="user_id" value="{{$user->id}}">
                                            <textarea required name="comment" id="comment" cols="30" rows="10" class="form-control font-small-3 "></textarea>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-2 mt-1">
                                                <button type="submit" class="btn btn-outline-primary box-shadow-1 text-uppercase btn-search">
                                                    <i class="la la-save"></i> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                        @if($feedbacks->count()>0)
                        <div class="col-md-8">
                            <div class="feedback-wrapper">
                                @foreach($feedbacks as $feedback)
                                    <div class="media media-wrapper">
                                        <div class="mr-2"  ></div>
                                        <div class="media-body">
                                            <h5 class="mt-0 text-bold-500 font-sans">You</h5>
                                            <div class="font-sans font-small-3">
                                                {{$feedback->comment}}
                                            </div>
                                            @if($feedback->replies && $feedback->replies->count()>0)
                                                <div class="media mt-2">
                                                    <a class="pr-3" href="#">
                                                    </a>
                                                    @foreach($feedback->replies as $feedbackReply)
                                                        <div class="media-body">
                                                            <h5 class="mt-0 text-bold-500 font-sans">Reply</h5>
                                                            <div class="font-sans font-small-3">
                                                                {{$feedbackReply->reply}}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection