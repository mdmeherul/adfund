@extends('layouts.app')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>

    </ul>
@endsection

@push('script-page')
    <script>
        var options = {
            series: [{
                name: "{{__('Payment')}}",
                type: 'column',
                data: {!! json_encode($result['paymentOverview']['payment']) !!},
            }],
            chart: {
                height: 452,
                type: 'line',
                toolbar:{
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            legend:{
                show:false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [0,0],
                curve: 'smooth',
            },
            plotOptions: {
                bar: {
                    columnWidth:"20%",
                    startingShape:"rounded",
                    endingShape: "rounded",
                }
            },
            fill:{
                opacity:[1, 0.08],
                gradient:{
                    type:"horizontal",
                    opacityFrom:0.5,
                    opacityTo:0.1,
                    stops: [100, 100, 100]
                }
            },
            colors: [Codexdmeki.themeprimary],
            states: {
                normal: {
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
                hover: {
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'darken',
                        value: 1,
                    }
                },
            },
            grid:{
                strokeDashArray: 2,
            },

            yaxis:{
                tickAmount: 10 ,
                labels:{
                    formatter: function (y) {
                        return  "{{$result['settings']['CURRENCY_SYMBOL']}}" + y.toFixed(0);
                    },
                    style: {
                        colors: '#262626',
                        fontSize: '14px',
                        fontWeight: 500,
                        fontFamily: 'Roboto, sans-serif'
                    }
                },
            },
            xaxis: {
                categories: {!! json_encode($result['paymentOverview']['label']) !!} ,
                axisTicks: {
                    show:false
                },
                axisBorder:{
                    show:false
                },
                labels:{
                    style: {
                        colors: '#262626',
                        fontSize: '14px',
                        fontWeight: 500,
                        fontFamily: 'Roboto, sans-serif'
                    },
                },
            },
            responsive:[
                {
                    breakpoint: 1441,
                    options:{
                        chart:{
                            height: 445
                        }
                    },
                },
                {
                    breakpoint: 1366,
                    options:{
                        chart:{
                            height: 320
                        }
                    },
                },
            ]
        };
        var chart = new ApexCharts(document.querySelector("#paymentOverview"), options);
        chart.render();
    </script>
@endpush
@php
$settings=settings();
@endphp
@section('content')
    <div class="row">
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Customer')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>
                        <span class="count">{{$result['totalCustomer']}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Agent')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2>
                        <span class="count">{{$result['totalAgent']}}</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Policy')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2><span class="count">{{$result['totalPolicy']}}</span> </h2>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-6 cdx-xxl-50">
            <div class="card sale-revenue">
                <div class="card-header">
                    <h4>{{__('Total Insurance')}}</h4>
                </div>
                <div class="card-body progressCounter">
                    <h2><span class="count">{{$result['totalInsurance']}}</span> </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-12 cdx-xxl-50">
            <div class="card overall-revenuetbl">
                <div class="card-header">
                    <h4>{{__('Payment Overview')}}</h4>

                </div>
                <div class="card-body">
                    <div id="paymentOverview"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
