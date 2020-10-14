@extends('dashboard.layouts.layouts')
@section('title', 'المجموعات')
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
                    <h2>المجموعات</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('/')}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">المجموعات </a></li>
                        <li class="breadcrumb-item active"> بيانات المجموعات </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-left"></i></button>
                </div>
            </div>
        </div>


        <div class="container-fluid elm" id="print">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>ادخل</strong> البيانات</h2>
                        </div>
                        <div class="body">
                            @include('dashboard.layouts.messages')
                            <form action="{{url('company-group/store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="row clearfix">
                                    <input type="hidden" name="company_id" value="{{$company->id}}">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="header">
                                                <h2><strong>اضف بيانات المجموعات </strong></h2>
                                            </div>
                                            <div class="body">
                                                <div class="row">

                                                    <div class="col-lg-6 col-md-12 col-sm-3">
                                                        <label for="email_address">اسم المجموعة</label>
                                                        <div class="form-group">
                                                            <input required type="text" name="name" value="{{old('name')}}" id="email_address" class="form-control" placeholder="ادخل اسم المجموعة">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6 col-md-6">
                                                        <label>اضافة مستخدمين للمجموعة</label>
                                                        <select name="users[]" class="form-control show-tick ms select2"  multiple data-placeholder="اختر اعضاء المجموعة من بين المستخدمين">
                                                            @if($users)
                                                                @foreach($users as $user)
                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
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
                </div>
            </div>
        </div>
    </div>

@endsection
