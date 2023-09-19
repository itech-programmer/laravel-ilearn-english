@extends('backend.default.layouts.app')

@section('style')

@endsection

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">User</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="profile-header">
                <div class="row align-items-center">
                    <div class="col-auto profile-image">
                        <a href="#">
                            @if(!empty(auth()->user()->avatar))
                                <img src="{{ asset($user->avatar) }}" class="rounded-circle" alt=" ">
                            @else
                                <img src="{{asset('public/uploads')}}/default/avatar.png" class="rounded-circle" alt=" ">
                            @endif
                        </a>
                    </div>
                    <div class="col ms-md-n2 profile-user-info">
                        <h4 class="user-name mb-2">{{ auth()->user()->full_name }}</h4>
                        <h6 class="text-muted">{{ auth()->user()->roles->implode("name") }}</h6>
                    </div>
                    <div class="col-auto profile-btn">
                        @if(auth()->user()->active_status == 1)
                            <span class="text-success">Activate</span>
                        @else
                            <span class="text-dark">Deactivate</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="profile-menu">
                <ul class="nav nav-tabs nav-tabs-solid">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#password_tab">Password</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content profile-tab-cont">
                <div id="password_tab" class="tab-pane fade show active">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Change Password</h5>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <form method="post" action="{{ route('user.profile.update', auth()->user()) }}">
                                                @method('PUT')
                                                @csrf
                                                <div class="form-group">
                                                    <label>Old Password</label>
                                                    <input type="password" name="old_password" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>New Password</label>
                                                    <input type="password" id="new_password" name="new_password" class="form-control" onkeyup="check()"/>
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" onkeyup="check()"/>
                                                </div>
                                                <button class="btn btn-primary" type="submit">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    function check() {
        const password = document.getElementById('new_password');
        const confirm = document.getElementById('confirm_password');
        if (confirm.value === password.value) {
            password.classList.remove('is-invalid');
            password.classList.add('is-valid');
            confirm.classList.remove('is-invalid');
            confirm.classList.add('is-valid');
        } else {
            password.classList.remove('is-valid');
            password.classList.add('is-invalid');
            confirm.classList.remove('is-valid');
            confirm.classList.add('is-invalid');
        }
    }
</script>
@endsection
