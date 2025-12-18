@extends('layouts.indexpage')
@section('title_page')
    {{ __('report.item_report') }}
@endsection
@section('index-title')
    {{ __('report.item_report') }}
@endsection

@section('table-section')
    <div class="mb-4">
        <div class=" max-w-screen mt-5">
            <form action="{{ route('report.toReportItem') }}" method="post">
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
                    <div>
                        <label for="format" class="label_input"> {{ __('report.select_format') }} </label>
                        <select name="format" class="input_text">
                            <option value="pdf">PDF</option>
                            <option value="xlsx">EXCEL</option>
                        </select>
                    </div>
                    <div class="mt-7">
                        <button type="submit" class="submit_btn" onclick="openReportWindow(event)">
                            {{ __('menu.button.confirm') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js-scripts')
    <script>
        function openReportWindow(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            const windowName = 'report_window_' + new Date().getTime();

            // Open a new window
            const newWindow = window.open('', windowName, 'width=900,height=700,resizable=yes,scrollbars=yes');

            if (newWindow) {
                newWindow.document.write('Please wait, generating report...');
                form.target = windowName;

                // Add a hidden input to indicate popup mode if it doesn't exist
                let input = form.querySelector('input[name="open_mode"]');
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'open_mode';
                    input.value = 'popup';
                    form.appendChild(input);
                }

                form.submit();
            } else {
                alert('Please allow popups for this website');
            }
        }
    </script>
@endsection
