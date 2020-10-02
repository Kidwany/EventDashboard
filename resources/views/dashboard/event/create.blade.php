@extends('dashboard.layouts.layouts')
@section('title', 'الفعاليات')
@section('customizedStyle')
@endsection

@section('customizedScript')
    <script>
        $('.select2').select2()
    </script>


    <script>
        $(document).ready(function () {
            var count = 1;
            var maxField = 5; //Input fields Increment Limitation
            var addButton = document.getElementById('add_email');
            var fieldsWrapper = document.getElementById('gates');


            $(addButton).click(function () {
                var fieldHtml = '<section class="body"data-id='+count+'>' +
                    '                                <div class="row" >' +
                    '                                    <div class="col-lg-6 col-md-6">' +
                    '                                        <label> النوع</label>' +
                    '                                        <select name="gate_id[]" class="form-control show-tick ms select2"  data-placeholder="اختر الخدمات التي تقدمها المغسلة">' +
                    '                                            @if($gates_types)' +
                    '                                                @foreach($gates_types as $gate)' +
                    '                                                    <option value="{{$gate->id}}">{{$gate->type_ar}}</option>' +
                    '                                                @endforeach' +
                    '                                            @endif' +
                    '                                        </select>' +
                    '                                    </div>' +
                    '                                    <div class="col-lg-6 col-md-12 col-sm-3">' +
                    '                                        <label for="email_address">اسم البوابة</label>' +
                    '                                        <div class="form-group d-flex justify-content-between">' +
                    '                                            <input required type="text" name="gate_name[]" value="{{old('gate_name')}}" id="email_address" class="form-control" placeholder="ادخل اسم البوابة">' +
                    '                                            <button type="button" data-id='+count+' class="remove_email btn btn-danger btn-sm" style="margin: 0 12px" id="remove">-</button>' +
                    '                                        </div>' +
                    '                                    </div>' +
                    '                                </div>' +
                    '                            </section>';

                $(fieldsWrapper).append(fieldHtml);
                    count++;
            });

            $(fieldsWrapper).on('click', '#remove', function (e) {
                e.preventDefault();
                /*$(this).parent('div').remove();
                $(this).parent('div').next().remove();*/
                var id = $(this).data("id");
                var body_container = $(".body").each(function (e) {
                   var body_id = $(this).attr('data-id');
                   if (body_id == id)
                   {
                       $(this).remove();
                   }
                });
                count--;
            })

        });

    </script>
@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>الفعاليات</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">الفعاليات </a></li>
                        <li class="breadcrumb-item active"> فعالية جديدة </li>
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
            <form action="{{route('event.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="header">
                                <h2><strong>اضف بيانات الفعالية </strong></h2>
                            </div>
                            <div class="body">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6">
                                        <label> الموسم</label>
                                        <select name="season_id" class="form-control show-tick ms select2"  data-placeholder="اختر الموسم">
                                            @if($seasons)
                                                @foreach($seasons as $season)
                                                    <option value="{{$season->id}}" {{old('season_id') == $season->id ? 'selected' : ''}}>
                                                        {{$season->name}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">اسم الفعالية</label>
                                        <div class="form-group">
                                            <input required type="text" name="title" value="{{old('title')}}" id="email_address" class="form-control" placeholder="ادخل اسم الفعالية">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">وصف الفعالية</label>
                                        <div class="form-group">
                                            <input required type="text" name="description" value="{{old('description')}}" id="email_address" class="form-control" placeholder="ادخل وصفا دقيقا للمنتج">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">الأدوار</label>
                                        <div class="form-group">
                                            <input required type="number" name="floors" value="{{old('floors')}}" step="any" id="email_address" class="form-control" placeholder="عدد الأدوار">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">العنوان</label>
                                        <div class="form-group">
                                            <input required type="text" name="address" value="{{old('address')}}" id="email_address" class="form-control" placeholder="ادخل عنوان الفعالية بالتفصيل">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">الموقع على الخريطة</label>
                                        <div class="form-group">
                                            <input required type="url" name="location" value="{{old('location')}}" id="email_address" class="form-control" placeholder="رابط الموقع على الخريطة">
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

                                    <div class="col-lg-6 col-md-6">
                                        <label> القسم</label>
                                        <select name="category_id" class="form-control show-tick ms select2"  data-placeholder="اختر الخدمات التي تقدمها المغسلة">
                                            @if($categories)
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>
                                                        {{$category->category_ar->title}}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>


                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">صورة الفعالية</label>
                                        <div class="form-group">
                                            <input required type="file" name="image" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">صور الفعالية</label>
                                        <div class="form-group">
                                            <input required multiple type="file" name="images[]" id="email_address" class="form-control" placeholder="">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">بداية الفعالية</label>
                                        <div class="form-group">
                                            <input required type="date" name="start" value="{{old('start') ? date('Y-m-d', strtotime(old('start'))) : ''}}" id="email_address" class="form-control" placeholder="ادخل عنوان الفعالية بالتفصيل">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">توقيت الفعالية</label>
                                        <div class="form-group">
                                            <input required type="time" name="start_time" value="{{old('start_time') ? date('Y-m-d', strtotime(old('start_time'))) : ''}}" id="email_address" class="form-control" placeholder="ادخل عنوان الفعالية بالتفصيل">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">نهاية الفعالية</label>
                                        <div class="form-group">
                                            <input required type="date" name="end" value="{{old('end') ? date('Y-m-d', strtotime(old('end'))) : ''}}" id="email_address" class="form-control" placeholder="ادخل عنوان الفعالية بالتفصيل">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">توقيت نهاية  الفعالية</label>
                                        <div class="form-group">
                                            <input required type="time" name="end_time" value="{{old('end_time') ? date('Y-m-d', strtotime(old('end_time'))) : ''}}" id="email_address" class="form-control" placeholder="ادخل عنوان الفعالية بالتفصيل">
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                        <label for="email_address">الميزانية</label>
                                        <div class="form-group">
                                            <input required type="number" name="budget" value="{{old('budget')}}" step="any" id="email_address" class="form-control" placeholder="ميزاينة الفعالية">
                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">حفظ</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12" >
                        <div class="card">
                            <div class="header">
                                <h2><strong>اضف البوابات و أنواعها</strong></h2>
                            </div>
                            <section id="gates">
                                @if(is_array(old('gate_type_ids')) || is_array(old('gates_names')))
                                    <div class="body">
                                        <div class="row" >
                                            @foreach(old('gate_type_ids') as $key => $value)
                                                <div class="col-lg-6 col-md-6">
                                                    <label> النوع</label>
                                                    <select name="gate_type_ids[]" class="form-control show-tick ms select2"  data-placeholder="اختر الخدمات التي تقدمها المغسلة">
                                                        @if($gates_types)
                                                            @foreach($gates_types as $gate)
                                                                <option value="{{$gate->id}}" {{$value == $gate->id ? 'selected' : ''}}>{{$gate->type_ar}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            @endforeach
                                            @foreach(old('gates_names') as $key => $value)
                                                <div class="col-lg-6 col-md-12 col-sm-3">
                                                    <label for="email_address">اسم البوابة</label>
                                                    <div class="form-group d-flex justify-content-between">
                                                        <input required type="text" name="gates_names[]" value="{{$value}}" id="email_address" class="form-control" placeholder="ادخل اسم البوابة">
                                                        @if($key == 0)
                                                            <button type="button" class="add_email btn btn-primary btn-sm" id="add_email" style="margin: 0 12px">+</button>
                                                        @endif
                                                        @if($key != 0)
                                                            <button type="button" data-id="{{$key}}" class="remove_email btn btn-danger btn-sm" style="margin: 0 12px" id="remove">-</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @else
                                    <div class="body">
                                        <div class="row" >
                                                <div class="col-lg-6 col-md-6">
                                                    <label> النوع</label>
                                                    <select name="gate_type_ids[]" class="form-control show-tick ms select2"  data-placeholder="اختر الخدمات التي تقدمها المغسلة">
                                                        @if($gates_types)
                                                            @foreach($gates_types as $gate)
                                                                <option value="{{$gate->id}}">{{$gate->type_ar}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 col-md-12 col-sm-3">
                                                    <label for="email_address">اسم البوابة</label>
                                                    <div class="form-group d-flex justify-content-between">
                                                        <input required type="text" name="gates_names[]" id="email_address" class="form-control" placeholder="ادخل اسم البوابة">
                                                        <button type="button" class="add_email btn btn-primary btn-sm" id="add_email" style="margin: 0 12px">+</button>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                @endif
                            </section>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



@endsection
