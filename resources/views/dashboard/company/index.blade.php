@extends('dashboard.layouts.layouts')
@section('title', 'الشركات')
@section('customizedStyle')
@endsection

@section('customizedScript')



@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>الشركات</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">الشركات </a></li>
                        <li class="breadcrumb-item active"> جميع الشركات </li>
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
                            <h2><strong>قائمة </strong> الشركات </h2>
                            <a href="{{url('company/' . $event->id . '/create')}}" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i> شركة جديدة </a>
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
                                        <th>عدد الموظفين</th>
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
                                        <th>عدد الموظفين</th>
                                        <th> تمت الإضافة </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($companies)
                                        @foreach($companies as $company)
                                            <tr>
                                                <td>{{$company->id}}</td>
                                                <td>{{$company->name}}</td>
                                                <td>{{$company->phone}}</td>
                                                <td>{{$company->category->category_ar}}</td>
                                                <td>{{$company->members->count()}}</td>
                                                <td>{{$company->created_at->diffForHumans()}}</td>
                                                <td style="display: flex">
                                                    <a href="{{adminUrl('company/' . $company->id . '/edit')}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i> </a>
                                                    <a href="{{adminUrl('company-user/' . $company->id)}}" class="btn btn-success btn-sm" title="اعضاء الشركة"><i class="zmdi zmdi-accounts"></i> </a>
                                                    <a href="{{adminUrl('company-user/' . $company->id . '/create')}}" class="btn btn-success btn-sm" title="اضافة عضو للشركة"><i class="zmdi zmdi-plus"></i> </a>
                                                    <a href="#" class="btn bg-red waves-effect btn-sm" data-toggle="modal" data-target="#delete{{$company->id}}" data-color="red"><i class="zmdi zmdi-delete"></i> </a>
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

    @if($companies)
        @foreach($companies as $company)
            <div class="modal fade" id="delete{{$company->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">مسح الشركة</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد مسح الشركة <strong> {{$company->name}} </strong></div>
                        <form id="deleteUser{{$company->id}}" style="display: none" action="{{url('company/' . $company->id . '/delete')}}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="deleteUser{{$company->id}}">حذف</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
