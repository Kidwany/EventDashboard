@extends('dashboard.layouts.layouts')
@section('title', 'المستخدمين')
@section('customizedStyle')
@endsection

@section('customizedScript')
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
                <div class="col-lg-4 col-md-12">
                    <div class="card mcard_3">
                        <div class="body">
                            <a target="_blank" href="{{$user->image->url}}">
                                <img src="{{$user->image_id ? $user->image->url : assetPath('dashboard/assets/images/user.png')}}"
                                     class="rounded-circle shadow " alt="profile-image"
                                     style="width: 250px; height: 250px; object-fit: cover; object-position: center center"
                                >
                            </a>
                            <h4 class="m-t-10">{{$user->name}}</h4>
                            <div class="row">
                                <div class="col-12">
                                    {{--<form action="{{route('user.update', 5)}}" method="post">
                                        @csrf
                                        @method('patch')
                                        <button type="submit" class="btn btn-danger">تعطيل الحساب</button>
                                    </form>--}}
                                </div>
                                <div class="col-12">
                                    <p class="text-muted">
                                        @if($user->serviceProviderJobs->count())
                                            @foreach($user->serviceProviderJobs as $job)
                                                {{$job->job_ar}}
                                            @endforeach
                                        @endif
                                    </p>
                                </div>
                                <div class="col-6">
                                    <small>عدد الفعاليات</small>
                                    <h5>{{$total_user_events}}</h5>
                                </div>
                                <div class="col-6">
                                    <small> عدد الطلبات </small>
                                    <h5>{{$requests}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="body">
                            <small class="text-muted">البريد الإلكتروني: </small>
                            <p>{{$user->email}}</p>
                            <hr>
                            <small class="text-muted">الجوال: </small>
                            <p>{{$user->phone}}</p>
                            <hr>
                        </div>
                    </div>
                    <div class="card">
                        <div class="body">
                            <small class="text-muted">الوظيفة : </small>
                            <p>
                                @foreach($user->serviceProviderJobs as $job)
                                    {{$job->job_ar}}
                                @endforeach
                            </p>
                            <hr>
                            <small class="text-muted">اللغة: </small>
                            <p>{{$user->lang ? ($user->lang == 'ar' ? 'العربية' : 'الإنجليزية') : 'العربية'}}</p>
                            <hr>
                            <small class="text-muted">تم التسجيل في: </small>
                            <p>{{$user->created_at->format('Y-m-d')}}  {{$user->created_at->format('h:i')}} </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="body">
                            <small class="text-muted">الدولة : </small>
                            <p>{{$user->country_id ? $user->country->country_ar->title : ''}}</p>
                            <hr>
                            <small class="text-muted">المدينة: </small>
                            <p>{{$user->city_id ? $user->city->city_ar->title : ''}}</p>
                            <hr>
                            <small class="text-muted">الجنسية: </small>
                            <p>{{$user->nationality_id ? $user->nationality->nationality_ar : ''}}</p>
                            <hr>
                            <small class="text-muted">العنوان: </small>
                            <p>{{$user->address}}</p>

                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>تعديل</strong> البيانات</h2>
                        </div>
                        <div class="body">
                            <form action="{{route('user.update', $user->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="body">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address"> الإسم </label>
                                                        <div class="form-group">
                                                            <input type="text" name="name" value="{{$user->name}}" id="email_address" class="form-control" placeholder="ادخل اسم المدير" required>
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
                                                        <label for="email_address">اسم البنك</label>
                                                        <div class="form-group">
                                                            <input type="tel" name="bank" value="{{$user_payment->bank}}" step="any" id="email_address" class="form-control" placeholder="ادخل رقم الجوال ">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <label for="email_address">رقم الايبان</label>
                                                        <div class="form-group">
                                                            <input type="tel" name="ipan_no" value="{{$user_payment->ipan_no}}" step="any" id="email_address" class="form-control" placeholder="ادخل رقم الجوال ">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">

                                                            <label> الوظيفه</label>
                                                            <select name="job_id" class="form-control show-tick ms select2"  data-placeholder="اختر الوظيفه">
                                                                @if($allJobs)
                                                                    @foreach($allJobs as $job)
                                                                        <option value="{{$job->id}}" {{$sp_job->job_title_id == $job->id ? 'selected' : ''}}>
                                                                            {{$job->job_ar}}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-3">
                                                        <label for="email_address">الصورة الشخصية</label>
                                                        <div class="form-group">
                                                            <input type="file" name="profile_image" id="email_address" class="form-control" placeholder="">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12 col-md-12 col-sm-3">
                                                        <label for="email_address">صورة تحقيق الهوية</label>
                                                        <div class="form-group">
                                                            <input type="file" name="id_image" id="email_address" class="form-control" placeholder="">
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
                </div>
            </div>
        </div>
    </div>

@endsection
