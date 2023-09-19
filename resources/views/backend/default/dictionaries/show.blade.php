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
                <h4 class="text-capitalize mt-3 mb-0">{{ $dictionary->en_word }}</h4>
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('dictionaries.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div id="category-wrapper">
                <h5>Words</h5>
                <ul class="menu">
                    <li class="item">
                        <a href="javascript:void(0);" disabled="">English</a>
                        @if(!empty($dictionary->en_word))
                            <ul class="submenu">
                                @if(!empty($dictionary->en_word))
                                    <li class="sub-item">
                                        <a><span>{{ $dictionary->en_word }}</span></a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </li>
                    <li class="item">
                        <a href="javascript:void(0);" disabled="">Uzbek</a>
                        @if(!empty($dictionary->uz_word))
                            <ul class="submenu">
                                @if(!empty($dictionary->uz_word))
                                    <li class="sub-item">
                                        <a><span>{{ $dictionary->uz_word }}</span></a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </li>
                    <li class="item">
                        <a href="javascript:void(0);" disabled="">Karakalpak</a>
                        @if(!empty($dictionary->qr_word))
                            <ul class="submenu">
                                @if(!empty($dictionary->qr_word))
                                    <li class="sub-item">
                                        <a><span>{{ $dictionary->qr_word }}</span></a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </li>
                    <li class="item">
                        <a href="javascript:void(0);" disabled="">Russian</a>
                        @if(!empty($dictionary->ru_word))
                            <ul class="submenu">
                                @if(!empty($dictionary->ru_word))
                                    <li class="sub-item">
                                        <a><span>{{ $dictionary->ru_word }}</span></a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs nav-tabs-bottom nav-justified">
                        <li class="nav-item"><a class="nav-link active" href="#english" data-bs-toggle="tab">English</a></li>
                        <li class="nav-item"><a class="nav-link" href="#uzbek" data-bs-toggle="tab">Uzbek</a></li>
                        <li class="nav-item"><a class="nav-link" href="#karakalpak" data-bs-toggle="tab">Karakalpak</a></li>
                        <li class="nav-item"><a class="nav-link" href="#russian" data-bs-toggle="tab">Russian</a></li>
                    </ul>
                </div>
                <div class="card-body">

                    <div class="tab-content">
                        <div class="tab-pane show active" id="english">
                            @if(!empty($dictionary->en_definition))
                                <div class="card-body">
                                    <div class="inner-all">
                                        {!! $dictionary->en_definition !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="uzbek">
                            @if(!empty($dictionary->uz_definition))
                                <div class="card-body">
                                    <div class="inner-all">
                                        {!! $dictionary->uz_definition !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="karakalpak">
                            @if(!empty($dictionary->qr_definition))
                                <div class="card-body">
                                    <div class="inner-all">
                                        {!! $dictionary->qr_definition !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane" id="russian">
                            @if(!empty($dictionary->ru_definition))
                                <div class="card-body">
                                    <div class="inner-all">
                                        {!! $dictionary->ru_definition !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
