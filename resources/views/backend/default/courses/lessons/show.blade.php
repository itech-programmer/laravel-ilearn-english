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
                @if(!empty($lesson->chapter->course->title))
                    <h4 class="text-capitalize mt-3 mb-0">{{ $lesson->chapter->course->title }}</h4>
                @else
                    <h4 class="text-capitalize mt-3 mb-0">NOT SELECTED COURSE AND CHAPTER</h4>
                @endif
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('lessons.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div id="category-wrapper">
                <h5>Lessons</h5>
                <ul class="menu">
                    @if(!empty($lesson->chapter->course->chapters))
                        @foreach($lesson->chapter->course->chapters as $chapter)
                            <li class="item">
                                <a href="javascript:void(0);" disabled="">{{ $chapter->title }}</a>
                                @if(!empty($chapter->lessons))
                                    <ul class="submenu">
                                        @foreach($chapter->lessons as $lesson)
                                            <li class="sub-item">
                                                <a href="{{ route('lesson.show', $lesson->slug) }}"><span>{{ $lesson->title }}</span></a>
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
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-info text-white">
                    @if(!empty($lesson->chapter->title))
                        <span>{{ $lesson->chapter->title }}</span>
                    @else
                        <span></span>
                    @endif
                </div>
                <div class="card-header">
                    @if(!empty($lesson->title))
                        <span>{{ $lesson->title }}</span>
                    @else
                        <span></span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="inner-all">
                        @if(!empty($lesson->content))
                            <p>{!! $lesson->content !!}</p>
                        @else
                            <p></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('script')

@endsection
