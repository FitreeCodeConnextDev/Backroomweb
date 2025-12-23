@extends('layouts.createpage')
@section('title_page')
    {{ __('expense_vendor.expense_vendor_title') }}
@endsection
@section('breadcrumb-index')
    <a href="#" class="first_bc_a">
        {{ __('expense_vendor.expense_vendor_title') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('expense_vendor.expense_vendor_add') }}
    </a>
@endsection
@section('page_title')
    {{ __('expense_vendor.expense_vendor_add') }}
@endsection
@section('form-section')
    <form id="expensevendor_other" action="{{ route('expensevendor_other_store') }}" method="post">
        @csrf
        <div class="grid_page">
            <div>
                <label for="txnyear" class="label_input"> {{ __('expense_vendor.txnyear') }} </label>
                <select name="txnyear" id="txnyear" class="input_text">
                    @php
                        $currentYear = date('Y');
                        $startYear = $currentYear; // Adjust range as needed
                        $endYear = $currentYear + 10; // Adjust range as needed
                    @endphp
                    @for ($year = $startYear; $year <= $endYear; $year++)
                        <option value="{{ $year }}" {{ $year == $currentYear ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
                @error('txnyear')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="txnmonth" class="label_input"> {{ __('expense_vendor.txnmonth') }} </label>
                <select name="txnmonth" id="txnmonth" class="input_text">
                    @for ($month = 1; $month <= 12; $month++)
                        <option value="{{ date('m', mktime(0, 0, 0, $month, 1)) }}"
                            {{ $month == $currentMonth ? 'selected' : '' }}>
                            {{ $thaiMonths[$month] }}
                        </option>
                    @endfor

                </select>
                @error('txnmonth')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="txndate" class="label_input"> {{ __('expense_vendor.txndate') }} </label>
                <input type="date" name="txndate" id="txndate" class="input_text">
                @error('txndate')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="duedate" class="label_input"> {{ __('expense_vendor.duedate') }} </label>
                <input type="date" name="duedate" id="duedate" class="input_text">
                @error('duedate')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="vendor_id" class="label_input">{{ __('expense_vendor.vendor_id_desc') }}</label>
                <select name="vendor_id" id="vendor_id" class="input_text">
                    <option value="" selected disabled>{{ __('expense_vendor.select_vendor') }}</option>
                    @foreach ($vendor_info as $vendor)
                        <option value="{{ $vendor->vendor_id }}">{{ $vendor->vendor_name }}</option>
                    @endforeach
                </select>
                @error('vendor_id')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="exp_code" class="label_input"> {{ __('expense_vendor.exp_code_desc') }} </label>
                <select name="exp_code" id="exp_code" class="input_text">
                    <option value="" selected disabled>{{ __('expense_vendor.select_exp_code') }}</option>
                    @foreach ($expense_vendor as $expense)
                        <option value="{{ $expense->exp_code }}">{{ $expense->description }}</option>
                    @endforeach
                </select>
                @error('exp_code')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="start_date" class="label_input"> {{ __('expense_vendor.start_date') }} </label>
                <input type="date" name="start_date" id="start_date" class="input_text">
                @error('start_date')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="label_input"> {{ __('expense_vendor.end_date') }} </label>
                <input type="date" name="end_date" id="end_date" class="input_text">
                @error('end_date')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="start_no" class="label_input"> {{ __('expense_vendor.start_no') }} </label>
                <input type="number" name="start_no" id="start_no" step="0.01" class="input_text">
                @error('start_no')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="end_no" class="label_input"> {{ __('expense_vendor.end_no') }} </label>
                <input type="number" name="end_no" id="end_no" step="0.01" class="input_text">
                @error('end_no')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="price_rate" class="label_input"> {{ __('expense_vendor.price_rate_desc') }} </label>
                <input type="number" name="price_rate" id="price_rate" step="0.01" class="input_text">
                @error('price_rate')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="total" class="label_input"> {{ __('expense_vendor.total') }} </label>
                <input type="number" name="total" id="total" step="0.01" class="input_text">
                @error('total')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
        </div>
        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
    </form>
    <section class="border-gray-400 border-t py-3">
        <div class="tab_div">
            <ul class="tab_ul-2" id="default-tab" data-tabs-toggle="#expense_vendor" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-base" id="expense_vendor_tabs"
                        data-tabs-target="#expense_vendor_tab1" type="button" role="tab" aria-controls="expense_vendor_tab1"
                        aria-selected="false">{{ __('stock.stock_tab1') }}</button>
                </li>
            </ul>
        </div>
        <div id="expense_vendor">
            <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="expense_vendor_tab1" role="tabpanel"
                aria-labelledby="expense_vendor_tabs">
                @include('pages.expensevendor_other.tabs.table')
            </div>
        </div>
    </section>
@endsection
@section('js-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const expenseSelect = document.getElementById('exp_code');
            expenseSelect.addEventListener('change', function(event) {
                const selectedExpCode = event.target.value;
                fetch(`/get-expense-details/${selectedExpCode}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.price_rate) {
                            document.getElementById('price_rate').value = data.price_rate;
                        } else {
                            document.getElementById('price_rate').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching expense details:', error);
                    });
            });
        });
    </script>
@endsection
