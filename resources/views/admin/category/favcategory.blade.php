@extends('admin.layouts.master')
@section('title', __('Favorite Categories'))
@section('breadcum')
    <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">{{ __('Favorite Categories') }}</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Categories') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Favorite Categories') }}</li>

                    </ol>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('maincontent')
    <div class="contentbar">
        <!-- Start row -->

        <div class="row">
            <!-- Start col -->

            <div class="col-lg-12 mb-2">
                <div class="card m-b-30">
                    <div class="card-header">
                        <h5 class="card-title">Categories</h5>
                    </div>
                    <div class="card-body">
                        <div id="apex-pie-chart"></div>
                    </div>
                </div>
            </div>

            @foreach ($favcats as $key => $favcat)

                <div class="col-lg-6 mb-2">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <h5 class="card-title">{{ $key }}</h5>
                        </div>
                        <div class="card-body" style="margin:auto">
                            <div id="apex-pie-chart-{{ str_replace(' ', '-', $key) }}"></div>
                            {{-- apex-pie-chart-{{ str_replace(' ', '', $key) }} --}}
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
    </div>



@endsection
@section('scripts')
    <script type="text/javascript">
        var cat_counts = @json($cat_counts);
        var favcats = @json($favcats);
        var keys = @json($keys);
        var cat_colors = @json($cat_colors);
        var colors = @json($colors);
        "use strict";


        var options = {
            chart: {
                type: 'donut',
                width: 300,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: "85%"
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            colors: cat_colors,
            series: cat_counts,
            // labels: ['Courses', 'Bundle Courses', 'Live Meetings'],
            labels: keys,
            legend: {
                show: true,
                position: 'bottom'
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#apex-pie-chart"),
            options
        );
        chart.render();


        for (let i = 0; i < keys.length; i += 1) {

            
            var sub_data = Object.keys(favcats[keys[i]]) ;  
            var sub_colors = colors.slice(0, Object.keys(favcats[keys[i]]).length);
            var sub_counts =  Object.values(favcats[keys[i]]);              

            // console.log(sub_data);
            // console.log(sub_counts);
            // console.log(sub_colors);


            var subOptions = {
                chart: {
                    type: 'donut',
                    width: 300,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: "85%"
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },

                colors: sub_colors,
                series: sub_counts,
                labels: sub_data,
                legend: {
                    show: true,
                    position: 'bottom'
                },
            }
            // console.log(document.querySelector("#apex-pie-chart-" + keys[i].replaceAll(' ', '-')))
            var chart = new ApexCharts(document.querySelector("#apex-pie-chart-" + keys[i].replaceAll(' ', '-')), subOptions);
            chart.render();

        }
    </script>
@endsection
