@extends('layouts.indexpage')
@section('title_page')
    {{ __('report.vendor_report') }}
@endsection
@section('index-title')
    {{ __('report.vendor_report') }}
@endsection
@section('table-section')
    <div class="mb-4">
        <div class=" max-w-screen mt-5">
            <form action="{{ route('report.generateVendorReport') }}" method="post" target="_blank">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="report" class="label_input"> {{ __('report.select_report') }} </label>
                        <select name="report_name" class="input_text" id="report_name">
                            @foreach ($report_name as $item)
                                @if ($item->report_config && Route::has($item->report_config))
                                    <option value="{{ $item->report_config }}">{{ $item->report_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="label_input"> {{ __('chart.start_date') }} </label>
                        <select name="start_date" class="input_text">
                            @foreach ($filters as $filter)
                                <option value="{{ $filter->batch }}">{{ date('d-m-Y', strtotime($filter->businessdate)) }}
                                    ({{ $filter->batch }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="end_date" class="label_input"> {{ __('chart.end_date') }} </label>
                        <select name="end_date" class="input_text">
                            @foreach ($filters as $filter)
                                <option value="{{ $filter->batch }}">{{ date('d-m-Y', strtotime($filter->businessdate)) }}
                                    ({{ $filter->batch }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div id="select_day" style="display: none">
                        <label for="type_date" class="label_input"> {{ __('report.select_report_date') }} </label>
                        <select name="type_date" class="input_text">
                            <option value="ALL_DAY">{{ __('report.rpt_allday') }}</option>
                            <option value="IN_DAY">{{ __('report.rpt_inday') }}</option>
                            <option value="CROSS_DAY">{{ __('report.rpt_crossday') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="format" class="label_input"> {{ __('report.select_format') }} </label>
                        <select name="format" class="input_text">
                            <option value="pdf">PDF</option>
                            <option value="xlsx">EXCEL</option>
                        </select>
                    </div>
                    <div class="mt-7">
                        <button type="submit" class="submit_btn">
                            {{ __('menu.button.confirm') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#report_name').on('change', function() {
                var reportConfig = $(this).val();
                if (reportConfig === 'report.vendor_daily_report') {
                    $('#select_day').show();
                } else {
                    $('#select_day').hide();
                }
            });
        });
    </script>
@endsection
