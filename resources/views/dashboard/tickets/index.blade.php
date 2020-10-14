@extends('dashboard.layouts.layouts')
@section('title', 'التذاكر')
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
                    <h2>التذاكر</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('finance/' . $event->id)}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">التذاكر </a></li>
                        <li class="breadcrumb-item active"> جميع التذاكر </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        @include('dashboard.layouts.eventNav')
        @include('dashboard.layouts.financeNav')

        <div class="container-fluid">
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <form action="{{url('tickets/store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="hidden" name="event_id" value="{{$event->id}}">
                        <div class="card">
                            @include('dashboard.layouts.messages')
                            <div class="header">
                                <h2><strong>اضف التذاكر و أنواعها</strong></h2>
                            </div>
                            <section id="gates">
                                <div class="body">
                                    <div class="row" >

                                        <div class="col-lg-4 col-md-12 col-sm-3">
                                            <label for="email_address">فئة التذكرة</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input required type="text" value="{{old('category')}}" name="category" id="email_address" class="form-control" placeholder="ادخل فئة التذكرة">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-3">
                                            <label for="email_address">السعر (ر.س)</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input step="any" type="number" value="{{old('price')}}" name="price" id="email_address" class="form-control" placeholder="ادخل سعر التذكرة">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-12 col-sm-3">
                                            <label for="email_address">العدد المتوقع للطرح</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input type="number" value="{{old('expected')}}" name="expected" id="email_address" class="form-control" placeholder="ادخل العدد المتوقع للطرح">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-12 col-sm-3">
                                            <label for="email_address">العدد الذي تم طرحه بالفعل</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input type="number" value="{{old('real')}}" name="real" id="email_address" class="form-control" placeholder="ادخل عدد ما تم طرحه بالفعل">
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-12 col-sm-3">
                                            <label for="email_address">ما تم بيعه</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input type="number" value="{{old('sold')}}" name="sold" id="email_address" class="form-control" placeholder="ما تم بيعه">
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
                            <h2><strong>قائمة </strong> التذاكر </h2>
                            {{--<a href="{{url('groups/' . $event->id . '/create')}}" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i> مجموعة جديدة </a>--}}
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>الفئة</th>
                                        <th>السعر</th>
                                        <th>العدد المطروح</th>
                                        <th>ما تم بيعه</th>
                                        <th>الإجمالي</th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>الفئة</th>
                                        <th>السعر</th>
                                        <th>العدد المطروح</th>
                                        <th>ما تم بيعه</th>
                                        <th>الإجمالي</th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($tickets)
                                        @foreach($tickets as $ticket)
                                            <tr>
                                                <td>{{$ticket->id}}</td>
                                                <td>{{$ticket->category}}</td>
                                                <td>{{$ticket->price}} ر.س </td>
                                                <td>{{$ticket->real_number_of_tickets}}</td>
                                                <td>{{$ticket->sold_tickets}}</td>
                                                <td>{{$ticket->sold_tickets * $ticket->price}} ر.س </td>
                                                <td>{{$ticket->created_at ? $ticket->created_at->diffForHumans() : ''}}</td>
                                                <td style="display: flex">
                                                    <a href="{{adminUrl('tickets/' . $ticket->id . '/edit')}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i> </a>
                                                    <a href="#" class="btn bg-red waves-effect btn-sm" data-toggle="modal" data-target="#delete{{$ticket->id}}" data-color="red"><i class="zmdi zmdi-delete"></i> </a>
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

    @if($tickets)
        @foreach($tickets as $ticket)
            <div class="modal fade" id="delete{{$ticket->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">مسح التذكرة</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد مسح التذكرة <strong> {{$ticket->item}} </strong></div>
                        <form id="deleteUser{{$ticket->id}}" style="display: none" action="{{adminUrl('tickets/' . $ticket->id . '/delete')}}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="deleteUser{{$ticket->id}}">حذف</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
