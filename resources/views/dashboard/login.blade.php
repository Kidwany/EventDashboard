<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
    <link rel="icon" href="{{asset('general/hemmtk.jpeg')}}" type="image/x-icon"> <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>همتك - تسجيل الدخول</title>

    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/charts-c3/plugin.css')}}"/>

    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/morrisjs/morris.min.css')}}" />
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{assetPath('dashboard/assets/css/style.min.css')}}">

    <!-- Bootstrap Min CSS -->
    <!-- Fonts and icons -->
    @yield('customizedStyle')

</head>







<body class=" rtl theme-orange">

<div id="app">
    <main>
        <div class="authentication">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <form class="card auth_form" action="{{url('admin-login')}}" method="post">
                            @csrf
                            <div class="header">
                                <img class="logo" src="{{asset('general/hemmtk.jpeg')}}" alt="" style="height: auto; width: 80%">
                                <h5> تسجيل الدخول</h5>
                            </div>
                            <div class="body">
                                @include('dashboard.layouts.messages')

                                <div class="input-group mb-3">
                                    <input type="email" name="email" class="form-control" placeholder="ادخل البريد الإلكتروني" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                    </div>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" placeholder="ادخل كلمة السر" name="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="checkbox">
                                    <input id="remember_me" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember_me"> تذكرني</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light"> تسجيل الدخول</button>
                                <div class="signin_with mt-3">
                                    <a class="link" href="{{route('register')}}">حساب جديد</a>
                                </div>
                            </div>
                        </form>
                        <div class="copyright text-center">
                            &copy;
                            <script>document.write(new Date().getFullYear())</script>,
                            <span>جميع الحقوق محفوظة <a href="#" target="_blank">همتك</a></span>
                        </div>
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <div class="card">
                            <img src="{{assetPath('dashboard/assets/images/signin.svg')}}" alt="Sign In"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

<script src="{{asset('dashboard/assets/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{asset('dashboard/assets/js/pages/tables/jquery-datatable.js')}}"></script>
<script src="{{asset('dashboard/assets/js/pages/index.js')}}"></script>

@yield('customizedScript')

</body>
</html>
