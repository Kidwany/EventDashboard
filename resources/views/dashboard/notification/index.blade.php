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
                        <li class="breadcrumb-item active"> جميع الإشعارات </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>قائمة </strong> الإشعارات  </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                @include('dashboard.layouts.messages')
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>العنوان</th>
                                        <th> الوصف </th>
                                        <th> تم الإرسال بواسطة </th>
                                        <th> تم الإرسال </th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>العنوان</th>
                                        <th> الوصف </th>
                                        <th> تم الإرسال بواسطة </th>
                                        <th> تم الإرسال </th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($notifications)
                                        @foreach($notifications as $notification)
                                            <tr>
                                                <td>{{$notification->id}}</td>
                                                <td>{{$notification->title}}</td>
                                                <td>{{$notification->data}}</td>
                                                <td>{{$notification->sentFrom->name}}</td>
                                                <td>{{$notification->created_at->diffForHumans()}}</td>
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
    </div>


    <div class="modal fade" id="delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-red">
                <div class="modal-header">
                    <h4 class="title" id="defaultModalLabel">حذف المنتج</h4>
                </div>
                <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد حذف المنتج <strong>  تمر العنبرة </strong></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect text-light">حذف</button>
                    <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>

@endsection
