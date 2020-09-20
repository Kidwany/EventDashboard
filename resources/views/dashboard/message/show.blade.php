@extends('dashboard.layouts.layouts')
@section('title', 'تفاصيل الشكوى')
@section('customizedStyle')
@endsection

@section('customizedScript')
@endsection

@section('content')
    <div class="body_scroll">

        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>الشكاوى و المقترحات</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> تمرة </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">الشكاوى و المقترحات </a></li>
                        <li class="breadcrumb-item active"> تفاصيل الشكاوى و المقترحات  </li>
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
                <div class="col-md-12">
                    <div class="d-flex">
                        <div class="mobile-left">
                            <a class="btn btn-info btn-icon toggle-email-nav collapsed" data-toggle="collapse" href="#email-nav" role="button" aria-expanded="false" aria-controls="email-nav">
                                <span class="btn-label"><i class="zmdi zmdi-more"></i></span>
                            </a>
                        </div>
                        <div class="inbox right">
                            <div class="card">
                                <div class="body mb-2">
                                    <div class="d-flex justify-content-between flex-wrap-reverse">
                                        <h5 class="mt-0 mb-0 font-17">تفاصيل الشكوى</h5>
                                        <div>
                                            <small>{{$message->created_at->diffForHumans()}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="body mb-2">
                                    <ul class="list-unstyled d-flex justify-content-md-start mb-0">
                                        <li class="ml-3">
                                            <p class="mb-0"><span class="text-muted">البريد الإلكتروني:</span> <a href="javascript:void(0);">{{$message->email}}</a></p>
                                            <p class="mb-0"><span class="text-muted">هاتف:</span> {{$message->phone}}</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="body mb-2">
                                    {{$message->message}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
