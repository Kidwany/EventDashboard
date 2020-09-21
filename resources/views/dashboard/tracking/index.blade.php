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
                    <h2>التتبع</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">التتبع </a></li>
                        <li class="breadcrumb-item active"> التتبع</li>
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
                    @include('dashboard.layouts.messages')
                    <div class="card project_list">
                        <div class="header d-flex justify-content-between">
                            <h2><strong>قائمة </strong> التتبع </h2>

                        </div>
                        <div class="table-responsive">

                            <div id="map"></div>
                            <iframe src="{{URL::to('/tracking/'.$event->id.'/map')}}" width="100%" height="600"></iframe>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
