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
                @if(!empty($chapter->course->title))
                    <h4 class="text-capitalize mt-3 mb-0">{{ $chapter->course->title }}</h4>
                @else
                    <h4 class="text-capitalize mt-3 mb-0">NOT SELECTED COURSE</h4>
                @endif
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('chapters.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div id="category-wrapper">
                <h5>Chapters</h5>
                <ul class="menu">
                    @if(!empty($chapter->course->chapters))
                        @foreach($chapter->course->chapters as $chapter)
                            <li class="item">
                                <a href="javascript:void(0);" disabled="">{{ $chapter->title }}</a>
                                @if(!empty($chapter->lessons))
                                    <ul class="submenu">
                                        @foreach($chapter->lessons as $lesson)
                                            <li class="sub-item">
                                                <a href="{{ route('chapter.show', $chapter) }}"><span>{{ $lesson->title }}</span></a>
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
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    @if(!empty($chapter->title))
                        <span class="text-center"> {{ $chapter->title }}</span>
                    @else
                        <span class="text-center"></span>
                    @endif
                </div>
                <div class="card-header">
                    @if(!empty($lesson->title))
                        {{ $lesson->title }}
                    @else
                        <span class="text-center"></span>
                    @endif
                </div>
                <div class="card-body">
                    @if(!empty($lesson->content))
                        {!! $lesson->content !!}
                    @else
                        <span class="text-center"></span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
