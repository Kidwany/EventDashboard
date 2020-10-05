@extends('dashboard.layouts.layouts')
@section('title', 'العهدة')
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
                    <h2>العهدة </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="{{adminUrl('guardian-ship/' . $event->id)}}">العهدة </a></li>
                        <li class="breadcrumb-item active"> عهدة جديدة </li>
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
            <!-- Vertical Layout -->
            <form action="{{adminUrl('guardian-ship/'. $guardian_ship->id . '/update')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row clearfix">
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>اضف بيانات العهدة </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم العهدة</label>
                                        <div class="form-group">
                                            <input required type="text" name="name" value="{{$guardian_ship->name}}" id="email_address" class="form-control" placeholder="ادخل اسم العهدة">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <label>اضافة منظم للعهدة</label>
                                        <select name="member_id" class="form-control show-tick ms select2" data-placeholder="اختر اعضاء العهدة من بين المستخدمين">
                                            @if($users)
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}" {{$guardian_ship->sp_id == $user->id ? 'selected' : ''}}>
                                                        {{$user->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="email_address">تم استلام العهدة</label>
                                        <div class="checkbox">
                                            <input id="returned" name="returned" type="checkbox" value="1">
                                            <label for="returned">
                                                تم استلام العهدة بنفس حالتها
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">حفظ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
