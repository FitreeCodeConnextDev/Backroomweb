@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.coupons_edit') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('coupons.index') }}" class="first_bc_a">
        {{ __('menu.coupons') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.coupons_edit') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.coupons_edit') }}
@endsection
@section('form-section')
    <form action="{{ route('coupons.update', $coupons->coupon_id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-4 mt-3">
            <div>
                <label for="coupon_id" class="label_input">{{ __('coupon.coupon_id') }}</label>
                <input type="text" name="coupon_id" id="coupon_id" class="input_text" value="{{ $coupons->coupon_id }}"
                    readonly>
                @error('coupon_id')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="coupon_promo_code" class="label_input">{{ __('coupon.coupon_promo_code') }}</label>
                <select name="coupon_promo_code" id="coupon_promo_code" class="input_text">
                    <option value="">{{ __('coupon.select_coupon_promo_code') }}</option>
                    @foreach ($promo_code as $promo)
                        <option value="{{ $promo->promo_code }}" @if ($promo->promo_code == $coupons->promo_code) selected @endif>
                            {{ $promo->promo_desc }}</option>
                    @endforeach
                </select>

            </div>
            <div>
                <label for="coupon_name" class="label_input">{{ __('coupon.coupon_name') }}</label>
                <input type="text" name="coupon_name" id="coupon_name" class="input_text"
                    value=" {{ $coupons->coupon_name }} " required>
                @error('coupon_name')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-4 ">
                    <div>
                        <label for="start_date" class="label_input">{{ __('coupon.coupon_start_date') }}</label>
                        <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="start_date" name="start_date"
                            class="input_text" value="{{ date('Y-m-d', strtotime($coupons->start_date)) }}" />
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                                </span>
                                {{ $message }} </p>
                        @enderror
                    </div>
                    <div>
                        <label for="valid_date" class="label_input">{{ __('coupon.coupon_valid_date') }}</label>
                        <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="valid_date" name="valid_date"
                            class="input_text" value="{{ date('Y-m-d', strtotime($coupons->valid_date)) }}" />
                        @error('valid_date')
                            <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                                </span>
                                {{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div>
                <label for="coupon_countday" class="label_input">{{ __('coupon.coupon_countday') }}</label>
                <input type="text" name="coupon_countday" id="coupon_countday" class="input_text"
                    value="{{ $coupons->coupon_countday }}" placeholder="{{ __('coupon.coupon_countday') }}">
                @error('coupon_countday')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="coupon_countall" class="label_input">{{ __('coupon.coupon_countall') }}</label>
                <input type="text" name="coupon_countall" id="coupon_countall" class="input_text"
                    value="{{ $coupons->coupon_countall }} " placeholder="{{ __('coupon.coupon_countall') }}">
                @error('coupon_countall')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <div class="grid grid-cols-1 gap-4 mt-2">
                    <div class="flex space-x-3 lg:mt-5 mt-3">
                        <div>
                            <input type="hidden" name="coupon_limit" id="default-checkbox" value="N">
                            <input id="coupon_limit" name="coupon_limit" type="checkbox" value="Y"
                                @if ($coupons->coupon_limit == 'Y') checked @endif class="checkbox_input">
                            <label for="coupon_limit" class="label_checkbox"> {{ __('coupon.coupon_limit') }} </label>
                        </div>
                        <div>
                            <input type="text" class="input_text" name="coupon_limitqty" id="coupon_limitqty"
                                value=" {{ $coupons->coupon_limitqty }} ">
                            @error('coupon_limitqty')
                                <p class="mt-2 text-sm text-red-600"><span class=" font-medium">
                                        {{ __(__('menu.is_warning')) }}
                                    </span>
                                    {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex space-x-3 lg:mt-5 mt-3">
                        <div>
                            <input type="hidden" name="coupon_limitall" id="default-checkbox" value="N">
                            <input id="coupon_limitall" name="coupon_limitall" type="checkbox" value="Y"
                                @if ($coupons->coupon_limitall == 'Y') checked @endif class="checkbox_input">
                            <label for="coupon_limitall" class="label_checkbox"> {{ __('coupon.coupon_limit_all') }}
                            </label>

                        </div>
                        <div>
                            <input type="text" class="input_text" name="coupon_limitallqty" id="coupon_limitallqty"
                                value="{{ $coupons->coupon_limitallqty }}">
                            @error('coupon_limitallqty')
                                <p class="mt-2 text-sm text-red-600"><span class=" font-medium">
                                        {{ __(__('menu.is_warning')) }}
                                    </span>
                                    {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex space-x-3 lg:mt-5 mt-3">
                        <div>
                            <input type="hidden" name="print_tax" id="default-checkbox" value="N">
                            <input id="print_tax" name="print_tax" type="checkbox" value="Y"
                                @if ($coupons->print_tax == 'Y') checked @endif class="checkbox_input">
                            <label for="print_tax" class="label_checkbox"> {{ __('coupon.print_tax') }}
                            </label>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
            <a href="{{ route('coupons.index') }}">
                <button type="button" class="cancel_btn">
                    {{ __('menu.button.cancel') }}
                </button>
            </a>
        </div>

    </form>
    <div class="relative overflow-x-auto rounded-lg border border-gray-300 mt-5">
        <div class=" p-5 ">
            <div class="flex justify-between my-3">
                <div>
                    <button data-modal-target="coupon-modal" data-modal-toggle="coupon-modal" class="modal_button_add"
                        type="button">
                        {{ __('menu.button.add') }}
                    </button>
                </div>
                <div class="flex space-x-3">
                    <div>
                        <button id="exportButton" onclick="exportTableToCSV()" class="excel_button" title="Export CSV">
                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="6"
                                height="6" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                            </svg>
                        </button>
                    </div>
                    <div>
                        <form action="{{ route('coupon_lockall', $coupons->coupon_id) }}" method="post"
                            id="lockall_button_form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="coupon_lock" value="Y">
                            <input type="hidden" name="coupon_id" value="{{ $coupons->coupon_id }}">
                            <button type="submit" class="lockall-button" id="lock_button">Lock All</button>
                        </form>
                    </div>
                    <div>
                        <form action="{{ route('coupon_lockall', $coupons->coupon_id) }}" method="post"
                            id="unlockall_button_form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="coupon_lock" value="N">
                            <input type="hidden" name="coupon_id" value="{{ $coupons->coupon_id }}">
                            <button type="submit" class="lockall-button" id="unlock_button">Unlock All</button>
                        </form>
                    </div>
                </div>
            </div>

            <table class="table-data" id="coupons-table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('coupon.coupon_no') }}</th>
                        <th scope="col">{{ __('coupon.coupon_amout') }}</th>
                        <th scope="col">{{ __('coupon.coupon_start_date') }}</th>
                        <th scope="col">{{ __('coupon.coupon_valid_date') }}</th>
                        <th scope="col">{{ __('coupon.coupon_lock') }}</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons_detail as $detail_item)
                        <tr>
                            <td> {{ $detail_item->coupon_no }} </td>
                            <td> {{ number_format($detail_item->amount, 2) }} </td>
                            <td> {{ date('d-m-Y', strtotime($detail_item->start_date)) }} </td>
                            <td> {{ date('d-m-Y', strtotime($detail_item->valid_date)) }} </td>
                            <td> {{ $detail_item->coupon_lock == 'Y' ? 'Y' : 'N' }} </td>
                            <td>
                                <div class="flex space-x-3">
                                    <div>
                                        @if ($detail_item->coupon_lock == 'Y')
                                            <form action="{{ route('coupon_detail_lock', $detail_item->coupon_no) }}"
                                                method="post" id="lock_button_form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="coupon_lock" value="N">
                                                <button type="submit" class="lock-button" id="lock_button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-[16px] h-[16px]">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('coupon_detail_lock', $detail_item->coupon_no) }}"
                                                method="post" id="lock_button_form">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="coupon_lock" value="Y">
                                                <button type="submit" class="lock-button" id="lock_button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-[16px] h-[16px]">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    <div>
                                        <form
                                            action="{{ route('coupon_detail_destroy', [$detail_item->coupon_no, $detail_item->coupon_id]) }}"
                                            method="post" id="delete-form-{{ $detail_item->coupon_no }}">
                                            @csrf
                                            @method('PUT')
                                            <button id="del-button" class="del-button"
                                                data-item-id="{{ $detail_item->coupon_no }}"
                                                data-name="{{ $detail_item->coupon_no }}">
                                                <svg class="w-[16px] h-[16px]" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.6"
                                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div id="coupon-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-200 rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ __('menu.button.add') }}{{ __('menu.coupons') }}
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="coupon-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <form id="coupon_modal" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="coupon_id" value="{{ $coupons->coupon_id }}">
                        <input type="hidden" name="start_date" id="start_date"
                            value="{{ date('Y-m-d', strtotime($coupons->start_date)) }}">
                        <input type="hidden" name="valid_date" id="valid_date"
                            value="{{ date('Y-m-d', strtotime($coupons->valid_date)) }}">

                        <div class="grid gap-4 mb-3">
                            <!-- Single Coupon Section -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center space-x-4 mb-3">
                                    <div class="flex items-center">
                                        <input id="couponcheck1" name="couponcheck" value="0" type="radio"
                                            class="radio_input" checked>
                                        <label for="couponcheck1"
                                            class="label_checkbox ml-2">{{ __('coupon.coupon_no') }}</label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <input type="text" name="coupon_no" class="input_text w-full" id="coupon_no"
                                            value=" " disabled required>
                                    </div>
                                    <div>
                                        <input type="number" name="coupon_no_num1" class="input_text w-full"
                                            id="coupon_no_num1" value=" " disabled required>
                                    </div>
                                    <div>
                                        <input type="number" name="amount1" class="input_text w-full" id="amount1"
                                            value=" " disabled required>
                                    </div>
                                </div>
                            </div>

                            <!-- Multiple Coupons Section -->
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center space-x-4 mb-3">
                                    <div class="flex items-center">
                                        <input id="couponcheck2" name="couponcheck" value="1" type="radio"
                                            class="radio_input">
                                        <label for="couponcheck2" class="label_checkbox ml-2">
                                            {{ __('coupon.coupon_no') }} {{ __('coupon.coupon_start_date') }} /
                                            {{ __('coupon.end_coupon') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <input type="number" name="coupon_no_start" class="input_text w-full"
                                            id="coupon_no_start" value=" " disabled>
                                    </div>
                                    <div>
                                        <input type="number" name="coupon_no_end" class="input_text w-full"
                                            id="coupon_no_end" value=" " disabled>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="coupon_no_num2"
                                            class="label_checkbox block mb-2">{{ __('coupon.coupon_name') }}</label>
                                        <input type="text" name="coupon_no_num2" class="input_text w-full"
                                            id="coupon_no_num2" value=" " disabled>
                                    </div>
                                    <div>
                                        <label for="amount2"
                                            class="label_checkbox block mb-2">{{ __('coupon.coupon_amout') }}</label>
                                        <input type="text" name="amount2" class="input_text w-full" id="amount2"
                                            value=" " disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center justify-end p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button id="saveButton" class="submit_btn">{{ __('menu.button.save') }}</button>
                            <button type="button" class="modal_button_cancel"
                                data-modal-hide="coupon-modal">{{ __('menu.button.cancel') }}</button>
                        </div>

                        @if ($errors->any())
                            <div class="error_alert" role="alert">
                                <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = document.querySelector("#coupons-table");
            if (table) {
                new DataTable(table, {
                    searchable: true,
                    sortable: true,
                    perPage: 5,
                    perPageSelect: [5, 10, 20, 'All']
                });
            }
            document.addEventListener('click', function(e) {
                const button = e.target.closest('.del-button');
                if (button) {
                    e.preventDefault();
                    const itemId = button.getAttribute('data-item-id');
                    const itemName = button.getAttribute('data-name');
                    const form = document.getElementById(`delete-form-${itemId}`);

                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: "alert_confirm_btn",
                            cancelButton: "alert_cancel_btn"
                        },
                        buttonsStyling: false
                    });

                    swalWithBootstrapButtons.fire({
                        title: `{{ __('menu.deleted_title') }}`,
                        html: `{{ __('menu.deleted_text') }} <b>${itemName}</b>`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: `{{ __('menu.deleted_yes') }}`,
                        cancelButtonText: `{{ __('menu.deleted_no') }}`,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });

        // Function to export table data to CSV
        function exportTableToCSV() {
            const table = document.getElementById('coupons-table');
            const headers = Array.from(table.querySelectorAll('thead th')).slice(0, 4); // Get first 4 headers
            const rows = table.querySelectorAll('tbody tr');

            // Add BOM for UTF-8
            let csvContent = '\ufeff';

            // Add headers
            csvContent += headers.map(header => {
                // Wrap headers in quotes to handle special characters
                return `"${header.textContent.trim()}"`;
            }).join(',') + '\n';

            // Add data rows
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = Array.from(cells).slice(0, 4).map((cell, index) => {
                    let cellContent = cell.textContent.trim();

                    // Format amount column (index 1) as float with 2 decimal places
                    if (index === 1) {
                        // Remove any non-numeric characters except decimal point
                        cellContent = cellContent.replace(/[^\d.-]/g, '');
                        // Convert to float and format
                        const num = parseFloat(cellContent);
                        cellContent = isNaN(num) ? '0.00' : num.toFixed(2);
                    }

                    // Wrap content in quotes if it contains commas or special characters
                    if (cellContent.includes(',') || cellContent.includes('"') || cellContent.includes(
                            '\n')) {
                        cellContent = `"${cellContent.replace(/"/g, '""')}"`;
                    }
                    return cellContent;
                });
                csvContent += rowData.join(',') + '\n';
            });

            // Create and trigger download with UTF-8 encoding
            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8'
            });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', 'coupons_export.csv');
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        const CouponCheck1 = document.getElementById('couponcheck1');
        const CouponCheck2 = document.getElementById('couponcheck2');
        const CouponNo = document.getElementById('coupon_no');
        const CouponNoStart = document.getElementById('coupon_no_start');
        const CouponNoEnd = document.getElementById('coupon_no_end');
        const Amount1 = document.getElementById('amount1');
        const Amount2 = document.getElementById('amount2');
        const CouponNoNum1 = document.getElementById('coupon_no_num1');
        const CouponNoNum2 = document.getElementById('coupon_no_num2');

        function radioCheck() {
            // Disable all fields by default
            CouponNo.disabled = true;
            CouponNo.required = true;
            CouponNoNum1.disabled = true;
            CouponNoNum1.required = true;
            Amount1.disabled = true;
            Amount1.required = true;
            CouponNoStart.disabled = true;
            CouponNoStart.required = true;
            CouponNoEnd.disabled = true;
            CouponNoEnd.required = true;
            CouponNoNum2.disabled = true;
            CouponNoNum2.required = true;
            Amount2.disabled = true;
            Amount2.required = true;

            // Check which radio is selected and enable corresponding fields
            if (CouponCheck1.checked) {
                CouponNo.disabled = false;
                CouponNo.required = true;
                CouponNoNum1.disabled = false;
                CouponNoNum1.required = true;
                Amount1.disabled = false;
                Amount1.required = true;

                CouponNoStart.value = ' ';
                CouponNoEnd.value = ' ';
                CouponNoNum2.value = ' ';
                Amount2.value = ' ';

            } else if (CouponCheck2.checked) {
                CouponNoStart.disabled = false;
                CouponNoStart.required = true;
                CouponNoEnd.disabled = false;
                CouponNoNum2.disabled = false;
                CouponNoNum2.required = true;
                Amount2.disabled = false;
                Amount2.required = true;

                CouponNo.value = ' ';
                CouponNoNum1.value = ' ';
                Amount1.value = ' ';
            }
        }

        // Add event listeners for radio buttons
        CouponCheck1.addEventListener('change', radioCheck);
        CouponCheck2.addEventListener('change', radioCheck);

        // Call function initially to set the correct state
        radioCheck();
    </script>
    <script type="module">
        $(document).ready(function() {
            // เมื่อคลิกปุ่มที่มี id="saveButton"
            $('#saveButton').on('click', function(e) {
                e.preventDefault(); // หยุดการทำงานของ submit แบบปกติ

                // ใช้ FormData เพื่อจับข้อมูลจากฟอร์ม
                var formData = new FormData($('#coupon_modal')[0]);

                // ส่งข้อมูลไปยัง Route ที่กำหนดโดยใช้ Ajax
                $.ajax({
                    url: '{{ route('coupon_detail_insert') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Loading...',
                            html: 'โปรดรอสักครู่...',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                text: response.message,
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000,
                            });

                            $('#coupon_modal').addClass('hidden');
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        let errorMessage = '';

                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            const errorList = Object.entries(xhr.responseJSON.errors)
                                .map(([field, messages]) => `<li>${messages.join(', ')}</li>`)
                                .join('');
                            errorMessage = `<ul>${errorList}</ul>`;
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else {
                            errorMessage = `{{ __('menu.is_failed') }}`;
                        }

                        Swal.fire({
                            title: `{{ __('menu.save_is_failed') }}`,
                            html: errorMessage,
                            icon: 'error',
                            confirmButtonText: `{{ __('menu.button.confirm') }}`
                        });
                    }
                });
            });

            // ปิด Modal เมื่อคลิกปุ่มปิด
            $('[data-modal-hide="vedor_product_info"]').on('click', function() {
                $('#vedor_product_info').addClass('hidden');
            });
        });
    </script>
@endsection
