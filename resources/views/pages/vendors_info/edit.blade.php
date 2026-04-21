@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.vendor') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('vendor-page.show', $vendor_data->vendor_id) }}" class="first_bc_a">
        {{ __('vendor.vendor_show') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.vendor_edit') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.vendor_edit') }}
@endsection
@section('form-section')
    <form action="{{ route('vendor-page.update', $vendor_data->vendor_id) }}" id="vendor_form" method="post">
        @csrf
        @method('PUT')
        <div class="flex flex-row border border-gray-200 rounded-lg mt-3 ">
            <div class="grid grid-cols-1 lg:grid-cols-6 gap-3 p-7 w-full ">
                <div>
                    <label for="vendor_id" class="label_input"> {{ __('vendor.vendor_id') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="vendor_id" class="input_text" value="{{ $vendor_data->vendor_id }}" disabled>
                </div>
                <div>
                    <label for="branch_id" class="label_input">{{ __('vendor.branch_id') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="branch_id" name="branch_id" class="input_text"
                        value="{{ $vendor_data->branch_id }}" readonly>
                </div>
                <div>
                    <label for="term_id" class="label_input">{{ __('vendor.term_id') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    {{-- <input type="text" id="term_id" class="input_text" value="{{ $vendor_data->term_id }}"> --}}
                    <select name="term_id" id="term_id" class="input_text">
                        <option value="000000" @if ($vendor_data->term_id == 000000) selected @endif>000000</option>
                        @foreach ($terminal as $term_id)
                            <option value="{{ $term_id->term_id }}" @if ($vendor_data->term_id == $term_id->term_id) selected @endif>
                                {{ $term_id->term_id }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="term_seq" class="label_input"> {{ __('vendor.term_seq') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="number" id="term_seq" name="term_seq" class="input_text"
                        value="{{ $vendor_data->term_seq }}">
                </div>
                <div>
                    <label for="issuedate" class="label_input"> {{ __('vendor.issuedate') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="date" name="issuedate" id="issuedate" class="input_text"
                        value="{{ date('Y-m-d', strtotime($vendor_data->issuedate)) }}">
                </div>
                <div>
                    <label for="validdate" class="label_input"> {{ __('vendor.validdate') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="date" id="validdate" name="validdate" class="input_text"
                        value="{{ date('Y-m-d', strtotime($vendor_data->validdate)) }}">
                </div>
                <div>
                    <label for="vendor_name" class="label_input"> {{ __('vendor.vendor_name') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="vendor_name" name="vendor_name" class="input_text"
                        value="{{ $vendor_data->vendor_name }}">
                </div>
                <div>
                    <label for="vendor_food" class="label_input"> {{ __('vendor.vendor_food') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="vendor_food" name="vendor_food" class="input_text"
                        value="{{ $vendor_data->vendor_food }}">
                </div>
                <div>
                    <label for="vendor_subfood" class="label_input"> {{ __('vendor.vendor_subfood') }} </label>
                    <input type="text" id="vendor_subfood" name="vendor_subfood" class="input_text"
                        value="{{ $vendor_data->vendor_subfood }}">
                </div>
                <div>
                    <label for="ar_sap" class="label_input"> {{ __('vendor.ar_sap') }} </label>
                    <input type="number" id="ar_sap" name="ar_sap" class="input_text"
                        value="{{ $vendor_data->ar_sap }}">
                </div>
                <div>
                    <label for="vendorno" class="label_input"> {{ __('vendor.vendor_no') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="vendorno" name="vendorno" class="input_text"
                        value="{{ $vendor_data->vendorno }}">
                </div>
                <div>
                    <label for="productno" class="label_input"> {{ __('vendor.product_no') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="productno" name="productno" class="input_text"
                        value="{{ $vendor_data->productno }}">
                </div>
                <div>
                    <label for="pmino" class="label_input"> {{ __('vendor.pmino') }} </label>
                    <input type="text" id="pmino" name="pmino" class="input_text"
                        value="{{ $vendor_data->pmino }}">
                </div>
                <div>
                    <label for="taxbranch" class="label_input"> {{ __('vendor.taxbranch') }} </label>
                    <input type="text" id="taxbranch" name="taxbranch" class="input_text"
                        value="{{ $vendor_data->taxbranch }}">
                </div>
                <div>
                    <label for="owner_shop" class="label_input"> {{ __('vendor.owner_shop') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <select class="input_text" id="owner_shop" name="owner_shop">
                        {{-- <option value="N" @if ($vendor_data->owner_shop == ' ') selected @endif> </option> --}}
                        <option value="N" @if ($vendor_data->owner_shop == 'N') selected @endif>
                            {{ __('vendor.vendor_normal') }}</option>
                        <option value="Y" @if ($vendor_data->owner_shop == 'Y') selected @endif>
                            {{ __('vendor.vendor_center') }}</option>
                    </select>
                </div>
                <div>
                    <label for="vendor_locate" class="label_input"> {{ __('vendor.vendor_locate') }} </label>
                    <input type="text" id="vendor_locate" class="input_text" name="vendor_locate"
                        value="{{ $vendor_data->vendor_locate }}">
                </div>
                <div>
                    <label for="serialno" class="label_input"> {{ __('vendor.serial_no') }} </label>
                    <input type="text" id="serialno" name="serialno" class="input_text"
                        value="{{ $vendor_data->serialno }}">
                </div>
                <div>
                    <label for="ipaddress" class="label_input"> {{ __('vendor.ip_addr') }} </label>
                    <input type="text" id="ipaddress" name="ipaddress" class="input_text"
                        value="{{ $vendor_data->ipaddress }}">
                </div>
                <div>
                    <label for="txnno" class="label_input"> {{ __('vendor.txnno') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="txnno" name="txnno" class="input_text" readonly
                        value="{{ $vendor_data->txnno }}">
                </div>
                <div>
                    <label for="vendor_batchno" class="label_input"> {{ __('vendor.vendor_batchno') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="vendor_batchno" name="vendor_batchno" class="input_text" readonly
                        value="{{ $vendor_data->vendor_batchno }}">
                </div>
                <div>
                    <label for="billcount" class="label_input"> {{ __('vendor.vendor_billcount') }} <span
                            class="text-red-600 text-md">{{ __('menu.required_field') }}</span></label>
                    <input type="text" id="billcount" name="billcount" class="input_text" readonly
                        value="{{ $vendor_data->billcount }}">
                </div>
            </div>
        </div>
        <div class="mb-2">
            <button type="submit" class="submit_btn"> {{ __('menu.button.save') }} </button>
            <a href="{{ route('vendor-page.show', $vendor_data->vendor_id) }}">
                <button type="button" class="cancel_btn" onclick="back()"> {{ __('menu.button.cancel') }} </button>
            </a>
        </div>
    </form>
    {{-- @if ($errors->any())
        <div class="error_alert" role="alert">
            <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
        </div>
    @endif --}}
    <hr class=" mb-2 border-gray-200">
    <div class="">
        @include('pages.vendors_info.vendor_tabs')
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/vendor_tab.js'])
    <script src="/js/delet_sweet.js"></script>
    {{-- <script src="/js/vendor_tab.js"></script> --}}

    <script type="module">
        $('#vendor_form').validate({
            rules: {
                branch_id: "required",
                term_id: "required",
                term_seq: "required",
                issuedate: "required",
                validdate: "required",
                vendor_name: "required",
                vendor_food: "required",
                vendorno: "required",
                productno: "required",
                owner_shop: "required",
                txnno: "required",
                vendor_batchno: "required",
                billcount: "required",
            },
            messages: {
                branch_id: `{{ __('vendor.branch_id_required') }}`,
                term_id: `{{ __('vendor.term_id_required') }}`,
                term_seq: `{{ __('vendor.term_seq_required') }}`,
                issuedate: `{{ __('vendor.issuedate_required') }}`,
                validdate: `{{ __('vendor.validdate_required') }}`,
                vendor_name: `{{ __('vendor.vendor_name_required') }}`,
                vendor_food: `{{ __('vendor.vendor_food_required') }}`,
                vendorno: `{{ __('vendor.vendorno_required') }}`,
                productno: `{{ __('vendor.productno_required') }}`,
                owner_shop: `{{ __('vendor.owner_shop_required') }}`,
                txnno: `{{ __('vendor.txnno_required') }}`,
                vendor_batchno: `{{ __('vendor.vendor_batchno_required') }}`,
                billcount: `{{ __('vendor.vendor_billcount_required') }}`
            }
        });
    </script>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.del-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const itemId = this.getAttribute('data-item-id');
                    const itemName = this.getAttribute('data-name');
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
                        html: `{{ __('menu.deleted_text') }} <b>` + itemName + `</b>`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: `{{ __('menu.deleted_yes') }}`,
                        cancelButtonText: `{{ __('menu.deleted_no') }}`,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form to delete the item
                        }
                    });
                });
            });

        });

        document.addEventListener('DOMContentLoaded', function() {
            // เลือกทุกฟอร์มที่มีคลาส 'vendor_rabbit_form'
            const forms = document.querySelectorAll('.tabs_form');

            forms.forEach(function(form) {
                const saveButton = form.querySelector('.saveButton');

                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitForm(form, saveButton);
                });
            });

            function submitForm(form, saveButton) {
                // Disable submit button to prevent double submission
                saveButton.disabled = true;

                // Get form data
                const formData = new FormData(form);

                // Get the form action URL
                const url = form.getAttribute('action');

                // Show loading state
                saveButton.innerHTML = `{{ __('menu.is_saving') }}`;

                // Make Ajax request
                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Show success message without confirmButtonText
                            Swal.fire({
                                icon: 'success',
                                title: `{{ __('menu.is_success') }}`,
                                text: data.message || `{{ __('menu.is_saved') }}`,
                                showConfirmButton: false,
                                timer: 2000,
                            }).then(() => {
                                // Optionally reload page or update UI
                                window.location.reload();
                            });
                        } else {
                            throw new Error(data.message || `{{ __('menu.is_error') }}`);
                        }
                    })
                    .catch(error => {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: `{{ __('menu.is_failed') }}`,
                            text: error.message || `{{ __('menu.is_error') }}`,
                        });
                    })
                    .finally(() => {
                        // Re-enable submit button and restore original text
                        saveButton.disabled = false;
                        saveButton.innerHTML = document.querySelector('button.submit_btn').textContent;
                    });
            }
        });


        function back() {
            // localStorage.clear();
            window.history.back(); // ใช้ย้อนกลับไปยังหน้าก่อนหน้า
        }
    </script>
@endpush
