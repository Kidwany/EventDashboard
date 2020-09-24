@extends('dashboard.layouts.layouts')
@section('title', 'الرعاة')
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
                    <h2>الرعاة</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('finance/' . $event->id)}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">الرعاة </a></li>
                        <li class="breadcrumb-item active"> جميع الرعاة </li>
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
                    <form action="{{url('sponsors/store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <input type="hidden" name="event_id" value="{{$event->id}}">
                        <div class="card">
                            @include('dashboard.layouts.messages')
                            <div class="header">
                                <h2><strong>اضف الرعاة و أنواعها</strong></h2>
                            </div>
                            <section id="gates">
                                <div class="body">
                                    <div class="row" >

                                        <div class="col-lg-6 col-md-12 col-sm-3">
                                            <label for="email_address">فئة الراعي</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input required type="text" value="{{old('category')}}" name="category" id="email_address" class="form-control" placeholder="ادخل فئة الراعي">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-sm-3">
                                            <label for="email_address">اسم الراعي</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input required type="text" value="{{old('name')}}" name="name" id="email_address" class="form-control" placeholder="ادخل اسم الراعي">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-sm-3">
                                            <label for="email_address">السعر المتوقع (ر.س)</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input step="any" type="number" value="{{old('expected')}}" name="expected" id="email_address" class="form-control" placeholder="ادخل السعر المتوقع">
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-12 col-sm-3">
                                            <label for="email_address">السعر الفعلي (ر.س)</label>
                                            <div class="form-group d-flex justify-content-between">
                                                <input step="any" type="number" value="{{old('real')}}" name="real" id="email_address" class="form-control" placeholder="ادخل السعر الفعلي">
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
                            <h2><strong>قائمة </strong> الرعاة </h2>
                            {{--<a href="{{url('groups/' . $event->id . '/create')}}" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i> مجموعة جديدة </a>--}}
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th>الفئة</th>
                                        <th>السعر المتوقع</th>
                                        <th>السعر الحقيقي</th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th>الفئة</th>
                                        <th>السعر المتوقع</th>
                                        <th>السعر الحقيقي</th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($sponsors)
                                        @foreach($sponsors as $sponsor)
                                            <tr>
                                                <td>{{$sponsor->id}}</td>
                                                <td>{{$sponsor->sponsor_name}}</td>
                                                <td>{{$sponsor->category}}</td>
                                                <td>{{$sponsor->expected_sponsorship_value}} ر.س </td>
                                                <td>{{$sponsor->real_sponsorship_value}} ر.س </td>
                                                <td>{{$sponsor->created_at ? $sponsor->created_at->diffForHumans() : ''}}</td>
                                                <td style="display: flex">
                                                    <a href="{{adminUrl('sponsors/' . $sponsor->id . '/edit')}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i> </a>
                                                    <a href="#" class="btn bg-red waves-effect btn-sm" data-toggle="modal" data-target="#delete{{$sponsor->id}}" data-color="red"><i class="zmdi zmdi-delete"></i> </a>
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

    @if($sponsors)
        @foreach($sponsors as $sponsor)
            <div class="modal fade" id="delete{{$sponsor->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">مسح الراعي</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد مسح الراعي <strong> {{$sponsor->name}} </strong></div>
                        <form id="deleteUser{{$sponsor->id}}" style="display: none" action="{{adminUrl('sponsors/' . $sponsor->id . '/delete')}}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="deleteUser{{$sponsor->id}}">حذف</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
