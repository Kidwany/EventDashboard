@extends('dashboard.layouts.layouts')
@section('title', 'المعدات')
@section('customizedStyle')
@endsection

@section('customizedScript')



@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>المعدات</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('gates/' . $event->id)}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">المعدات </a></li>
                        <li class="breadcrumb-item active"> جميع المعدات </li>
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
                    <form action="{{url('tools/store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="hidden" name="event_id" value="{{$event->id}}">
                        <div class="card">
                            @include('dashboard.layouts.messages')
                            <div class="header">
                                <h2><strong>اضف المعدات </strong></h2>
                            </div>
                            <section id="gates">
                                <div class="body">
                                    <div class="row" >
                                        <div class="col-lg-12 col-md-12 col-sm-3">
                                            <label for="email_address">رقم المعدة</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input type="text" value="{{old('name')}}" name="name" id="email_address" class="form-control" placeholder="ادخل اسم المعدة">
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
                            <h2><strong>قائمة </strong> المعدات </h2>
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
                                        <th>لإسم</th>
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
                                    @if($tools)
                                        @foreach($tools as $tool)
                                            <tr>
                                                <td>{{$tool->id}}</td>
                                                <td><a target="_blank" href="{{$tool->barcode}}"><img src="{{$tool->barcode}}"></a></td>
                                                <td>{{$tool->name}}</td>
                                                <td>{{$tool->created_at ? $tool->created_at->diffForHumans() : ''}}</td>
                                                <td style="display: flex">
                                                    <a href="{{adminUrl('tools/' . $tool->id . '/edit')}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i> </a>
                                                    <a href="#" class="btn bg-red waves-effect btn-sm" data-toggle="modal" data-target="#delete{{$tool->id}}" data-color="red"><i class="zmdi zmdi-delete"></i> </a>
                                                    <a target="_blank" href="{{adminUrl('tools/'. $tool->id . '/print')}}" class="btn btn-success"><i class="zmdi zmdi-print"></i> </a>
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

    @if($tools)
        @foreach($tools as $tool)
            <div class="modal fade" id="delete{{$tool->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">مسح المعدة</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد مسح المعدة <strong> {{$tool->name}} </strong></div>
                        <form id="deleteUser{{$tool->id}}" style="display: none" action="{{url('tools/' . $tool->id . '/delete')}}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="deleteUser{{$tool->id}}">حذف</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
