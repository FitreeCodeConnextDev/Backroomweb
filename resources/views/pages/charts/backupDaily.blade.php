@extends('layouts.master')
@section('title')
    {{ __('chart.daily_backup_chart') }}
@endsection
@section('content')
    <div class="lg:w-full bg-white rounded-lg shadow-sm  p-4 md:p-6">

        <div class="flex justify-between pb-4 mb-4 border-b border-gray-200 ">
            <div class="flex items-center">
                <div>
                    <h5 class="leading-none text-2xl font-bold text-gray-900 ">{{ __('chart.daily_backup_chart') }}</h5>
                    {{-- <p class="text-sm font-normal text-gray-500 ">Leads generated per week</p> --}}
                </div>

            </div>

        </div>
        <div class="flex justify-between pb-4 mb-4 border-b border-gray-200">
            <form action="{{ route('daily-backup-showdailybackupchart') }}" method="post">
                @csrf
                <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                    <div>
                        <label for="start_date" class="label_input"> {{ __('chart.start_date') }} </label>
                        <input type="date" class="input_text" name="start_date" value="{{ $start_date }}"
                            placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}">

                    </div>
                    <div>
                        <label for="end_date" class="label_input">{{ __('chart.end_date') }}</label>
                        <input type="date" class="input_text" name="end_date" value="{{ $end_date }}"
                            placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}">

                    </div>
                    <div class="mt-7 flex space-x-3">
                        <div>
                            <button type="submit" class="submit_btn">
                                {{ __('menu.button.confirm') }}
                            </button>
                        </div>
                        <div>
                            <a href="{{ route('daily-backup-charts') }}">
                                <button type="button" class="reset_button">
                                    {{ __('menu.button.reset') }}
                                </button>
                            </a>
                        </div>
                        <div>
                            <button type="button" class="excel_button" id="exportToCSV">
                                {{ __('chart.csv') }}
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        {{-- @dd($daily_chart_backup['vendor_id']) --}}
        <div id="column-chart" class=" flex justify-center"></div>
    </div>
@endsection
@section('scripts')
    {{-- <script src="{{ asset('js/charts/donutCharts.js') }}"></script> --}}
    <script type="text/javascript">
        // Data for CSV export
        const data_json = {
            vendor_name: [<?php echo $daily_chart_backup['vendor_name']; ?>],
            total_amount: [<?php echo $daily_chart_backup['total_amount']; ?>]
        };

        function exportCsv() {
            // Add UTF-8 BOM
            const BOM = "\uFEFF";
            // Create CSV header
            let csvContent = BOM + "vendor_name,total_amount\n";

            // Add data rows
            for (let i = 0; i < data_json.vendor_name.length; i++) {
                const row = [
                    data_json.vendor_name[i],
                    Number(data_json.total_amount[i]).toFixed(2)
                ];
                csvContent += row.join(',') + '\n';
            }

            // Create blob and download link
            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const link = document.createElement("a");
            const url = URL.createObjectURL(blob);

            // Set download attributes
            link.setAttribute("href", url);
            link.setAttribute("download", "daily_backup_data.csv");
            link.style.visibility = 'hidden';

            // Trigger download
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Add click event listener to export button
        document.getElementById('exportToCSV').addEventListener('click', exportCsv);
    </script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            let donutCharts = new ApexCharts(document.getElementById("column-chart"), getdonutChartsOptions());
            donutCharts.render();

        });

        function getdonutChartsOptions() {
            const chartColors = [
                '#FFC300', '#800000', '#46F0F0', '#581845', '#98FB98', '#4363D8', '#FF6347', '#3CB44B', '#FABEBE',
                '#9370DB',
                '#A9A9A9', '#00FA9A', '#D2691E', '#FF33A1', '#BFEF45', '#6A5ACD', '#DE3163', '#FFFAC8', '#000075',
                '#33FFA1',
                '#E6194B', '#7B68EE', '#BDB76B', '#F58231', '#469990', '#FFD8B1', '#C71585', '#00BFFF', '#F5DEB3',
                '#8B008B',
                '#AAFFC3', '#1E90FF', '#F08080', '#911EB4', '#7CFC00', '#BC8F8F', '#FF1493', '#228B22', '#DDA0DD',
                '#9A6324',
                '#33FF57', '#DA70D6', '#B8860B', '#FF7F50', '#00CED1', '#E6E6FA', '#808000', '#3357FF', '#FFD700',
                '#6495ED',
                '#900C3F', '#ADFF2F', '#4682B4', '#F032E6', '#66CDAA', '#C70039', '#87CEEB', '#FF4500', '#A133FF',
                '#AFEEEE',
                '#CD5C5C', '#5F9EA0', '#FF69B4', '#008B8B', '#B0C4DE', '#BA55D3', '#7FFFD4', '#DAA520', '#DCBEFF',
                '#FA8072',
                '#006400', '#EE82EE', '#9ACD32', '#FF8C00', '#48D1CC', '#F4A460', '#3CB371', '#B22222', '#ADD8E6',
                '#FF5733',
                '#8A2BE2', '#F0E68C', '#20B2AA', '#DB7093', '#CCFF00', '#6B8E23', '#FF00FF', '#D8BFD8', '#FFA07A',
                '#FD6C9E',
                '#32CD32', '#800080', '#9932CC', '#4169E1', '#00FF7F', '#E6194B', '#40E0D0', '#FFB6C1', '#556B2F',
                '#708090'
            ];
            const bathUnit = `{{ __('chart.bath') }}`;
            return {
                series: [<?php echo $daily_chart_backup['total_amount']; ?>],
                labels: [<?php echo $daily_chart_backup['vendor_name']; ?>],
                colors: chartColors,
                chart: {
                    height: 520,
                    width: "100%",
                    type: "donut",
                },
                stroke: {
                    colors: ["transparent"],
                    lineCap: "",
                },
                responsive: [{
                    breakpoint: 490,
                    options: {
                        chart: {
                            width: 200
                        },
                        plotOptions: {
                            pie: {
                                customScale: 0.6,
                                donut: {
                                    labels: {
                                        show: true,
                                        name: {
                                            show: true,
                                            fontFamily: "Anuphan, sans-serif",
                                            offsetY: -160,
                                        },
                                        total: {
                                            showAlways: true,
                                            show: true,
                                            label: "Total",
                                            fontFamily: "Anuphan, sans-serif",
                                            fontSize: '18px',
                                            formatter: function(w) {
                                                const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                                return sum.toLocaleString() + bathUnit;
                                            },
                                        },
                                        value: {
                                            show: true,
                                            fontFamily: "Anuphan, sans-serif",
                                            offsetY: -130,

                                            formatter: function(value) {
                                                return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +
                                                    bathUnit;
                                            }
                                        },
                                    },
                                    size: "80%",
                                }
                            }
                        },
                        legend: {
                            position: 'bottom'
                        },
                        grid: {
                            padding: {
                                top: 100,
                            },
                        },
                    },

                }],
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontFamily: "Anuphan, sans-serif",
                                    offsetY: 20,
                                },
                                total: {
                                    showAlways: true,
                                    show: true,
                                    label: "Total",
                                    fontFamily: "Anuphan, sans-serif",
                                    fontSize: '18px',
                                    formatter: function(w) {
                                        const sum = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        return sum.toLocaleString() + bathUnit;
                                    },
                                },
                                value: {
                                    show: true,
                                    fontFamily: "Anuphan, sans-serif",
                                    offsetY: -20,

                                    formatter: function(value) {
                                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + bathUnit;
                                    }
                                },
                            },
                            size: "78%",
                        },

                        expandOnClick: true,
                    },
                },
                grid: {
                    padding: {
                        top: 5,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    fontFamily: "Anuphan, sans-serif",
                    position: "right",
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return value.toLocaleString() + bathUnit;
                        },
                    },
                },
            };
        }
    </script>
@endsection
