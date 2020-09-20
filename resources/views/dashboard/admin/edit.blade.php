@extends('dashboard.layouts.layouts')
@section('title', 'المستخدمين')
@section('customizedStyle')
@endsection

@section('customizedScript')
    <script>
        $('.select2').select2()
    </script>
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>المستخدمين</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">المستخدمين </a></li>
                        <li class="breadcrumb-item active"> بيانات المستخدمين </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-left"></i></button>
                    <a target="_blank" href="{{adminUrl('print-user/' . $user->id)}}" class="btn btn-success btn-icon float-right"><i class="zmdi zmdi-print"></i> Print</a>
                </div>
            </div>
        </div>


        <div class="container-fluid elm" id="print">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>ادخل</strong> البيانات</h2>
                        </div>
                        <div class="body">
                            @include('dashboard.layouts.messages')
                            <form action="{{route('admin.update', $user->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address"> الإسم الأول</label>
                                                        <div class="form-group">
                                                            <input type="text" name="fname" value="{{$user->fname}}" id="email_address" class="form-control" placeholder="ادخل اسم المستخدم" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address"> اسم الأب</label>
                                                        <div class="form-group">
                                                            <input type="text" name="mname" value="{{$user->mname}}" id="email_address" class="form-control" placeholder="ادخل اسم المستخدم" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address"> الإسم الأخير</label>
                                                        <div class="form-group">
                                                            <input type="text" name="lname" value="{{$user->lname}}" id="email_address" class="form-control" placeholder="ادخل اسم المستخدم" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address">الجوال</label>
                                                        <div class="form-group">
                                                            <input type="tel" name="phone" value="{{$user->phone}}" step="any" id="email_address" class="form-control" placeholder="ادخل رقم الجوال ">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address">رقم تحقيق الهوية</label>
                                                        <div class="form-group">
                                                            <input type="tel" name="passport_no" value="{{$sp_doc->passport_no}}" step="any" id="email_address" class="form-control" placeholder="ادخل رقم الجوال ">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address">العنوان</label>
                                                        <div class="form-group">
                                                            <input type="text" name="address" value="{{$user->address}}" step="any" id="email_address" class="form-control" placeholder="ادخل العنوان ">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-3">
                                                        <label for="email_address">الصورة الشخصية</label>
                                                        <div class="form-group">
                                                            <input type="file" name="profile_image" id="email_address" class="form-control" placeholder="">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-3">
                                                        <label for="email_address">صورة تحقيق الهوية</label>
                                                        <div class="form-group">
                                                            <input type="file" name="id_image" id="email_address" class="form-control" placeholder="">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address"> كلمة السر </label>
                                                        <div class="form-group">
                                                            <input type="password" name="password" value="{{old('password')}}" id="email_address" class="form-control" placeholder="ادخل كلمة السر المكونة من 8 ارقام و حروف">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address">تأكيد كلمة السر </label>
                                                        <div class="form-group">
                                                            <input type="password" name="password_confirmation" value="{{old('password-confirmation')}}" id="email_address" class="form-control" placeholder="اعد ادخال كلمة السر">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6">
                                                        <label>اضافة صلاحيات</label>
                                                        <select name="privileges[]" class="form-control show-tick ms select2"  multiple data-placeholder="اختر صلاحيات المشرف داخل النظام">
                                                            @if($privileges)
                                                                @foreach($privileges as $privilege)
                                                                    <option value="{{$privilege->id}}"
                                                                            @foreach($user->privileges as $user_privilege)
                                                                                {{$user_privilege->id == $privilege->id ? 'selected' : ''}}
                                                                            @endforeach
                                                                    >{{$privilege->privilege}}</option>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
