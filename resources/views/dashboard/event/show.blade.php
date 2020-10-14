@extends('dashboard.layouts.layouts')
@section('title', $event->title)
@section('customizedStyle')
@endsection

@section('customizedScript')
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>الفعاليات</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">الفعاليات </a></li>
                        <li class="breadcrumb-item active"> بيانات الفعاليات </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="d-flex">
                    <div class="mobile-left">
                        <a class="btn btn-info btn-icon toggle-email-nav collapsed" data-toggle="collapse" href="#email-nav" role="button" aria-expanded="false" aria-controls="email-nav">
                            <span class="btn-label"><i class="zmdi zmdi-more"></i></span>
                        </a>
                    </div>
                    <div class="inbox left" id="email-nav">
                        <div class="mail-side">
                            <ul class="nav">

                                <li class="active"><a href="{{adminUrl('applicants/' . $event->id)}}"><i class="zmdi zmdi-inbox"></i>الطلبات<span class="badge badge-primary">{{$applications}}</span></a></li>
                                <li><a href="{{adminUrl('zones/' . $event->id)}}"><i class="zmdi zmdi-map"></i>المناطق</a></li>
                                <li><a href="{{adminUrl('groups/' . $event->id)}}"><i class="zmdi zmdi-group-work"></i>المجموعات</a></li>
                                <li><a href="{{adminUrl('floors/' . $event->id)}}"><i class="zmdi zmdi-badge-check"></i>الادوار </a></li>
                                <li><a href="{{adminUrl('gates/' . $event->id)}}"><i class="zmdi zmdi-arrow-left"></i>البوابات </a></li>
                                <li><a href="{{adminUrl('organizers/' . $event->id)}}"><i class="zmdi zmdi-accounts"></i>المنظمين<span class="badge badge-info">{{$organizers}}</span></a></li>
                                {{--<li><a href="javascript:void(0);"><i class="zmdi zmdi-email"></i>الصلاحيات</a></li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-alert-circle"></i>المشرفين</a></li>--}}
                                <li><a href="{{adminUrl('tasks/' . $event->id)}}"><i class="zmdi zmdi-fire"></i>المهام<span class="badge badge-danger">{{$tasks}}</span></a></li>
                                <li><a href="{{adminUrl('tracking/' . $event->id)}}"><i class="zmdi zmdi-fire"></i>التتبع</a></li>
                                <li><a href="{{adminUrl('tools/' . $event->id)}}"><i class="zmdi zmdi-speaker"></i>المعدات</a></li>
                                <li><a href="{{adminUrl('finance/' . $event->id)}}"><i class="zmdi zmdi-money"></i>البيانات المالية</a></li>
                                <li><a href="{{adminUrl('company/' . $event->id)}}"><i class="zmdi zmdi-home"></i>الشركات</a></li>
                                <li><a href="{{adminUrl('guardian-ship/' . $event->id)}}"><i class="zmdi zmdi-plus-box"></i>العهدة</a></li>
                                <li><a href="{{adminUrl('break/' . $event->id)}}"><i class="zmdi zmdi-local-cafe"></i>الإستراحة</a></li>
                            </ul>
                        </div>

                        <div class="card">
                            <div class="header">
                                <h2><strong>الموقع</strong></h2>
                            </div>
                            <div class="body">
                                <small class="text-muted">الدولة: </small>
                                <p>{{$event->country->country_ar->title}}</p>
                                <hr>
                                <small class="text-muted">المدينة: </small>
                                <p>{{$event->city->city_ar->title}}</p>
                                <hr>
                                <small class="text-muted">العنوان: </small>
                                <p>{{$event->place}}</p>
                                <hr>
                                <small class="text-muted">الموقع على الخريطة: </small>
                                <p><a target="_blank" href="{{$event->location->url}}"><i class="zmdi zmdi-map"></i> اذهب للموقع</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="inbox right card">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-6 col-6">
                                <div class="card info-box-2 hover-zoom-effect social-widget facebook-widget">
                                    <div class="icon"><i class="zmdi zmdi-accounts"></i></div>
                                    <div class="content">
                                        <div class="text">الطلبات</div>
                                        <div class="number">{{$applications}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-6">
                                <div class="card info-box-2 hover-zoom-effect social-widget google-widget">
                                    <div class="icon"><i class="zmdi zmdi-group"></i></div>
                                    <div class="content">
                                        <div class="text">المجموعات</div>
                                        <div class="number">{{$groups}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-6">
                                <div class="card info-box-2 hover-zoom-effect social-widget twitter-widget">
                                    <div class="icon"><i class="zmdi zmdi-view-list-alt"></i></div>
                                    <div class="content">
                                        <div class="text">المهام</div>
                                        <div class="number">{{$tasks}}</div>
                                    </div>
                                </div>
                            </div>

                        <div class="card">
                            <div class="blogitem">
                                <div class="blogitem-image">
                                    <a href="javascript:void(0);"><img src="{{$event->image->url}}" alt="blog image"></a>
                                    <span class="blogitem-date">{{date('l, M d Y', strtotime($event->event_date))}}</span>
                                </div>
                                <div class="blogitem-content">
                                    <div class="blogitem-header">
                                        <div class="blogitem-meta">
                                            <span><i class="zmdi zmdi-account"></i>بواسطة <a href="javascript:void(0);">{{\Illuminate\Support\Facades\Auth::user()->name}}</a></span>
                                            <span><i class="zmdi zmdi-comments"></i><a href="#">{{$event->status->title_ar}}</a></span>
                                        </div>
                                        {{--<div class="blogitem-share">
                                            <ul class="list-unstyled mb-0">
                                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-facebook-box"></i></a></li>
                                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-instagram"></i></a></li>
                                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-twitter-box"></i></a></li>
                                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-linkedin-box"></i></a></li>
                                            </ul>
                                        </div>--}}
                                    </div>
                                    <h5><a href="#">{{$event->title}}</a></h5>
                                    <p>
                                        {{$event->description}}
                                    </p>
                                    <a href="#" class="btn btn-info">{{$event->category->category_ar->title}}</a>
                                </div>
                            </div>
                        </div>
                        {{--<div class="card">
                            <div class="header">
                                <h2><strong>صور</strong> المغسلة</h2>
                            </div>
                            <div class="body">
                                <div id="aniimated-thumbnials" class="list-unstyled row clearfix">
                                    @foreach($service_provider->images as $image)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 m-b-30"> <a href="{{assetPath($image->image_path)}}"> <img class="img-fluid img-thumbnail" src="{{assetPath($image->image_path)}}" alt=""> </a> </div>
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 m-b-30"> <a href="{{assetPath($image->image_path)}}"> <img class="img-fluid img-thumbnail" src="{{assetPath($image->image_path)}}" alt=""> </a> </div>
                                    @endforeach
                                </div>
                                </ul>
                            </div>
                        </div>--}}
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
