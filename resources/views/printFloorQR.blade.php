<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
    <link rel="icon" href="{{asset('general/hemmtk.jpeg')}}" type="image/x-icon"> <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ID-{{$floor->floor_no}}</title>

    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <!-- Colorpicker Css -->
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css')}}" />
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"/>
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/charts-c3/plugin.css')}}"/>
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/morrisjs/morris.min.css')}}" />
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/select2/select2.css')}}">
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/css/style.min.css')}}">
    <style>
        * {
            box-sizing: border-box;
        }
        .id-wrapper {
            direction: rtl;
            background-color: #f7f8fa;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            width: 500px;
            height: auto;
            position: relative;
        }
        .logo-div {
            display: flex;
            justify-content: center;
            background-color: #fff;
            padding: 12px;
            border-radius: 4px 4px 0 0;
            /* position: absolute;
            left: 44%;
            top: 8px;
            transform: translateX(-50%); */
        }
        .logo-div img {
            height: 42px;
        }
        .main-content {
            display: flex;
            padding: 12px;
        }
        .profile-content {
            flex-basis: 50%;
        }
        .qr-wrapper {
            flex-basis: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-evenly;
        }
        .qr-wrapper img {
            height: 160px;
        }
        .profile-content {
            text-align: center;
        }
        .profile-img {
            display: flex;
            justify-content: center;
        }
        .profile-img img {
            width: 160px;
            height: 160px;
            object-fit: fill;
            object-position: top center;
            border-radius: 50%;
            background-color: #ddd;
        }
        .name {
            margin: 12px 8px;
            margin-bottom: 6px;
            font-size: 20px;
        }
        .job {
            font-size: 18px;
        }
    </style>
    <style>
        .card .body
        {
            font-size: 16px;
        }

        @media print {
            .myDivToPrint {
                background-color: white;
                height: 100%;
                width: 100%;
                position: fixed;
                top: 0;
                left: 0;
                margin: 0;
                padding: 15px;
                font-size: 18px;
                line-height: 18px;
            }
        }
    </style>
</head>







<body class=" rtl theme-orange" onload="window.print();">

<div id="app">
    <main>

        <section class="content" style="margin: 0">
            <div class="body_scroll">
                <div class="container-fluid elm" id="print">
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-8">

                            <div class="id-wrapper">
                                <div class="logo-div">
                                    <img src="https://www.admin.hemmtk.com/general/hemmtk.jpeg" alt="logo" />
                                </div>
                                <div class="main-content">
                                    <div class="profile-content">
                                        {{--<div class="profile-img">
                                            <img src="{{assetPath('general/hemmtk.jpeg')}}" alt="profile" />
                                        </div>--}}
                                        <div class="name">الطابق رقم {{$floor->floor_no}}  </div>
                                        {{--<div class="job">
                                            تسجيل الحضور
                                        </div>--}}
                                    </div>
                                    <div class="qr-wrapper">
                                        <img src="{{$floor->barcode}}" alt="qr code" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
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
<script src="{{asset('dashboard/assets/bundles/jvectormap.bundle.js')}}"></script>
<!-- JVectorMap Plugin Js -->
<script src="{{asset('dashboard/assets/bundles/sparkline.bundle.js')}}"></script>
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
<script src="{{assetPath('dashboard/assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{assetPath('dashboard/assets/js/pages/index.js')}}"></script>
<script src="{{assetPath('dashboard/assets/js/pages/forms/basic-form-elements.js')}}"></script>

</body>
</html>
