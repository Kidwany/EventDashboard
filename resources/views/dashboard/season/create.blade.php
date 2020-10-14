@extends('dashboard.layouts.layouts')
@section('title', 'المواسم')
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
                    <h2>المواسم</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">المواسم </a></li>
                        <li class="breadcrumb-item active"> موسم جديدة </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            @include('dashboard.layouts.messages')
            <!-- Vertical Layout -->
            <form action="{{route('season.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>اضف بيانات الموسم </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم الموسم</label>
                                        <div class="form-group">
                                            <input required type="text" name="title" value="{{old('title')}}" id="email_address" class="form-control" placeholder="ادخل اسم الموسم">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">وصف الموسم</label>
                                        <div class="form-group">
                                            <input required type="text" name="description" value="{{old('description')}}" id="email_address" class="form-control" placeholder="ادخل وصفا دقيقا للمنتج">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <label> المدينة</label>
                                        <select name="city_id" class="form-control show-tick ms select2"  data-placeholder="اختر المدينة">
                                            @if($cities)
                                                @foreach($cities as $city)
                                                    <option value="{{$city->id}}" {{old('city_id') == $city->id ? 'selected' : ''}}>
                                                        {{$city->city_ar->title}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>


                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">بداية الموسم</label>
                                        <div class="form-group">
                                            <input required type="date" name="start" value="{{old('start') ? date('Y-m-d', strtotime(old('start'))) : ''}}" id="email_address" class="form-control" placeholder="ادخل عنوان الموسم بالتفصيل">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">نهاية الموسم</label>
                                        <div class="form-group">
                                            <input required type="date" name="end" value="{{old('end') ? date('Y-m-d', strtotime(old('end'))) : ''}}" id="email_address" class="form-control" placeholder="ادخل عنوان الموسم بالتفصيل">
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">حفظ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection
