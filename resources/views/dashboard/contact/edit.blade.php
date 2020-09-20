@extends('dashboard.layouts.layouts')
@section('title', 'بيانات الإتصال')
@section('customizedStyle')
@endsection

@section('customizedScript')
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>بيانات الإتصال</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> تمرة </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">بيانات الإتصال </a></li>
                        <li class="breadcrumb-item active"> بيانات الإتصال </li>
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
            <form method="post" action="{{adminUrl('contact/update')}}"  enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2>عدل بيانات الإتصال  <strong></strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">البريد الإلكتروني</label>
                                        <div class="form-group">
                                            <input type="email" name="email" value="{{$contact->email}}" step="any" id="email_address" class="form-control" placeholder="ادخل البريد الإلكتروني">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address"> رقم الجوال  </label>
                                        <div class="form-group">
                                            <input type="text" name="phone" value="{{$contact->phone}}" id="email_address" class="form-control" placeholder="ادخل رقم الجوال ">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address"> واتساب  </label>
                                        <div class="form-group">
                                            <input type="text" name="whatsapp" value="{{$contact->whatsapp}}" id="email_address" class="form-control" placeholder="ادخل رقم الواتساب ">
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
