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
                    <label for="vendor_id" class="label_input"> {{ __('vendor.vendor_id') }} </label>
                    <input type="text" id="vendor_id" class="input_text" value="{{ $vendor_data->vendor_id }}" disabled>
                </div>
                <div>
                    <label for="branch_id" class="label_input">{{ __('vendor.branch_id') }}</label>
                    <input type="text" id="branch_id" name="branch_id" class="input_text"
                        value="{{ $vendor_data->branch_id }}" readonly>
                </div>
                <div>
                    <label for="term_id" class="label_input">{{ __('vendor.term_id') }}</label>
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
                    <label for="term_seq" class="label_input"> {{ __('vendor.term_seq') }} </label>
                    <input type="text" id="term_seq" name="term_seq" class="input_text"
                        value="{{ $vendor_data->term_seq }}">
                </div>
                <div>
                    <label for="issuedate" class="label_input"> {{ __('vendor.issuedate') }} </label>
                    <input type="date" name="issuedate" id="issuedate" class="input_text"
                        value="{{ date('Y-m-d', strtotime($vendor_data->issuedate)) }}">
                </div>
                <div>
                    <label for="validdate" class="label_input"> {{ __('vendor.validdate') }} </label>
                    <input type="date" id="validdate" name="validdate" class="input_text"
                        value="{{ date('Y-m-d', strtotime($vendor_data->validdate)) }}">
                </div>
                <div>
                    <label for="vendor_name" class="label_input"> {{ __('vendor.vendor_name') }} </label>
                    <input type="text" id="vendor_name" name="vendor_name" class="input_text"
                        value="{{ $vendor_data->vendor_name }}">
                </div>
                <div>
                    <label for="vendor_food" class="label_input"> {{ __('vendor.vendor_food') }} </label>
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
                    <input type="text" id="ar_sap" name="ar_sap" class="input_text"
                        value="{{ $vendor_data->ar_sap }}">
                </div>
                <div>
                    <label for="vendorno" class="label_input"> {{ __('vendor.vendor_no') }} </label>
                    <input type="text" id="vendorno" name="vendorno" class="input_text"
                        value="{{ $vendor_data->vendorno }}">
                </div>
                <div>
                    <label for="productno" class="label_input"> {{ __('vendor.product_no') }} </label>
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
                    <label for="owner_shop" class="label_input"> {{ __('vendor.owner_shop') }} </label>
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
                    <label for="txnno" class="label_input"> {{ __('vendor.txnno') }} </label>
                    <input type="text" id="txnno" name="txnno" class="input_text"
                        value="{{ $vendor_data->txnno }}">
                </div>
                <div>
                    <label for="vendor_batchno" class="label_input"> {{ __('vendor.vendor_batchno') }} </label>
                    <input type="text" id="vendor_batchno" name="vendor_batchno" class="input_text"
                        value="{{ $vendor_data->vendor_batchno }}">
                </div>
                <div>
                    <label for="billcount" class="label_input"> {{ __('vendor.vendor_billcount') }} </label>
                    <input type="text" id="billcount" name="billcount" class="input_text"
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
        <div class="tab_div">
            <ul class="tab_ul" id="default-tab" data-tabs-toggle="#default-tab-content"
                data-tabs-active-classes="tab_active" data-tabs-inactive-classes="tab_inactive" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="tab_button" id="vendor_product_tab" data-tabs-target="#vendor_product" type="button"
                        role="tab" aria-controls="vendor_product" aria-selected="false">
                        {{ __('vendor.vendor_product') }} </button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vendor_user_tab"
                        data-tabs-target="#vendor_user" type="button" role="tab" aria-controls="vendor_user"
                        aria-selected="false">{{ __('vendor.vendor_user') }}</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vendor_def_tab"
                        data-tabs-target="#vendor_def" type="button" role="tab" aria-controls="vendor_def"
                        aria-selected="false"> {{ __('vendor.vendor_default') }} </button>
                </li>
                <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vendor_stock_tab"
                        data-tabs-target="#vendor_stock" type="button" role="tab" aria-controls="vendor_stock"
                        aria-selected="false"> {{ __('vendor.stock_info') }} </button>
                </li>
                <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vendor_promo_tab"
                        data-tabs-target="#vendor_promo_dis" type="button" role="tab"
                        aria-controls="vendor_promo_dis" aria-selected="false"> {{ __('vendor.vendor_promo_dis') }}
                    </button>
                </li>
                <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vendor_invoice_tab"
                        data-tabs-target="#vendor_invoice" type="button" role="tab" aria-controls="vendor_invoice"
                        aria-selected="false"> {{ __('vendor.vendor_invoice') }} </button>
                </li>
                <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vendor_rabbit"
                        data-tabs-target="#vendor_rab" type="button" role="tab" aria-controls="vendor_rab"
                        aria-selected="false"> {{ __('vendor.vendor_rabbit') }} </button>
                </li>
                <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vendor_linepay"
                        data-tabs-target="#vendor_line" type="button" role="tab" aria-controls="vendor_line"
                        aria-selected="false"> {{ __('vendor.vendor_linepay') }} </button>
                </li>
                <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vender_gp_tab"
                        data-tabs-target="#vendor_gp" type="button" role="tab" aria-controls="vendor_gp"
                        aria-selected="false"> {{ __('vendor.vendor_gp') }} </button>
                </li>
                <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="vender_garantee_tab"
                        data-tabs-target="#vendor_garantee" type="button" role="tab"
                        aria-controls="vendor_garantee" aria-selected="false"> {{ __('vendor.vendor_garantee_title') }}
                    </button>
                </li>
                {{-- <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="contacts-tab"
                        data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts"
                        aria-selected="false">Contacts</button>
                </li> --}}
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg " id="vendor_product" role="tabpanel"
                aria-labelledby="vendor_product_tab">
                @include('pages.vendors.vendor_product.edit', [
                    'vendor_id' => $vendor_data->vendor_id,
                    'branch_id' => $vendor_data->branch_id,
                    'term_id' => $vendor_data->term_id,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_user" role="tabpanel" aria-labelledby="vendor_user_tab">

                @include('pages.vendors.vendor_user.edit', [
                    'vendor_data' => $vendor_data,
                    'vendor_id' => $vendor_data->vendor_id,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_def" role="tabpanel" aria-labelledby="vendor_def_tab">
                @include('pages.vendors.vendor_def.edit', [
                    'vendor_id' => $vendor_data->vendor_id,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_stock" role="tabpanel" aria-labelledby="vendor_stock_tab">
                @include('pages.vendors.vendor_stock.index', [
                    'vendor_id' => $vendor_data->vendor_id,
                    'vendor_name' => $vendor_data->vendor_name,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_promo_dis" role="tabpanel"
                aria-labelledby="vendor_promo_tab">
                @include('pages.vendors.promo_discout.edit', [
                    'vendor_id' => $vendor_data->vendor_id,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_invoice" role="tabpanel"
                aria-labelledby="vendor_invoice_tab">
                @include('pages.vendors.vendor_invoince.edit', [
                    'vendor_id' => $vendor_data->vendor_id,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_rab" role="tabpanel" aria-labelledby="vendor_rabbit">
                @include('pages.vendors.vendor_rabbit.edit', [
                    'vendor_id' => $vendor_data->vendor_id,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_line" role="tabpanel" aria-labelledby="vendor_linepay">
                @include('pages.vendors.vendor_linepay.edit', [
                    'vendor_id' => $vendor_data->vendor_id,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_gp" role="tabpanel" aria-labelledby="vendor_gp_tab">
                @include('pages.vendors.vendor_gp.edit', [
                    'vendor_id' => $vendor_data->vendor_id,
                ])
            </div>
            <div class="hidden p-4 rounded-lg " id="vendor_garantee" role="tabpanel"
                aria-labelledby="vendor_garantee_tab">
                @include('pages.vendors.vendor_garantee.edit', [
                    'vendor_id' => $vendor_data->vendor_id,
                ])
            </div>
            {{-- <div class="hidden p-4 rounded-lg " id="contacts" role="tabpanel" aria-labelledby="contacts-tab"> </div> --}}
        </div>
    </div>
@endsection
@section('js-scripts')
    @vite(['resources/js/vendor_tab.js'])
    <script src="/js/delet_sweet.js"></script>
    <script src="/js/vendor_tab.js"></script>

    <script>
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
    </script>
@endsection
