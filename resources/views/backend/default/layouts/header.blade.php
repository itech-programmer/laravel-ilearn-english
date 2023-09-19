<div class="header-left">
    <a href="{{ route('backend.index') }}" class="logo">
        @if(!empty($general_settings->app_logo))
            <img src="{{asset($general_settings->app_logo)}}" alt="">
        @else
            <img src="{{ asset('public/uploads') }}/defaults/logo.png" alt="Logo">
        @endif
    </a>
</div>
<a href="javascript:void(0);" id="toggle_btn">
<i class="fas fa-align-left"></i>
</a>
<div class="top-nav-search">

</div>

<a class="mobile_btn" id="mobile_btn">
<i class="fas fa-bars"></i>
</a>

<ul class="nav user-menu">
    <li class="nav-item dropdown has-arrow">
        <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
            <span class="user-img">
                @if(!empty(auth()->user()->avatar))
                    <img src="{{ asset(auth()->user()->avatar) }}" width="31" class="rounded-circle" alt=""/>
                @else
                    <img src="{{ asset('public/uploads') }}/defaults/avatar.png" width="31" class="rounded-circle" alt=""/>
                @endif
            </span>
        </a>
        <div class="dropdown-menu">
            <div class="user-header">
                <div class="avatar avatar-sm">
                    @if(!empty(auth()->user()->avatar))
                        @if(Cache::has('user-is-online-' . auth()->user()->id))
                            <div class="avatar avatar-online">
                                <img src="{{ asset(auth()->user()->avatar) }}" class="avatar-img rounded-circle" alt=""/>
                            </div>
                        @else
                            <div class="avatar avatar-offline">
                                <img src="{{ asset(auth()->user()->avatar) }}" class="avatar-img rounded-circle" alt=""/>
                            </div>
                        @endif
                    @else
                        @if(Cache::has('user-is-online-' . auth()->user()->id))
                            <div class="avatar avatar-online">
                                <img src="{{ asset('public/uploads') }}/defaults/avatar.png" class="avatar-img rounded-circle" alt=""/>
                            </div>
                        @else
                            <div class="avatar avatar-offline">
                                <img src="{{ asset('public/uploads') }}/defaults/avatar.png" class="avatar-img rounded-circle" alt=""/>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="user-text">
                    <h6>{{ auth()->user()->full_name }}</h6>
                    <p class="text-muted mb-0">{{ auth()->user()->roles->implode('name') }}</p>
                </div>
            </div>
            <a class="dropdown-item" href="{{ route('user.profile', auth()->user()) }}">My Profile</a>
            <form method="POST" action="{{route('user.profile.logout')}}" id="logout-form">
            @csrf
            <a class="dropdown-item" href="{{ route('user.profile.logout') }}"
               onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
             Logout
            </a>
            </form>
        </div>
    </li>

</ul>
