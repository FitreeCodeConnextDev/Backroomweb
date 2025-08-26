@extends('layouts.master')
@section('title')
    ApexCharts Example
@endsection

@section('content')
<div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
    <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
            <div class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center me-3">
                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 19">
                    <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                </svg>
            </div>
            <div>
                <h5 class="leading-none text-2xl font-bold text-gray-900 dark:text-white pb-1">Monthly Sales</h5>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Sales overview</p>
            </div>
        </div>
    </div>

    <!-- Chart container -->
    <div id="sales-chart"></div>
</div>
@endsection

@section('scripts')
<script>
    import ApexCharts from 'apexcharts';
    document.addEventListener('DOMContentLoaded', function() {
        // Chart options
        const options = {
            // Chart type
            chart: {
                type: 'line',
                height: 350,
                fontFamily: 'Inter, sans-serif',
                toolbar: {
                    show: false
                }
            },
            // Data series
            series: [{
                name: 'Sales',
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
            }],
            // X-axis configuration
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                labels: {
                    style: {
                        fontFamily: 'Inter, sans-serif'
                    }
                }
            },
            // Y-axis configuration
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return '$' + value
                    }
                }
            },
            // Tooltip configuration
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function(value) {
                        return '$' + value
                    }
                }
            },
            // Colors
            colors: ['#1A56DB'],
            // Grid configuration
            grid: {
                show: true,
                borderColor: '#E5E7EB',
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -14
                }
            },
            // Data labels
            dataLabels: {
                enabled: false
            },
            // Stroke configuration
            stroke: {
                curve: 'smooth',
                width: 2
            },
            // Markers configuration
            markers: {
                size: 4,
                colors: ['#1A56DB'],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            }
        };

        // Initialize the chart
        const chart = new ApexCharts(document.querySelector("#sales-chart"), options);
        chart.render();
    });
</script>
@endsection 