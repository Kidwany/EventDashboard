@extends('dashboard.layouts.layouts')
@section('title', 'الإستراحة')
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

@section('ajax')
    <script>
        function addMinutes() {
            let event_id = $('input[name=event_id]').val();
            let group_id = $('input[name=group_id]').val();
            let user_id = $('input[name=user_id]').val();
            let minutes = $('input[name=minutes]').val();
            let _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{adminUrl('break/add-break-to-user')}}",
                type: "POST",
                data: {
                    event_id : event_id,
                    group_id : group_id,
                    user_id : user_id,
                    minutes : minutes,
                    _token : _token
                },
                success: function (response) {
                    console.log(response["errors"]);
                    if (response["errors"])
                    {
                        $('#notification').empty();
                        var errors = '<ul>';
                        $.each(response["errors"], function (key, value) {
                            errors += '<li>'+ value +'</li>';
                        });
                        errors += '</ul>';
                        $('#notification').append('<div class="alert alert-danger" style="direction: rtl">'+errors+'</div>')
                    }
                    if (response["error"])
                    {
                        $('#notification').empty();
                        $('#notification').append('<div class="alert alert-danger" style="direction: rtl">'+response["error"]+'</div>')
                    }
                    if (response["success"])
                    {
                        $('#notification').empty();
                        $('#notification').append('<div class="alert alert-success" style="direction: rtl">'+ response["success"] +'</div>');
                        $('form').submit();
                    }
                }
            })
        }
    </script>
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>الإستراحة </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="#">الإستراحة </a></li>
                        <li class="breadcrumb-item active"> استراحة جديدة </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        @include('dashboard.layouts.eventNav')

        <div class="container-fluid">
            @include('dashboard.layouts.messages')
                <div id="notification"></div>
            <!-- Vertical Layout -->
            <form action="{{adminUrl('break/' . $event->id)}}" method="get" enctype="multipart/form-data">
                @csrf
                <div class="row clearfix">

                    <input type="hidden" name="group_id" value="{{$user->member->group->id}}">
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>اضف بيانات الإستراحة </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">مدة الإستراحة</label>
                                        <div class="form-group">
                                            <input required type="number" max="2" name="minutes" value="{{old('name')}}" class="form-control" placeholder="ادخل مدة الإستراحة بالدقائق">
                                        </div>
                                    </div>

                                </div>
                                <button type="button" onclick="addMinutes()" class="btn btn-raised btn-primary btn-round waves-effect">حفظ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
