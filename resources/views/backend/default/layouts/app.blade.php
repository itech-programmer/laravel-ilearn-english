<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<!--begin::Head-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- begin::Favicon -->
    @if(!empty($general_settings->app_favicon))
        <link rel="shortcut icon" href="{{ asset($general_settings->app_favicon) }}" />
    @else
        <link rel="shortcut icon" href="{{ asset('public/uploads') }}/default/logo.png" />
    @endif
    <!-- end::Favicon --> 

    <title>{{ $general_settings->title }}</title>

    <!-- begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,500;0,600;0,700;1,400&display=swap">
    <!-- end::Fonts -->

    <!-- begin::Vendor -->
    <link rel="stylesheet" href="{{ asset('public/backend') }}/default/vendors/bootstrap/css/bootstrap.min.css">
    <!-- end::Vendor -->

    <!-- begin::Fonts -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/backend') }}/default/fonts/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/backend') }}/default/fonts/line-awesome/css/line-awesome.min.css">
    <!-- end::Fonts -->

    <!-- begin::App -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/backend') }}/default/css/app.css"/>
    <!-- end::App -->

    <!-- begin::Custom -->
    <link rel="stylesheet" href="{{asset('public/backend')}}/default/css/toastr/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('public/backend')}}/default/css/particles/app.css">
    <!-- end::Custom -->

    <!-- begin::Pages -->
@yield('style')
<!-- end::Pages -->
</head>
<!--end::Head-->
<!--begin::Body-->
<body>
<!--begin::Page loader-->
<!-- particles.js container -->
<div id="particles-js"></div>
<!--end::Page Loader-->

<!--begin::Main-->
<div class="main-wrapper">
    <!--begin::Page-->
    <!--begin::Header-->
    <div class="header">
        @include('backend.default.layouts.header')
    </div>
    <!--end::Header-->
    <!--begin::Aside-->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            @include('backend.default.layouts.sidebar')
        </div>
    </div>
    <!--end::Aside-->
    <!--begin::Wrapper-->
    <div class="page-wrapper">
        <div class="content container-fluid">
            <!--begin::Content-->
        @yield('content')
        <!--end::Content-->
        </div>
    </div>
    <!--end::Wrapper-->
    <!--end::Page-->
</div>
<!--end::Main-->

<!-- begin::App -->
<script src="{{ asset('public/backend') }}/default/js/jquery-3.6.0.min.js"></script>
<!--<script type="text/javascript" src="{{ asset('public/backend') }}/default/js/jquery.min.js"></script>-->
<!-- end::App -->

<!-- begin::Vendor -->
<script src="{{ asset('public/backend') }}/default/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('public/backend') }}/default/vendors/slimscroll/jquery.slimscroll.min.js"></script>
<script src="{{ asset('public/backend') }}/default/js/app.js"></script>
<!-- end::Vendor -->

<!-- begin::Custom -->
<script src="{{asset('public/backend')}}/default/js/particles/app.js"></script>
<script src="{{asset('public/backend/')}}/default/js/toastr/toastr.min.js"></script>
<script>
    /* particlesJS.load(@dom-id, @path-json, @callback (optional)); */
    particlesJS.load('particles-js', "{{asset('public')}}/particles.json", function() {
        console.log('callback - particles.js config loaded');
    });
</script>
{!! Toastr::message() !!}
<!-- end::Custom -->

<!-- begin::Pages -->
@yield('script')
<!-- end::Pages -->

</body>
<!--end::Body-->
</html>
