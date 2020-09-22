@extends('dashboard.layouts.layouts')
@section('title', 'الطوابق')
@section('customizedStyle')
@endsection

@section('customizedScript')



@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>الطوابق</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('gates/' . $event->id)}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">الطوابق </a></li>
                        <li class="breadcrumb-item active"> جميع الطوابق </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        @include('dashboard.layouts.eventNav')

        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <form action="{{url('floors/store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="hidden" name="event_id" value="{{$event->id}}">
                        <div class="card">
                            @include('dashboard.layouts.messages')
                            <div class="header">
                                <h2><strong>اضف الطوابق </strong></h2>
                            </div>
                            <section id="gates">
                                <div class="body">
                                    <div class="row" >
                                        <div class="col-lg-12 col-md-12 col-sm-3">
                                            <label for="email_address">رقم الطابق</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input type="text" value="{{old('no')}}" name="no" id="email_address" class="form-control" placeholder="ادخل رقم الطابق">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">حفظ</button>
                                </div>
                            </section>
                        </div>
                    </form>
                    <div class="card">

                        <div class="header d-flex justify-content-between">
                            <h2><strong>قائمة </strong> الطوابق </h2>
                            {{--<a href="{{url('groups/' . $event->id . '/create')}}" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i> مجموعة جديدة </a>--}}
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>الكود</th>
                                        <th>الرقم</th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>الكود</th>
                                        <th>الإسم</th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($floors)
                                        @foreach($floors as $floor)
                                            <tr>
                                                <td>{{$floor->id}}</td>
                                                <td><a href="{{$floor->barcode}}" target="_blank"><img src="{{$floor->barcode}}"></a></td>
                                                <td>{{$floor->floor_no}}</td>
                                                <td>{{$floor->created_at ? $floor->created_at->diffForHumans() : ''}}</td>
                                                <td style="display: flex">
                                                    <a href="{{adminUrl('floors/' . $floor->id . '/edit')}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i> </a>
                                                    <a href="#" class="btn bg-red waves-effect btn-sm" data-toggle="modal" data-target="#delete{{$floor->id}}" data-color="red"><i class="zmdi zmdi-delete"></i> </a>
                                                    <a target="_blank" href="{{adminUrl('floors/'. $floor->id . '/print')}}" class="btn btn-success"><i class="zmdi zmdi-print"></i> </a>
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

    @if($floors)
        @foreach($floors as $floor)
            <div class="modal fade" id="delete{{$floor->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">مسح الدور</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد مسح الدور <strong> {{$floor->floor_no}} </strong></div>
                        <form id="deleteUser{{$floor->id}}" style="display: none" action="{{url('floors/' . $floor->id . '/delete')}}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="deleteUser{{$floor->id}}">حذف</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
