@extends('dashboard.layouts.layouts')
@section('title', 'استكمل عملية التسجيل')
@section('customizedStyle')
@endsection

@section('customizedScript')
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>استكمل عملية التسجيل </h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">استكمل عملية التسجيل </a></li>
                        <li class="breadcrumb-item active"> التسجيل </li>
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
            <form action="{{route('complete_register')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>بيانات الشركة </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم الشركة</label>
                                        <div class="form-group">
                                            <input required type="text" name="name" value="{{old('name')}}" id="email_address" class="form-control" placeholder="ادخل اسم الشركة">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">شعار الشركة</label>
                                        <div class="form-group">
                                            <input required type="file" name="logo" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <label> المدينة</label>
                                        <select name="city_id" class="form-control show-tick ms select2"  data-placeholder="اختر المدينة">
                                            @if($cities)
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}" {{old('city_id') == $city->id ? 'selected' : ''}}>
                                                        {{$city->city_ar->title}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">عنوان الشركة</label>
                                        <div class="form-group">
                                            <input required type="text" name="company_address" value="{{old('company_address')}}" id="email_address" class="form-control" placeholder="ادخل عنوان الشركة">
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">حفظ</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="header">
                                <h2><strong>البيانات المالية </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم البنك</label>
                                        <div class="form-group">
                                            <input required type="text" name="bank_name" value="{{old('bank_name')}}" id="email_address" class="form-control" placeholder="ادخل اسم البنك">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">رقم ال IBAN</label>
                                        <div class="form-group">
                                            <input required type="text" name="ipan_no" value="{{old('ipan_no')}}" id="email_address" class="form-control" placeholder="ادخل رقم الأيبان">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="header">
                                <h2><strong>مستندات الشركة </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">السجل التجاري</label>
                                        <div class="form-group">
                                            <input required type="file" accept=".png,.jpeg,.jpg,.pdf,.doc,.docx" name="commercial_register" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">عضوية الغرفة التجارية</label>
                                        <div class="form-group">
                                            <input required type="file" accept=".png,.jpeg,.jpg,.pdf,.doc,.docx" name="chamber_of_commerce_membership" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">التأمينات الإجتماعية</label>
                                        <div class="form-group">
                                            <input required type="file" accept=".png,.jpeg,.jpg,.pdf,.doc,.docx" name="social_insurance" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">شهادة الزكاة</label>
                                        <div class="form-group">
                                            <input required type="file" accept=".png,.jpeg,.jpg,.pdf,.doc,.docx" name="zakkah_certificate" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">شهادة السعودة</label>
                                        <div class="form-group">
                                            <input required type="file" accept=".png,.jpeg,.jpg,.pdf,.doc,.docx" name="saawada_certificate" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
