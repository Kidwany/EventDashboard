<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
    <link rel="icon" href="{{asset('general/hemmtk.jpeg')}}" type="image/x-icon"> <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>همتك -  @yield('title')</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC0h_0sd5Dj3UoCAoZc8a3iAH8_VGBXE8o&callback=initMap&libraries=&v=weekly"
        defer
    ></script>
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <!-- Colorpicker Css -->
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" />
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>

    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/charts-c3/plugin.css')}}"/>

    <!-- Multi Select Css -->
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/multi-select/css/multi-select.css')}}">
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/morrisjs/morris.min.css')}}" />
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/select2/select2.css')}}">
    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="{{assetPath('dashboard/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />
    <!-- Custom Css -->
    <script src="{{assetPath('dashboard/assets/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
    <!-- Multi Select Plugin Js -->
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/css/style.min.css')}}">

    <!-- Bootstrap Min CSS -->
    <!-- Fonts and icons -->
    @yield('customizedStyle')

</head>







<body class=" rtl theme-orange">

<div id="app">
    <main>
        <!-- Page Loader -->
        <div class="page-loader-wrapper">
            <div class="loader">
                <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('dashboard/assets/images/loader.svg')}}" width="48" height="48" alt="Aero"></div>
                <p>جاري التحميل...</p>
            </div>
        </div>

        <!-- Overlay For Sidebars -->
        <div class="overlay"></div>

        @include('dashboard.layouts.quickMenu')
        @include('dashboard.layouts.sidemenu')
        <section class="content">
            @yield('content')

        </section>
    </main>

</div>






{{--<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>--}}
<!-- JS
============================================ -->
<!-- Jquery Core Js -->
<script src="{{asset('dashboard/assets/bundles/libscripts.bundle.js')}}"></script>
<!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) -->
<script src="{{asset('dashboard/assets/bundles/vendorscripts.bundle.js')}}"></script>
<script src="{{assetPath('dashboard/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js')}}"></script> <!-- Bootstrap Colorpicker Js -->
<!-- slimscroll, waves Scripts Plugin Js -->
<script src="{{assetPath('dashboard/assets/bundles/morrisscripts.bundle.js')}}"></script> <!-- Morris Plugin Js -->

<script src="{{asset('dashboard/assets/bundles/jvectormap.bundle.js')}}"></script>
<!-- JVectorMap Plugin Js -->
<script src="{{asset('dashboard/assets/bundles/sparkline.bundle.js')}}"></script>
<script src="{{assetPath('dashboard/assets/bundles/knob.bundle.js')}}"></script>
<!-- Sparkline Plugin Js -->
<script src="{{asset('dashboard/assets/bundles/c3.bundle.js')}}"></script>

<script src="{{assetPath('dashboard/assets/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{assetPath('dashboard/assets/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{assetPath('dashboard/assets/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{assetPath('dashboard/assets/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{assetPath('dashboard/assets/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{assetPath('dashboard/assets/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{assetPath('dashboard/assets/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>

<script src="{{assetPath('dashboard/assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{assetPath('dashboard/assets/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js -->
<script src="{{assetPath('dashboard/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{assetPath('dashboard/assets/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{assetPath('dashboard/assets/js/pages/ecommerce.js')}}"></script>
<script src="{{assetPath('dashboard/assets/js/pages/charts/jquery-knob.min.js')}}"></script>
<script src="{{assetPath('dashboard/assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{assetPath('dashboard/assets/js/pages/index.js')}}"></script>
<script src="{{assetPath('dashboard/assets/js/pages/forms/basic-form-elements.js')}}"></script>
<script src="{{assetPath('dashboard/assets/js/pages/blog/blog.js')}}"></script>

@yield('customizedScript')



</body>
</html>
