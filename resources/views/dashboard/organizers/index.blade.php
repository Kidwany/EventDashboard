@extends('dashboard.layouts.layouts')
@section('title', 'المنظمين')
@section('customizedStyle')
@endsection

@section('customizedScript')



@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>المنظمين</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">المنظمين </a></li>
                        <li class="breadcrumb-item active"> جميع المنظمين </li>
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
                    <div class="card">
                        @include('dashboard.layouts.messages')
                        <div class="header">
                            <h2><strong>قائمة </strong> بطلبات الإنضمام </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>الجوال</th>
                                        <th>المدينة</th>
                                        <th> الوضع </th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th>البريد الإلكتروني</th>
                                        <th>الجوال</th>
                                        <th>المدينة</th>
                                        <th> الوضع </th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($users)
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->phone}}</td>
                                                <td>{{$user->city->city_ar->title}}</td>
                                                <td>
                                                    <span class="badge badge-{{$user->email_verified_at ? 'success' : 'success'}}">
                                                        {{$user->email_verified_at ? 'نشط' : 'نشط'}}
                                                    </span>
                                                </td>
                                                <td>{{$user->created_at->diffForHumans()}}</td>
                                                <td style="display: flex">
                                                    <a target="_blank" href="{{adminUrl('user/' . $user->id)}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-eye"></i> </a>
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

    {{--@if($users)
        @foreach($users as $user)
            <div class="modal fade" id="delete{{$user->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">رفض الطلب</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد رفض طلب المستخدم <strong> {{$user->name}} </strong></div>
                        <form id="deleteUser{{$user->id}}" style="display: none" action="{{url('applicants/reject/' . $event->id . '/' . $user->id )}}" method="get">
                            @csrf
                            @method('get')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="deleteUser{{$user->id}}">حذف</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if($users)
        @foreach($users as $user)
            <div class="modal fade" id="accept{{$user->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-green">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">قبول الطلب</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد قبول طلب المستخدم للإنضمام<strong> {{$user->name}} </strong></div>
                        <form id="acceptApplication{{$user->id}}" style="display: none" action="{{url('applicants/accept/' . $event->id . '/' . $user->id )}}" method="post">
                            @csrf
                            @method('get')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="acceptApplication{{$user->id}}">قبول</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif--}}

@endsection
