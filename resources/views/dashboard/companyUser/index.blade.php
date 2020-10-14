@extends('dashboard.layouts.layouts')
@section('title', 'المستخدمين')
@section('customizedStyle')
@endsection

@section('customizedScript')



@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>المستخدمين</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">المستخدمين </a></li>
                        <li class="breadcrumb-item active"> جميع المستخدمين </li>
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
                        <div class="header d-flex justify-content-between">
                            <h2><strong>قائمة </strong> المستخدمين </h2>
                            <a href="{{url('company-user/' . $company->id . '/create')}}" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i> مستخدم جديدة </a>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th>الجوال</th>
                                        <th>القسم</th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th>الجوال</th>
                                        <th>القسم</th>
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
                                                <td>{{$user->phone}}</td>
                                                <td>{{$user->category->category_ar}}</td>
                                                <td>{{$user->created_at->diffForHumans()}}</td>
                                                <td style="display: flex">
                                                    <a href="{{adminUrl('company-user/' . $user->id . '/edit')}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i> </a>
                                                    <a href="{{adminUrl('user/' . $user->id)}}" class="btn btn-success btn-sm"><i class="zmdi zmdi-eye"></i> </a>
                                                    <a href="#" class="btn bg-red waves-effect btn-sm" data-toggle="modal" data-target="#delete{{$user->id}}" data-color="red"><i class="zmdi zmdi-delete"></i> </a>
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

    @if($users)
        @foreach($users as $user)
            <div class="modal fade" id="delete{{$user->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">مسح المستخدم</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد مسح المستخدم <strong> {{$user->name}} </strong></div>
                        <form id="deleteUser{{$user->id}}" style="display: none" action="{{url('company-user/' . $user->id . '/delete')}}" method="post">
                            @csrf
                            @method('delete')
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

@endsection
