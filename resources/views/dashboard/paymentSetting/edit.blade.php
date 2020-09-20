@extends('dashboard.layouts.layouts')
@section('title', 'اعدادات الدفع')
@section('customizedStyle')
@endsection

@section('customizedScript')
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>اعدادات الدفع</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> تمرة </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">اعدادات الدفع </a></li>
                        <li class="breadcrumb-item active"> عرض جديد </li>
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
            <form method="post" action="{{route('payment-setting.update', $setting->id)}}"  enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2>عدل اعدادات الدفع  <strong></strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">الضريبة</label>
                                        <div class="form-group">
                                            <input type="number" name="tax" value="{{$setting->tax }}" step="any" id="email_address" class="form-control" placeholder="ادخل النسبة المؤوية للضريبة: 10">
                                            <p class="help-inline">ادخل قيمة الضريبة المضافة على كل عملية شراء داخل التطبيق </p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address"> العمولة  </label>
                                        <div class="form-group">
                                            <input step="any" type="number" name="commission" value="{{$setting->commission}}" id="email_address" class="form-control" placeholder="ادخل قيمة العمولة ">
                                            <p class="help-inline">ادخل نسبة العمولة بالريال السعودي من كل عملية تتم من خلال التطبيق </p>
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
