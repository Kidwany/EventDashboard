@extends('dashboard.layouts.layouts')
@section('title', 'المستخدمين')
@section('customizedStyle')
@endsection

@section('customizedScript')
@endsection

@section('content')
<link
			href="https://fonts.googleapis.com/css2?family=Cairo&display=swap"
			rel="stylesheet"
		/>
	<style>
		.id-wrapper * {
				box-sizing: border-box;
				direction: rtl;
			}
		 
			.id-wrapper {
			
				background-color: #f7f8fa;
				border: 1px solid rgba(0, 0, 0, 0.1);
				border-radius: 4px;
				width: 360px;
				height: 408px;
				position: relative;
				font-family: 'Cairo', sans-serif;
				display: grid;
				grid-template-rows: auto 1fr;
			}
			.card-title {
				background-color: #fbe462;
				color: #323232;
				text-align: center;
				padding: 10px 8px;
				font-size: 20px;
			}
			.main-content {
				display: grid;
				/* padding: 12px; */
			}

			.profile-content {
				display: grid;
				grid-template-columns: auto 1fr;
				grid-gap: 8px;
				margin-top: 8px;
				padding: 12px;
			}

			.profile-img img {
				width: 160px;
				height: 180px;
				border-radius: 4px;
				object-fit: cover;
				object-position:  center;
				background-color: #ddd;
			}
			.profile-data {
				display: grid;
				grid-gap: 18px;
				padding: 8px 0;
				margin-right: 4px;
				text-align: right;
			}

			.tit {
				font-size: 12px;
				color: #464646;
			}
			.name,
			.job,
			.card-no {
				display: grid;
				line-height: 1;
				grid-gap: 4px;
				font-weight: bold;
				color: #323232;
			}

			.span-no {
				font-size: 20px;
			}

			.logo-qr {
				display: grid;
				grid-template-columns: 1fr 1fr;
				align-items: center;
				justify-content: center;
				border-radius: 0 0 4px 4px;
				padding: 12px;
				padding-top: 8px;
			}

			.logo-div img {
				width: 100%;
				height: auto;
				border-right: 3px solid rgba(0, 0, 0, 0.2);
				padding-right: 22px;
			}
			.qr-wrapper {
				flex-basis: 50%;
				display: flex;
				flex-direction: column;
				align-items: center;
				justify-content: space-evenly;
			}
			.qr-wrapper img {
				width: 102px;
			}
		</style>
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
                    <a target="_blank" href="{{adminUrl('user/' . $user->id . '/edit')}}" class="btn btn-primary btn-icon float-right"><i class="zmdi zmdi-edit"></i> Print</a>
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
                            <h4 class="m-t-10">{{$user->fname . ' ' . $user->mname . ' ' . $user->lname}}</h4>
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
                            <p>{{$user->created_at->format('d M Y')}}  {{$user->created_at->format('h:i:s')}}</p>
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
                    <div class="row clearfix">
                        @if($sp_doc->second_identity_image_id)
                            <div class="col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="body">
                                        <a target="_blank" href="{{$sp_doc->identityImage->url}}">
                                            <img class="img-responsive" src="{{$sp_doc->identityImage->url}}" alt="About the image" style="height: 300px; object-fit: cover">
                                        </a>
                                        <div class="mt-4 pw_header">
                                            <h6>صورة تحقيق الهوية</h6>
                                            <small class="text-muted">تاريخ الإنتهاء  |  {{$sp_doc->passport_expire_date}}</small>
                                        </div>
                                        <div class="pw_meta">
                                            <span>{{$sp_doc->passport_no}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="card">
                                    <div class="body">
                                        <a target="_blank" href="{{$sp_doc->back_image->url}}">
                                            <img class="img-responsive" src="{{$sp_doc->back_image->url}}" alt="About the image" style="height: 300px; object-fit: cover">
                                        </a>

                                        <div class="mt-4 pw_header">
                                            <h6>صورة الخلفية</h6>
                                            <small class="text-muted">تاريخ الإنتهاء  |  {{$sp_doc->passport_expire_date}}</small>
                                        </div>
                                        <div class="pw_meta">
                                            <span>{{$sp_doc->passport_no}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <div class="body">
                                        <a target="_blank" href="{{$sp_doc->identityImage->url}}">
                                            <img class="img-responsive" src="{{$sp_doc->identityImage->url}}" alt="About the image" style="height: 300px; object-fit: cover">
                                        </a>

                                        <div class="mt-4 pw_header">
                                            <h6>صورة تحقيق الهوية</h6>
                                            <small class="text-muted">تاريخ الإنتهاء  |  {{$sp_doc->passport_expire_date}}</small>
                                        </div>
                                        <div class="pw_meta">
                                            <span>{{$sp_doc->passport_no}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    {{--<div class="card">
                        <div class="header">
                            <h2><strong>الفعاليات </strong> السابقة</h2>
                        </div>
                        <div class="body">

                            <div class="table-responsive">
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>الافعالية</th>
                                        <th> الشركة </th>
                                        <th> التاريخ </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>الافعالية</th>
                                        <th> الشركة </th>
                                        <th> التاريخ </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{$event->id}}</td>
                                            <td>{{$event->title}}</td>
                                            <td>{{$event->organization->name}}</td>
                                            <td>{{$event->event_date}}</td>
                                            <td>
                                                <a href="{{adminUrl('event/' . $event->id)}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-eye"></i> </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>--}}
                    <div class="card">
                        <div class="header">
                            <h2><strong>بيانات</strong> البنك</h2>
                        </div>
                        <div class="body mb-2">
                            <div class="row">
                                <div class="col-lg-6">
                                    <p class="text-muted">البنك : </p>
                                    <h3>{{$user_payment->bank}}</h3>
                                </div>
                                <div class="col-lg-6">
                                    <p class="text-muted">رقم الأيبان : </p>
                                    <h3>{{$user_payment->ipan_no}}</h3>
                                </div>
                            </div>


                            <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                            </div>
                        </div>

                    </div>
                    <div class="card">
                        <div class="header">
                            <h2><strong>الأعمال</strong> السابقة</h2>
                        </div>
                        @if($sp_experience)
                            @foreach($sp_experience as $experience)
                                <div class="body mb-2">
                                    <div class="blogitem">
                                        <div class="blogitem-content">
                                            <div class="blogitem-header">
                                                <div class="blogitem-meta">
                                                    <span><i class="zmdi zmdi-calendar"></i>من <a href="javascript:void(0);">{{$experience->start_date ? $experience->start_date->format('D M Y') : ''}}</a></span>
                                                    <span><i class="zmdi zmdi-calendar"></i>الى<a href="javascript:void(0);">{{$experience->end_date ? $experience->end_date->format('D M Y') : ''}}</a></span>
                                                </div>
                                            </div>
                                            <h5><a href="javascript:void(0);">{{$experience->job_title}}</a></h5>
                                            <p>
                                                {{$experience->job_description}}
                                            </p>
                                            <a href="javascript:void(0);" class="btn btn-info">{{$experience->company}}</a>
                                        </div>
                                    </div>

                                    <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                                        @if($experience->images->count())
                                            @foreach($experience->images as $image)
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 m-b-30"> <a href="{{$image->url}}"> <img class="img-fluid img-thumbnail" src="{{assetPath($image->path)}}" alt=""> </a> </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                     <a target="_blank" href="{{adminUrl('printid/' . $user->id)}}" class="btn btn-success btn-icon float-right"><i class="zmdi zmdi-print"></i> Print</a>
                    <div class="card">
                        <div class="header">
                            <h2><strong>البطاقه التعريفيه</strong> </h2>
                        </div>
                    </div>
                    
          
		<div class="id-wrapper">
			<div class="card-title">بطاقه تعريفيه</div>

			<div class="main-content">
				<div class="profile-content">
					<div class="profile-img">
						<img src="{{$user->image_id ? $user->image->url : assetPath('dashboard/assets/images/user.png')}}" alt="profile" />
					</div>
					<div class="profile-data">
						<div class="name">
							<span class="tit">الاســـم: </span>
							<span>{{$user->fname . ' ' . $user->mname . ' ' . $user->lname}}</span>
						</div>
						<div class="job">
							<span class="tit">الوظيفة: </span>
							<span>@if($user->serviceProviderJobs->count())
                                            @foreach($user->serviceProviderJobs as $job)
                                                {{$job->job_ar}}
                                            @endforeach
                                        @endif</span>
						</div>
						<div class="card-no">
							<span class="tit">الرقم : </span>
							<span class="span-no">{{$user->id}}</span>
						</div>
					</div>
				</div>
				<div class="logo-qr">
					<div class="qr-wrapper">
						<img src="{{$user->spqr}}" alt="qr code" />
					</div>
					<div class="logo-div">
						<img src="https://www.admin.hemmtk.com/general/hemmtk.jpeg" alt="logo" alt="logo" />
					</div>
				</div>
			</div>
		</div>
                         
                </div>
            </div>
        </div>
    </div>

@endsection
