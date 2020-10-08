@extends('dashboard.layouts.layouts')
@section('title', 'الإستراحة')
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
                    <h2>الإستراحة</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">الإستراحة </a></li>
                        <li class="breadcrumb-item active"> جميع الإستراحة </li>
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
                            <h2><strong>قائمة </strong> الإستراحة </h2>
                            {{--<a href="{{url('break/' . $event->id . '/create')}}" class="btn btn-primary">
                                <i class="zmdi zmdi-plus"></i> عهدة جديدة </a>--}}
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table id="ssss" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th>المجموعة</th>
                                        <th>دقائق الإستراحة</th>
                                        <th> في استراحة الأن </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>م</th>
                                        <th>الإسم</th>
                                        <th>المجموعة</th>
                                        <th>دقائق الإستراحة</th>
                                        <th> في استراحة الأن </th>
                                        <th>تعديل</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @if($users)
                                        @foreach($users as $user)
                                            <tr>
                                                <td>{{$user->id}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$user->member->group->name}}</td>
                                                <td>{{\App\Classes\CalculateTotalBreakTime::calculateTotalByEvent($user->id, $event->id)}}</td>
                                                <td>{!! $user->break->rest_end > \Carbon\Carbon::now() ? "<i class='zmdi zmdi-check'></i>" : "<i class='text-danger zmdi zmdi-close'></i>" !!}</td>
                                                <td style="display: flex">
                                                    {{--<a href="{{adminUrl('break/' . $user->id . '/edit')}}" class="btn btn-primary btn-sm"><i class="zmdi zmdi-local-cafe"></i> </a>--}}
                                                    <a href="{{adminUrl('break/'.$event->id.'/add-break-to-user/'.$user->id)}}" class="btn bg-primary waves-effect btn-sm" data-color="red"><i class="zmdi zmdi-local-cafe"></i> </a>
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
