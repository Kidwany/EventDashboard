<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
    <link rel="icon" href="{{asset('general/hemmtk.jpeg')}}" type="image/x-icon"> <!-- Favicon-->

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CV-{{$user->name}}</title>

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
                        <div class="col-lg-4 col-md-12">
                            <div class="card mcard_3">
                                <div class="body">
                                    <a href="{{adminUrl('user/' . $user->id)}}">
                                        <img src="{{$user->image_id ? $user->image->url : assetPath('dashboard/assets/images/user.png')}}"
                                             class="rounded-circle shadow " alt="profile-image"
                                             style="width: 250px; height: 250px; object-fit: cover; object-position: center center"
                                        >
                                    </a>
                                    <h4 class="m-t-10">{{$user->name}}</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            {{--<form action="{{route('user.update', 5)}}" method="post">
                                                @csrf
                                                @method('patch')
                                                <button type="submit" class="btn btn-danger">تعطيل الحساب</button>
                                            </form>--}}
                                        </div>
                                        <div class="col-12">
                                            <p class="text-muted">
                                                @if($user->serviceProviderJobs->count())
                                                    @foreach($user->serviceProviderJobs as $job)
                                                        {{$job->job_ar}}
                                                    @endforeach
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <small>عدد الفعاليات</small>
                                            <h5>{{$total_user_events}}</h5>
                                        </div>
                                        <div class="col-6">
                                            <small> عدد الطلبات </small>
                                            <h5>{{$requests}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="body">
                                    <small class="text-muted">البريد الإلكتروني: </small>
                                    <p>{{$user->email}}</p>
                                    <hr>
                                    <small class="text-muted">الجوال: </small>
                                    <p>{{$user->phone}}</p>
                                    <hr>
                                </div>
                            </div>
                            <div class="card">
                                <div class="body">
                                    <small class="text-muted">الوظيفة : </small>
                                    <p>
                                        @foreach($user->serviceProviderJobs as $job)
                                            {{$job->job_ar}}
                                        @endforeach
                                    </p>
                                    <hr>
                                    <small class="text-muted">اللغة: </small>
                                    <p>{{$user->lang ? ($user->lang == 'ar' ? 'العربية' : 'الإنجليزية') : 'العربية'}}</p>
                                    <hr>
                                    <small class="text-muted">تم التسجيل في: </small>
                                    <p>{{$user->created_at->format('d M Y')}}  {{$user->created_at->format('h:i:s')}}</p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="body">
                                    <small class="text-muted">الدولة : </small>
                                    <p>{{$user->country_id ? $user->country->country_ar->title : ''}}</p>
                                    <hr>
                                    <small class="text-muted">المدينة: </small>
                                    <p>{{$user->city_id ? $user->city->city_ar->title : ''}}</p>
                                    <hr>
                                    <small class="text-muted">الجنسية: </small>
                                    <p>{{$user->nationality_id ? $user->nationality->nationality_ar : ''}}</p>
                                    <hr>
                                    <small class="text-muted">العنوان: </small>
                                    <p>{{$user->address}}</p>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h2><strong>بيانات</strong> البنك</h2>
                                </div>
                                <div class="body mb-2">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <p class="text-muted">البنك : </p>
                                            <h3>{{$user_payment->bank}}</h3>
                                        </div>
                                        <div class="col-lg-6">
                                            <p class="text-muted">رقم الأيبان : </p>
                                            <h3>{{$user_payment->ipan_no}}</h3>
                                        </div>
                                    </div>


                                    <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                                    </div>
                                </div>

                            </div>
                            <div class="row clearfix">
                                @if($sp_doc->second_identity_image_id)
                                    <div class="col-lg-6 col-md-12">
                                        <div class="card">
                                            <div class="body">
                                                <img class="img-responsive" src="{{$sp_doc->identityImage->url}}" alt="About the image" style="height: 250px">
                                                <div class="mt-4 pw_header">
                                                    <h6>صورة تحقيق الشخصية</h6>
                                                    <small class="text-muted">تاريخ الإنتهاء  |  {{$sp_doc->passport_expire_date}}</small>
                                                </div>
                                                <div class="pw_meta">
                                                    <span>{{$sp_doc->passport_no}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="card">
                                            <div class="body">
                                                <img class="img-responsive" src="{{$sp_doc->back_image->url}}" alt="About the image" style="height: 250px">
                                                <div class="mt-4 pw_header">
                                                    <h6>صورة الخلفية</h6>
                                                    <small class="text-muted">تاريخ الإنتهاء  |  {{$sp_doc->passport_expire_date}}</small>
                                                </div>
                                                <div class="pw_meta">
                                                    <span>{{$sp_doc->passport_no}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-12 col-md-12 mb-3">
                                        <div class="card">
                                            <div class="body">
                                                <img class="img-responsive" src="{{$sp_doc->identityImage->url}}" alt="About the image" style="height: 500px">
                                                <div class="mt-4 pw_header">
                                                    <h6>صورة تحقيق الشخصية</h6>
                                                    <small class="text-muted">تاريخ الإنتهاء  |  {{$sp_doc->passport_expire_date}}</small>
                                                </div>
                                                <div class="pw_meta">
                                                    <span>{{$sp_doc->passport_no}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            {{--<div class="card">
                                <div class="header">
                                    <h2><strong>الفعاليات </strong> السابقة</h2>
                                </div>
                                <div class="body">

                                    <div class="table-responsive">
                                        <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                            <tr>
                                                <th>م</th>
                                                <th>الافعالية</th>
                                                <th> الشركة </th>
                                                <th> التاريخ </th>
                                                <th>تعديل</th>
                                            </tr>
                                            </thead>
                                            <tfoot>
                                            <tr>
                                                <th>م</th>
                                                <th>الافعالية</th>
                                                <th> الشركة </th>
                                                <th> التاريخ </th>
                                                <th>تعديل</th>
                                            </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach($events as $event)
                                                <tr>
                                                    <td>{{$event->id}}</td>
                                                    <td>{{$event->title}}</td>
                                                    <td>{{$event->organization->name}}</td>
                                                    <td>{{$event->event_date}}</td>
                                                    <td>
                                                        <a href="{{adminUrl('event/' . $event->id)}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-eye"></i> </a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>--}}

                            <div class="card">
                                <div class="header">
                                    <h2><strong>الأعمال</strong> السابقة</h2>
                                </div>
                                @if($sp_experience)
                                    @foreach($sp_experience as $experience)
                                        <div class="body mb-2">
                                            <div class="blogitem">
                                                <div class="blogitem-content">
                                                    <div class="blogitem-header">
                                                        <div class="blogitem-meta">
                                                            <span><i class="zmdi zmdi-calendar"></i>من <a href="javascript:void(0);">{{$experience->start_date ? $experience->start_date->format('D M Y') : ''}}</a></span>
                                                            <span><i class="zmdi zmdi-calendar"></i>الى<a href="javascript:void(0);">{{$experience->end_date ? $experience->end_date->format('D M Y') : ''}}</a></span>
                                                        </div>
                                                    </div>
                                                    <h5><a href="javascript:void(0);">{{$experience->job_title}}</a></h5>
                                                    <p>
                                                        {{$experience->job_description}}
                                                    </p>
                                                    <a href="javascript:void(0);" class="btn btn-info">{{$experience->company}}</a>
                                                </div>
                                            </div>

                                            <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                                                @if($experience->images->count())
                                                    @foreach($experience->images as $image)
                                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 m-b-30"> <a href="{{$image->url}}"> <img class="img-fluid img-thumbnail" src="{{assetPath($image->path)}}" alt=""> </a> </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
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
