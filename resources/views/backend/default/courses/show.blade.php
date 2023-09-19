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
                <h4 class="text-capitalize mt-3 mb-0">{{ $course->title }}</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('courses.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-3 row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(!empty($course->image))
                            <img src="{{ asset($course->image) }}" class="card-img-top" alt=" ">
                        @else
                            <img src="{{asset('public/uploads')}}/default/cover.jpg" class="card-img-top" alt=" ">
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if(!empty($course->description))
                            <p>{!! $course->description !!}</p>
                        @else
                            <p></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div id="category-wrapper">
                <h5>Chapters</h5>
                <ul class="menu">
                    @if(!empty($course->chapters))
                        @foreach($course->chapters as $chapter)
                            <li class="item">
                                <a href="javascript:void(0);" disabled="">{{ $chapter->title }}</a>
                                @if(!empty($chapter->lessons))
                                    <ul class="submenu">
                                        @foreach($chapter->lessons as $lesson)
                                            <li class="sub-item">
                                                <a href="{{ route('lesson.show', $lesson) }}"><span>{{ $lesson->title }}</span></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul class="submenu">
                                        <li class="sub-item">

                                        </li>
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    @else
                        <li class="item">

                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
