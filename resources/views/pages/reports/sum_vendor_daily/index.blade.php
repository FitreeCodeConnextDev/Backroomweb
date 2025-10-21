@extends('layouts.indexpage')
@section('title_page')
    {{ __('report.rpt_sum_debt_daily') }}
@endsection
@section('index-title')
    {{ __('report.rpt_sum_debt_daily') }}
@endsection
@section('table-section')
    <div class="mb-4">
        <div class="mb-4">
            <a href=" {{ route('report.index') }} ">
                <button type="button"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 me-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m11.25 9-3 3m0 0 3 3m-3-3h7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    {{ __('menu.button.back') }}
                </button>
            </a>
        </div>
        {{-- <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('report.rpt_sum_debt_daily') }}</h2> --}}

        {{-- <p class="text-sm text-gray-600 dark:text-gray-400">Click on the "View" link to open the report in a new tab.</p> --}}

        <div class=" max-w-screen-xl mt-5">
            <form action="#" method="post" target="_blank">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                    <div>
                        <label for="start_date" class="label_input"> {{ __('chart.start_date') }} </label>
                        <select name="start_date" class="input_text">
                            @foreach ($filters as $filter)
                                <option value="{{ $filter->batch }}">{{ date('d-m-Y', strtotime($filter->businessdate)) }}
                                    ({{ $filter->batch }}) </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="end_date" class="label_input"> {{ __('chart.end_date') }} </label>
                        <select name="end_date" class="input_text">
                            @foreach ($filters as $filter)
                                <option value="{{ $filter->batch }}">{{ date('d-m-Y', strtotime($filter->businessdate)) }}
                                    ({{ $filter->batch }}) </option>
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
                        <button class="submit_btn" type="submit">
                            {{ __('menu.button.confirm') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
