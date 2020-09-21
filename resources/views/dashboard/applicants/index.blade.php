@extends('dashboard.layouts.layouts')
@section('title', 'المتقدمين')
@section('customizedStyle')
@endsection

@section('customizedScript')



@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>المتقدمين</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">المتقدمين </a></li>
                        <li class="breadcrumb-item active"> جميع المتقدمين </li>
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
                                    @if($applicants)
                                        @foreach($applicants as $applicant)
                                            <tr>
                                                <td>{{$applicant->user->id}}</td>
                                                <td>{{$applicant->user->name}}</td>
                                                <td>{{$applicant->user->email}}</td>
                                                <td>{{$applicant->user->phone}}</td>
                                                <td>{{$applicant->user->city->city_ar->title}}</td>
                                                <td>
                                                    <span class="badge badge-{{$applicant->user->email_verified_at ? 'success' : 'success'}}">
                                                        {{$applicant->user->email_verified_at ? 'نشط' : 'نشط'}}
                                                    </span>
                                                </td>
                                                <td>{{$applicant->user->created_at->diffForHumans()}}</td>
                                                <td style="display: flex">
                                                    <a target="_blank" href="{{adminUrl('user/' . $applicant->user->id)}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-eye"></i> </a>
                                                    <a href="#" class="btn bg-red waves-effect btn-sm" data-toggle="modal" data-target="#delete{{$applicant->id}}" data-color="red"><i class="zmdi zmdi-block"></i> </a>
                                                    <a href="#" class="btn bg-success waves-effect btn-sm" data-toggle="modal" data-target="#accept{{$applicant->id}}" data-color="green"><i class="zmdi zmdi-check"></i> </a>
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

    @if($applicants)
        @foreach($applicants as $applicant)
            <div class="modal fade" id="delete{{$applicant->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">رفض الطلب</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد رفض طلب المستخدم <strong> {{$applicant->user->name}} </strong></div>
                        <form id="deleteUser{{$applicant->id}}" style="display: none" action="{{url('applicants/reject/' . $applicant->id )}}" method="get">
                            @csrf
                            @method('get')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="deleteUser{{$applicant->id}}">حذف</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @if($applicants)
        @foreach($applicants as $applicant)
            <div class="modal fade" id="accept{{$applicant->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-green">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">قبول الطلب</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد قبول طلب المستخدم للإنضمام<strong> {{$applicant->user->name}} </strong></div>
                        <form id="acceptApplication{{$applicant->id}}" style="display: none" action="{{url('applicants/accept/' . $applicant->id )}}" method="post">
                            @csrf
                            @method('get')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="acceptApplication{{$applicant->id}}">قبول</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
