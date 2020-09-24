@extends('dashboard.layouts.layouts')
@section('title', 'الرعاة')
@section('customizedStyle')
    <style>
        .colors ul{list-style:none; padding:0; margin: 0;}

        .colors li{margin: 0 20px 0 0; display: inline-block;}

        .colors label{cursor: pointer;}

        .colors input{display:none;}

        .colors input[type="radio"]:checked + .swatch{box-shadow: inset 0 0 0 2px white;}

        .swatch{
            display:inline-block;
            vertical-align: middle;
            height: 30px;
            width:30px;
            margin: 0 5px 0 0 ;
            border: 1px solid #d4d4d4;
        }
    </style>
@endsection

@section('customizedScript')
    <script>$(function () {
            // Basic instantiation:
            $('#car_color').colorpicker();

            // Example using an event, to change the color of the #demo div background:
            $('#car_color').on('colorpickerChange', function(event) {
                $('.input-group-addon').css('background-color', event.color.toString());
            });
        });
    </script>
    <script>
        $('.select2').select2()
    </script>
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>الرعاة </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="{{adminUrl('sponsors/' . $event->id)}}">الرعاة </a></li>
                        <li class="breadcrumb-item active"> راعي جديد </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                                <li class="nav-item"><a class="nav-link {{Request::is('event/*') ? 'active' : ''}}"         href="{{adminUrl('event/' . $event->id)}}"> <i class="zmdi zmdi-inbox"></i> الفعالية </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('applicants/*') ? 'active' : ''}}"    href="{{adminUrl('applicants/' . $event->id)}}"><i class="zmdi zmdi-group-work"></i> الطلبات </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('groups/*') ? 'active' : ''}}"        href="{{adminUrl('groups/' . $event->id)}}"><i class="zmdi zmdi-badge-check"></i> المجموعات </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('floors/*') ? 'active' : ''}}"        href="{{adminUrl('floors/' . $event->id)}}"><i class="zmdi zmdi-accounts"></i> الأدوار </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('gates/*') ? 'active' : ''}}"         href="{{adminUrl('gates/' . $event->id)}}"><i class="zmdi zmdi-store"></i> الرعاة </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('organizers/*') ? 'active' : ''}}"    href="{{adminUrl('organizers/' . $event->id)}}"><i class="zmdi zmdi-fire"></i> المنظمين </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('tasks/*') ? 'active' : ''}}"         href="{{adminUrl('tasks/' . $event->id)}}"><i class="zmdi zmdi-view-list-alt"></i> المهام </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('tracking/*') ? 'active' : ''}}"      href="{{adminUrl('tracking/' . $event->id)}}"><i class="zmdi zmdi-map"></i> التتبع </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('sponsors/*') ? 'active' : ''}}"      href="{{adminUrl('finance/' . $event->id)}}"><i class="zmdi zmdi-money"></i> البيانات المالية </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('dashboard.layouts.financeNav')

        <div class="container-fluid">
            @include('dashboard.layouts.messages')
            <!-- Vertical Layout -->
                <form action="{{url('sponsors/' . $sponsor->id . '/update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    <div class="card">
                        @include('dashboard.layouts.messages')
                        <div class="header">
                            <h2><strong>اضف الرعاة و أنواعها</strong></h2>
                        </div>
                        <section id="gates">
                            <div class="body">
                                <div class="row" >

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">فئة الراعي</label>
                                        <div class="form-group d-flex justify-content-between">
                                            <input required type="text" value="{{$sponsor->category}}" name="category" id="email_address" class="form-control" placeholder="ادخل فئة الراعي">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم الراعي</label>
                                        <div class="form-group d-flex justify-content-between">
                                            <input required type="text" value="{{$sponsor->sponsor_name}}" name="name" id="email_address" class="form-control" placeholder="ادخل اسم الراعي">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">السعر المتوقع (ر.س)</label>
                                        <div class="form-group d-flex justify-content-between">
                                            <input step="any" type="number" value="{{$sponsor->expected_sponsorship_value}}" name="expected" id="email_address" class="form-control" placeholder="ادخل السعر المتوقع">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">السعر الفعلي (ر.س)</label>
                                        <div class="form-group d-flex justify-content-between">
                                            <input step="any" type="number" value="{{$sponsor->real_sponsorship_value}}" name="real" id="email_address" class="form-control" placeholder="ادخل السعر الفعلي">
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">حفظ</button>
                            </div>
                        </section>
                    </div>
                </form>
        </div>
    </div>

@endsection
