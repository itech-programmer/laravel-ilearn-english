@extends('backend.default.layouts.app')

@section('style')
    <!-- begin::Menu -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/backend') }}/default/css/menu.css"/>
    <!-- end::Menu -->
@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center bg-white p-2">
            <div class="col">
                <h4 class="text-capitalize mt-3 mb-0">{{ $question->question_title }}</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('questions.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        @foreach($question->answers as $index => $answer)
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="inner-all">
                            <ul class="list-unstyled">
                                <li class="text-center border-bottom-0">
                                    @if(!empty($answer->answer_image))
                                        <img src="{{ asset($answer->answer_image) }}" class="card-img-top" alt=" ">
                                    @else
                                        <img src="{{asset('public/uploads')}}/default/image-not-found.jpg" class="card-img-top" alt=" ">
                                    @endif
                                </li>
                                <li class="text-center">
                                    <h6 class="text-capitalize mt-3 mb-0">{{ $answer->answer_title }}</h6>
                                    <p class="text-muted text-capitalize mt-4">
                                        @if( $answer->true_answer == 1 )
                                            <span class="text-success">True</span>
                                        @else
                                            <span class="text-danger">False</span>
                                        @endif
                                    </p>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('script')

@endsection
