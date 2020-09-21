@extends('dashboard.layouts.layouts')
@section('title', 'الأدوار')
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
                <div class="col-lg-12 col-md-6 col-sm-12">
                    <h2>الأدوار </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="{{adminUrl('gates/' . $floor->event_id)}}">الأدوار </a></li>
                        <li class="breadcrumb-item active"> دور جديد </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            @include('dashboard.layouts.messages')
            <!-- Vertical Layout -->
            <form action="{{url('floors/'. $floor->id .'/update')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <input type="hidden" name="event_id" value="{{$floor->event_id}}">
                <div class="card">
                    @include('dashboard.layouts.messages')
                    <div class="header">
                        <h2><strong>تعديل الدور</strong></h2>
                    </div>
                    <section id="gates">
                        <div class="body">
                            <div class="row" >
                                <div class="col-lg-6 col-md-12 col-sm-3">
                                    <label for="email_address">رقم الدور</label>
                                    <div class="form-group d-flex justify-content-between">
                                        <input type="text" value="{{$floor->floor_no}}" name="no" id="email_address" class="form-control" placeholder="ادخل اسم الدور">
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
