@extends('dashboard.layouts.layouts')
@section('title', 'البيانات المالية')
@section('customizedStyle')
@endsection

@section('customizedScript')

<script>
    $(function() {
        "use strict";
        setTimeout(function(){
            $(document).ready(function(){
                var color1 = "blue-dark";
                var color2 = "blue-darker";
                var color3 = "blue";
                var color4 = "blue-light";
                var color5 = "blue-lighter";
                var color6 = "blue-dark";
                var color7 = "blue-darker";
                var color8 = "blue";
                var color9 = "blue-light";
                var color10 = "blue-lighter";
                var chart = c3.generate({
                    bindto: '#chart-donut', // id of chart wrapper
                    data: {
                        columns: [
                            // each columns data
                            @foreach($expenses_totals as $key => $expenses_total)
                                @if($expenses_total->total_real_value > 0)
                                    ['data{{$key+1}}', {{($expenses_total->total_real_value * 100) / $total_expenses_value}}],
                                @endif
                            @endforeach
                        ],
                        type: 'donut', // default type of chart
                        colors: {
                            @foreach($expenses_totals as $key => $expenses_total)
                            @if($expenses_total->total_real_value > 0)
                                'data{{$key+1}}': Aero.colors[color{{$key+1}}],
                            @endif
                            @endforeach
                        },
                        names: {
                            // name of each serie
                            @foreach($expenses_totals as $key => $expenses_total)
                            @if($expenses_total->total_real_value > 0)
                                'data{{$key+1}}': '{{$expenses_total->category->category}}',
                            @endif
                            @endforeach
                        }
                    },
                    axis: {
                    },
                    legend: {
                        show: true, //hide legend
                    },
                    padding: {
                        bottom: 0,
                        top: 0
                    },
                });
            });
        }, 500);
    });
</script>

@endsection

@section('content')

    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>البيانات المالية</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{adminUrl('finance/' . $event->id)}}"><i class="zmdi zmdi-home"></i> همتك </a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">البيانات المالية </a></li>
                        <li class="breadcrumb-item active"> جميع البيانات المالية </li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        @include('dashboard.layouts.eventNav')
        @include('dashboard.layouts.financeNav')

        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center">
                    <div class="card" style="text-align: center !important;">
                        <div class="body">
                            <input type="text" class="knob" value="
                                {{ $tickets_total->total_expected > 0 ? round((($tickets_total->total_real_value * 100) / $tickets_total->total_expected), 0) : 100}}"
                                   data-linecap="round" data-width="100" data-height="100" data-thickness="0.08" data-fgColor="#00adef" readonly style="margin-right: -77px !important;">
                            <p>التذاكر</p>
                            <div class="d-flex bd-highlight text-center mt-4">
                                <div class="flex-fill bd-highlight">
                                    <small class="text-muted">المتوقع</small>
                                    <h5 class="mb-0">{{$tickets_total ? $tickets_total->total_expected : 0}} ر.س</h5>
                                </div>
                                <div class="flex-fill bd-highlight">
                                    <small class="text-muted">الفعلي</small>
                                    <h5 class="mb-0">{{$tickets_total ? $tickets_total->total_real_value : 0}} ر.س</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center">
                    <div class="card" style="text-align: center !important;">
                        <div class="body">
                            <input type="text" class="knob" value="
                            {{ $sponsors_total->total_expected > 0 ? round(($sponsors_total->total_real_value * 100) / $sponsors_total->total_expected,0) : 100}}"
                                   data-linecap="round" data-width="100" data-height="100" data-thickness="0.08" data-fgColor="#8f78db" readonly style="margin-right: -77px !important;">
                            <p>الرعاة</p>
                            <div class="d-flex bd-highlight text-center mt-4">
                                <div class="flex-fill bd-highlight">
                                    <small class="text-muted">المتوقع</small>
                                    <h5 class="mb-0">{{$sponsors_total ? $sponsors_total->total_expected : 0}} ر.س</h5>
                                </div>
                                <div class="flex-fill bd-highlight">
                                    <small class="text-muted">الفعلي</small>
                                    <h5 class="mb-0">{{$sponsors_total ? $sponsors_total->total_real_value : 0}} ر.س</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center">
                    <div class="card" style="text-align: center !important;">
                        <div class="body">
                            <input type="text" class="knob" value="
                            {{ $spaces_total->total_expected > 0 ? round(($spaces_total->total_real_value * 100) / $spaces_total->total_expected,0) : 100}}"
                                   data-linecap="round" data-width="100" data-height="100" data-thickness="0.08" data-fgColor="#f67a82" readonly style="margin-right: -77px !important;">
                            <p> المساحات</p>
                            <div class="d-flex bd-highlight text-center mt-4">
                                <div class="flex-fill bd-highlight">
                                    <small class="text-muted">المتوقع</small>
                                    <h5 class="mb-0">{{$spaces_total ? $spaces_total->total_expected : 0}} ر.س</h5>
                                </div>
                                <div class="flex-fill bd-highlight">
                                    <small class="text-muted">الفعلي</small>
                                    <h5 class="mb-0">{{$spaces_total ? $spaces_total->total_real_value : 0}} ر.س</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-6 text-center">
                    <div class="card" style="text-align: center !important;">
                        <div class="body">
                            <input type="text" class="knob" value="
                            {{ $other_total->total_expected > 0 ? round(($other_total->total_real_value * 100) / $other_total->total_expected,0) : 100}}"
                                   data-linecap="round" data-width="100" data-height="100" data-thickness="0.08" data-fgColor="#ee2558" readonly style="margin-right: -77px !important;">
                            <p>اخرى</p>
                            <div class="d-flex bd-highlight text-center mt-4">
                                <div class="flex-fill bd-highlight">
                                    <small class="text-muted">المتوقع</small>
                                    <h5 class="mb-0">{{$other_total ? $other_total->total_expected : 0}} ر.س</h5>
                                </div>
                                <div class="flex-fill bd-highlight">
                                    <small class="text-muted">الفعلي</small>
                                    <h5 class="mb-0">{{$other_total ? $other_total->total_real_value : 0}} ر.س</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>احصائيات</strong> التكاليف الفعلية</h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div id="chart-donut" style="height: 17rem"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover c_table mb-0">
                                            <tbody>
                                            @foreach($expenses_totals as $key => $expenses_total)
                                                @if($expenses_total->total_real_value > 0)
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$expenses_total->category->category}}</td>
                                                        <td>{{$expenses_total->total_real_value}} ر.س<i class="zmdi zmdi-caret-up text-success"></i></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12 col-lg-12">
                    <div class="card visitors-map">
                        <div class="header">
                            <h2><strong>التكاليف</strong> المتوقعة</h2>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-4 col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-hover c_table theme-color mb-0">
                                        <thead>
                                        <tr>
                                            <th>قسم التكلفة</th>
                                            <th>60%</th>
                                            <th>100%</th>
                                            <th>تم التعديل</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $total60 = 0;
                                            $total100 = 0;
                                        @endphp
                                        @foreach($expenses_totals as $key => $expenses_total)
                                            <tr>
                                                <td>{{$expenses_total->category->category}}</td>
                                                <td>{{($expenses_total->total_expected * 60) /100}} ر.س </td>
                                                <td>{{$expenses_total->total_expected}} ر.س </td>
                                                <td>{{$expenses_total->updated_at}} <i class="zmdi zmdi-trending-up text-success"></i></td>
                                            </tr>
                                            @php
                                            $total60 += ($expenses_total->total_expected * 60) /100;
                                            $total100 += $expenses_total->total_expected;
                                            @endphp
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>قسم التكلفة</th>
                                            <th>{{$total60}} ر.س </th>
                                            <th>{{$total100}} ر.س </th>
                                            <th>تم التعديل</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
