<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- begin::Favicon -->
    @if(!empty($general_settings->app_favicon))
        <link rel="shortcut icon" href="{{ asset($general_settings->app_favicon) }}" />
    @else
        <link rel="shortcut icon" href="{{ asset('public/uploads') }}/default/logo.png" />
    @endif
    <!-- end::Favicon -->

    <title>{{ $general_settings->app_title }}</title>

    <!-- begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700">
    <!-- end::Fonts -->

    <!-- begin::Vendor -->
    <link rel="stylesheet" href="{{ asset('public/auth') }}/default/vendors/bootstrap/css/bootstrap.css">
    <!-- end::Vendor -->

    <!-- begin::App -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/auth') }}/default/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/auth') }}/default/css/app.css">
    <!-- end::App -->

</head>
<body class="login-page">
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center h-100">
            <div class="card-wrapper">
                <div class="brand">
                    @if(!empty($general_settings->app_logo))
                        <img src="{{ asset($general_settings->app_logo) }}" alt="">
                    @else
                        <img src="{{ asset('public/uploads') }}/default/logo.png" alt="">
                    @endif
                </div>
                <div class="card">
                    @yield('content')
                </div>
                <div class="footer">
                    {{ $general_settings->app_copyright_text }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- begin::Vendor -->
<script src="{{ asset('public/auth') }}/default/vendors/jquery/js/jquery-3.3.1.slim.js"></script>
<script src="{{ asset('public/auth') }}/default/vendors/bootstrap/js/bootstrap.js"></script>
<script src="{{ asset('public/auth') }}/default/vendors/popper/js/popper.js"></script>
<!-- end::Vendor -->

<!-- begin::App -->
<script src="{{ asset('public/auth') }}/default/js/app.js"></script>
<!-- end::App -->

</body>
</html>
