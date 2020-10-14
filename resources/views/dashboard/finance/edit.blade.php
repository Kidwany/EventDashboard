@extends('dashboard.layouts.layouts')
@section('title', 'البيانات المالية')
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
                    <h2>البيانات المالية </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="{{adminUrl('finance/' . $event_gate->event_id)}}">البيانات المالية </a></li>
                        <li class="breadcrumb-item active"> البيانات المالية </li>
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
                                <li class="nav-item"><a class="nav-link {{Request::is('event/*') ? 'active' : ''}}"         href="{{adminUrl('event/' . $event_gate->event_id)}}"> <i class="zmdi zmdi-inbox"></i> الفعالية </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('applicants/*') ? 'active' : ''}}"    href="{{adminUrl('applicants/' . $event_gate->event_id)}}"><i class="zmdi zmdi-group-work"></i> الطلبات </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('groups/*') ? 'active' : ''}}"        href="{{adminUrl('groups/' . $event_gate->event_id)}}"><i class="zmdi zmdi-badge-check"></i> المجموعات </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('floors/*') ? 'active' : ''}}"        href="{{adminUrl('floors/' . $event_gate->event_id)}}"><i class="zmdi zmdi-accounts"></i> الأدوار </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('gates/*') ? 'active' : ''}}"         href="{{adminUrl('gates/' . $event_gate->event_id)}}"><i class="zmdi zmdi-store"></i> البيانات المالية </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('organizers/*') ? 'active' : ''}}"    href="{{adminUrl('organizers/' . $event_gate->event_id)}}"><i class="zmdi zmdi-fire"></i> المنظمين </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('tasks/*') ? 'active' : ''}}"         href="{{adminUrl('tasks/' . $event_gate->event_id)}}"><i class="zmdi zmdi-view-list-alt"></i> المهام </a></li>
                                <li class="nav-item"><a class="nav-link {{Request::is('tracking/*') ? 'active' : ''}}"      href="{{adminUrl('tracking/' . $event_gate->event_id)}}"><i class="zmdi zmdi-map"></i> التتبع </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            @include('dashboard.layouts.messages')
            <!-- Vertical Layout -->
                <form action="{{url('gates/'. $event_gate->id .'/update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="event_id" value="{{$event_gate->event_id}}">
                    <div class="card">
                        @include('dashboard.layouts.messages')
                        <div class="header">
                            <h2><strong>تعديل البوابة</strong></h2>
                        </div>
                        <section id="gates">
                            <div class="body">
                                <div class="row" >
                                    <div class="col-lg-6 col-md-6">
                                        <label> النوع</label>
                                        <select name="gate_type_id" class="form-control show-tick ms select2"  data-placeholder="اختر الخدمات التي تقدمها المغسلة">
                                            @if($gates_types)
                                                @foreach($gates_types as $gate)
                                                    <option value="{{$gate->id}}" {{$event_gate->type_id == $gate->id ? 'selected' : ''}}>{{$gate->type_ar}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم البوابة</label>
                                        <div class="form-group d-flex justify-content-between">
                                            <input type="text" value="{{$event_gate->name}}" name="gate_name" id="email_address" class="form-control" placeholder="ادخل اسم البوابة">
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
