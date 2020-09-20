@extends('dashboard.layouts.layouts')
@section('title', 'الإشعارات')
@section('customizedStyle')
@endsection

@section('customizedScript')
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>الإشعارات</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> تمرات </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">الإشعارات </a></li>
                        <li class="breadcrumb-item active"> إشعار جديد </li>
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
            <form action="{{route('notification.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>اضف بيانات الإشعار  </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">عنوان الإشعار</label>
                                        <div class="form-group">
                                            <input type="text" name="title" value="{{old('title')}}" id="email_address" class="form-control" placeholder="ادخل عنوان الإشعار">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">تفاصيل الإشعار</label>
                                        <div class="form-group">
                                            <input type="text" name="desc" value="{{old('desc')}}" step="any" id="email_address" class="form-control" placeholder="ادخل وصف الإشعار">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="radio m-r-20">
                                            <input type="radio" name="receivers" id="logged" class="with-gap" value="1">
                                            <label for="logged"> إرسال الإشعار للمستخدمين الذين سجلوا الدخول من قبل</label>
                                        </div>
                                        <div class="radio m-r-20">
                                            <input type="radio" name="receivers" id="guest" class="with-gap" value="2">
                                            <label for="guest">إرسال الإشعار للمستخدمين الذين لم يسجلوا الدخول من قبل</label>
                                        </div>
                                        <div class="radio m-r-20">
                                            <input type="radio" name="receivers" id="all" class="with-gap" value="3">
                                            <label for="all">إرسال الإشعار لجميع المستخدمين</label>
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
