@extends('backend.default.layouts.app')

@section('style')

@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center bg-white p-2">
            <div class="col">
            </div>
            <div class="col-auto text-end float-end ms-auto">
                <a href="{{ route('users.index') }}" class="btn btn-primary"><i class="fas fa-list"></i></a>
            </div>
        </div>
    </div>
    <div class="row mt-6">
        <div class="col-xl-3 col-lg-5 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="inner-all">
                        <ul class="list-unstyled">
                            <li class="text-center border-bottom-0">
                                @if(!empty($user->avatar))
                                    <img src="{{ asset($user->avatar) }}" class="card-img-top" alt=" ">
                                @else
                                    <img src="{{asset('public/uploads')}}/default/avatar.png" class="card-img-top" alt=" ">
                                @endif
                            </li>
                            <li class="text-center">
                                <h4 class="text-capitalize mt-3 mb-0">{{ $user->full_name }}</h4>
                                <p class="text-muted text-capitalize">{{ $user->roles->implode('name') }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
