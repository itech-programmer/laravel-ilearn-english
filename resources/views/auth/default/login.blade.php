@extends('auth.default.layouts.app')

@section('content')
    <div class="card-body">
        <h4 class="card-title text-center">Login</h4>
        <form method="POST" action="{{ route('auth') }}">
            @csrf
            <div class="form-group">
                <label for="username"> Username or Email </label>
                <input id="username" type="text" class="form-control {{ $errors->has('username' || 'email') ? ' is-invalid' : '' }}" name="username" value="" required autofocus>
                @if ($errors->has('username' || 'email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('username' || 'email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password"> Password </label>
                <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required data-eye>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <div class="custom-checkbox custom-control">
                    <input type="checkbox" name="remember" id="remember" class="custom-control-input">
                    <label for="remember" class="custom-control-label">Remember Me</label>
                </div>
            </div>

            <div class="form-group m-0">
                <button type="submit" class="btn btn-primary btn-block">
                    Login
                </button>
            </div>
        </form>
    </div>
@endsection
