@extends('dashboard.layouts.layouts')
@section('title', 'المهام')
@section('customizedStyle')
@endsection

@section('customizedScript')



@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>المهام</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">المهام </a></li>
                        <li class="breadcrumb-item active"> جميع المهام </li>
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
                    @include('dashboard.layouts.messages')
                    <div class="card project_list">
                        <div class="header d-flex justify-content-between">
                            <h2><strong>قائمة </strong> المهام </h2>
                            <a href="{{url('tasks/' . $event->id . '/create')}}" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i> مهمة جديدة </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover c_table theme-color">
                                <thead>
                                <tr>
                                    <th style="width:50px;">الرقم</th>
                                    {{--<th>المشرف</th>--}}
                                    <th>المهمة</th>
                                    <th class="hidden-md-down">المنظمين</th>
                                    <th class="hidden-md-down" width="150px">الحالة</th>
                                    <th>تمت اللإضافة</th>
                                    <th>تعديل</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($tasks)
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td>{{$task->id}}</td>
                                            {{--<td>
                                                <a class="single-user-name" href="{{adminUrl('user/' . $task->createdBy->id)}}">{{$task->createdBy->name}}</a><br>
                                            </td>--}}
                                            <td>
                                                <strong>{{$task->task_title}}</strong><br>
                                            </td>
                                            <td class="hidden-md-down">
                                                <ul class="list-unstyled team-info margin-0">
                                                    @foreach($task->members as $user)
                                                        <li><img src="{{$user->image_id ? $user->image->url : 'https://www.api.hemmtk.com/general/documents/1599263288download.jpg'}}" alt="Avatar" title="{{$user->name}}"></li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td><span class="badge badge-info">{{$task->Status->title_ar}}</span></td>
                                            <td>{{$task->created_at->diffForHumans()}}</td>
                                            <td class="hidden-md-down d-flex">
                                                <a href="{{adminUrl('tasks/edit/' . $event->id . '/' . $task->id)}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-edit"></i> </a>
                                                <a href="#" class="btn bg-red waves-effect btn-sm" data-toggle="modal" data-target="#delete{{$task->id}}" data-color="red"><i class="zmdi zmdi-delete"></i> </a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        {{--<ul class="pagination pagination-primary mt-4">
                            <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">4</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">5</a></li>
                        </ul>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($tasks)
        @foreach($tasks as $task)
            <div class="modal fade" id="delete{{$task->id}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content bg-red">
                        <div class="modal-header">
                            <h4 class="title" id="defaultModalLabel">مسح المهمة</h4>
                        </div>
                        <div class="modal-body text-light" style="text-align: right"> هل انت متأكد من انك تريد مسح المهمة <strong> {{$task->name}} </strong></div>
                        <form id="deleteUser{{$task->id}}" style="display: none" action="{{url('tasks/delete/' . $task->id)}}" method="post">
                            @csrf
                            @method('delete')
                        </form>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-link waves-effect text-light" form="deleteUser{{$task->id}}">حذف</button>
                            <button type="button" class="btn btn-link waves-effect text-light" data-dismiss="modal">الغاء</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

@endsection
