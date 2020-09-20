@extends('dashboard.layouts.layouts')

@section('title', 'لوحة التحكم')

@section('customizedStyle')
@endsection

@section('customizedScript')
@endsection

@section('content')




    <div class="block-header">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-sm-12">
                <h2>لوحة التحكم</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                    <li class="breadcrumb-item active"> لوحة التحكم </li>
                </ul>
                <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-12">
                <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-left"></i></button>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        {{--Statistics--}}
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon sales">
                    <div class="body">
                        <h6>الفعاليات</h6>
                        <h2>{{$events}}<small class="info"> فعالية </small></h2>
                        <small>عدد الفعاليات </small>
                        {{--<div class="progress">
                            <div class="progress-bar l-blue" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100" style="width: 6%;"></div>
                        </div>--}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon traffic">
                    <div class="body">
                        <h6>المجموعات</h6>
                        <h2>{{$groups}} <small class="info">مجموعة</small></h2>
                        <small>عدد المجموعات   </small>
                        {{--<div class="progress">
                            <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                        </div>--}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon email">
                    <div class="body">
                        <h6>المهام</h6>
                        <h2>{{$tasks}} <small class="info">مهمة</small></h2>
                        <small>اجمالي عدد المهام</small>
                        {{--<div class="progress">
                            <div class="progress-bar l-purple" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 39%;"></div>
                        </div>--}}
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12">
                <div class="card widget_2 big_icon domains">
                    <div class="body">
                        <h6>المشرفين</h6>
                        <h2> {{$supervisors}} <small class="info"> مشرف </small></h2>
                        <small>اجمالي عدد المشرفين</small>
                        {{--<div class="progress">
                            <div class="progress-bar l-green" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 89%;"></div>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <!-- Basic Examples -->
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>أحدث </strong> الفعاليات  </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                <tr>
                                    <th>م</th>
                                    <th>الصورة</th>
                                    <th>المدينة</th>
                                    <th>النوع</th>
                                    <th>التاريخ</th>
                                    <th> تمت الإضافة </th>
                                    <th>تعديل</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>م</th>
                                    <th>الصورة</th>
                                    <th>المدينة</th>
                                    <th>النوع</th>
                                    <th>التاريخ</th>
                                    <th> تمت الإضافة </th>
                                    <th>تعديل</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @if($latest_events)
                                    @foreach($latest_events as $event)
                                        <tr>
                                            <td>{{$event->id}}</td>
                                            <td><img src="{{$event->image->url}}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover"></td>
                                            <td>{{$event->title}}</td>
                                            <td>{{$event->category->category_ar->title}}</td>
                                            <td>{{$event->event_date}} </td>
                                            <td>{{$event->created_at->diffForHumans()}}</td>
                                            <td>
                                                <a href="{{adminUrl('event/'. $event->id .'/edit')}}" class="btn btn-primary"><i class="zmdi zmdi-edit"></i> </a>
                                                <a href="{{adminUrl('event/'. $event->id)}}" class="btn btn-success"><i class="zmdi zmdi-eye"></i> </a>
                                                {{--<a href="#" class="btn bg-red waves-effect" data-toggle="modal" data-target="#delete{{$event->id}}" data-color="red"><i class="zmdi zmdi-delete"></i> </a>--}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
