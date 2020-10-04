@extends('dashboard.layouts.layouts')
@section('title', 'الشركات')
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
                    <h2>الشركات </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="{{adminUrl('company/' . $company->event_id)}}">الشركات </a></li>
                        <li class="breadcrumb-item active"> شركة جديدة </li>
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
            <form action="{{adminUrl('company/'. $company->id . '/update')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row clearfix">
                    <input type="hidden" name="event_id" value="{{$company->event_id}}">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>اضف بيانات الشركات </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم الشركة</label>
                                        <div class="form-group">
                                            <input required type="text" name="name" value="{{$company->name}}" id="email_address" class="form-control" placeholder="ادخل اسم الشركة">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">البريد الإلكتروني</label>
                                        <div class="form-group">
                                            <input required type="email" name="email" value="{{$company->email}}" id="email_address" class="form-control" placeholder="ادخل البريد الإلكتروني">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">وصف الشركة</label>
                                        <div class="form-group">
                                            <input required type="text" name="description" value="{{$company->description}}" id="email_address" class="form-control" placeholder="ادخل وصف الشركة">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">هاتف الشركة</label>
                                        <div class="form-group">
                                            <input required type="text" name="phone" value="{{$company->phone}}" id="email_address" class="form-control" placeholder="ادخل هاتف الشركة">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <label>نوعية الشركة</label>
                                        <select name="category_id" class="form-control show-tick ms select2" data-placeholder="اختر اعضاء الشركة من بين المستخدمين">
                                            @if($categories)
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{$category->id == $company->category_id ? 'selected' : ''}}>
                                                        {{$category->category_ar}}
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
                                    @if($company->files)
                                        @foreach($company->files as $file)
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
                                            <form id="deleteFile{{$file->id}}" style="display: none" action="{{url('files/' . $file->id . '/' . $company->id . '/delete')}}" method="post">
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
