@extends('dashboard.layouts.layouts')
@section('title', 'الشكاوى و المقترحات')
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
                        <li class="breadcrumb-item active"> جميع الشكاوى و المقترحات </li>
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
                            <h2><strong>قائمة </strong> الشكاوى و المقترحات  </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th> البريد الإلكتروني </th>
                                        <th> رقم الهاتف </th>
                                        <th> تم الإرسال </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th> البريد الإلكتروني </th>
                                        <th> رقم الهاتف </th>
                                        <th> تم الإرسال </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($messages)
                                        @foreach($messages as $message)
                                            <tr>
                                                <td>{{$message->id}}</td>
                                                <td>{{$message->name}}</td>
                                                <td>{{$message->email}}</td>
                                                <td>{{$message->phone}}</td>
                                                <td>{{$message->created_at->diffForHumans()}}</td>
                                                <td>
                                                    <a href="{{adminUrl('message/'.$message->id)}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-eye"></i> </a>
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
    </div>


@endsection
