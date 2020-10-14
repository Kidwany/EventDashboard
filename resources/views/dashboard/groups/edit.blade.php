@extends('dashboard.layouts.layouts')
@section('title', 'المجموعات')
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
                    <h2>المجموعات </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="{{adminUrl('groups/' . $event->id)}}">المجموعات </a></li>
                        <li class="breadcrumb-item active"> مجموعة جديدة </li>
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
            <form action="{{adminUrl('groups/update/'. $group->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row clearfix">
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>اضف بيانات المجموعات </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <label> المنطقة</label>
                                        <select name="zone_id" class="form-control show-tick ms select2"  data-placeholder="اختر المنطقة">
                                            @if($zones)
                                                @foreach($zones as $zone)
                                                    <option value="{{$zone->id}}" {{$group->zone_id == $zone->id ? 'selected' : ''}}>
                                                        {{$zone->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم المجموعة</label>
                                        <div class="form-group">
                                            <input required type="text" name="name" value="{{$group->name}}" id="email_address" class="form-control" placeholder="ادخل اسم المجموعة">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="email_address">اختر لون المجموعة</label>
                                        <div class="colors">
                                            <ul>
                                                @if($colors)
                                                    @foreach($colors as $color)
                                                        <li>
                                                            <label>
                                                                <input required type="radio" name="color" value="{{$color->id}}" {{$color->id == $group->color_id ? 'checked' : ''}}>
                                                                <span class="swatch" style="background-color:{{$color->hex}}"></span>
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label>اضافة مستخدمين للمجموعة</label>
                                        <select name="users[]" class="form-control show-tick ms select2"  multiple data-placeholder="اختر اعضاء المجموعة من بين المستخدمين">
                                            @if($users)
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}"
                                                    @foreach($group->users as $group_user)
                                                        {{$group_user->id == $user->id ? 'selected' : ''}}
                                                    @endforeach
                                                    >
                                                        {{$user->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اضافة مرفقات للمجموعة</label>
                                        <div class="form-group">
                                            <input multiple type="file" name="attaches[]" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <label>اضافة مشرفين للمجموعة</label>
                                        <select name="manager[]" class="form-control show-tick ms select2"  multiple data-placeholder="اختر اعضاء المجموعة من بين المستخدمين">
                                            @if($users)
                                                @foreach($users as $user)
                                                    <option value="{{$user->id}}"
                                                    @foreach($group->managers as $group_user)
                                                        {{$group_user->id == $user->id ? 'selected' : ''}}
                                                        @endforeach
                                                    >{{$user->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">حفظ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="container-fluid file_manager">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="tab-content">
                            <div class="tab-pane active" id="doc">
                                <div class="row clearfix">
                                    @if($group->files)
                                        @foreach($group->files as $file)
                                            <div class="col-lg-3 col-md-4 col-sm-12">
                                                <div class="card">
                                                    <div class="file">
                                                        <a href="{{$file->url}}" download>
                                                            <div class="hover">
                                                                {{--<button type="submit" form="deleteFile{{$file->id}}" class="btn btn-icon btn-icon-mini btn-round btn-danger">
                                                                    <i class="zmdi zmdi-delete"></i>
                                                                </button>--}}
                                                            </div>
                                                            <div class="icon">
                                                                <i class="zmdi zmdi-file-text"></i>
                                                            </div>
                                                            <div class="file-name">
                                                                <p class="m-b-5 text-muted">{{$file->name}}</p>
                                                                <small>Size: 42KB <span class="date text-muted">{{$file->created_at}}</span></small>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <form id="deleteFile{{$file->id}}" style="display: none" action="{{url('files/' . $file->id . '/' . $group->id . '/delete')}}" method="post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
