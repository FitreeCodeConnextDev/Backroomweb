@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.vendor') }}
@endsection
@section('breadcrumb-index')
    <a onclick="back()" class="first_bc_a">
        {{ __('menu.vendor') }}
    </a>
@endsection

@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('vendor.vendor_show') }}
    </a>
@endsection

@section('page_title')
    {{ __('vendor.vendor_show') }}
@endsection
@section('form-section')
    <form action="">
        <div class="flex flex-row border border-gray-200 rounded-lg mt-3 ">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3 p-7 w-full ">
                <div>
                    <label for="vendor_id" class="label_input"> {{ __('vendor.vendor_id') }} </label>
                    <input type="text" id="vendor_id" class="input_text" value="{{ $vendor_data->vendor_id }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="branch_id" class="label_input">{{ __('vendor.branch_id') }}</label>
                    <input type="text" id="branch_id" class="input_text" value="{{ $vendor_data->branch_id }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="term_id" class="label_input">{{ __('vendor.term_id') }}</label>
                    <input type="text" id="term_id" class="input_text" value="{{ $vendor_data->term_id }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="term_seq" class="label_input"> {{ __('vendor.term_seq') }} </label>
                    <input type="text" id="term_seq" class="input_text" value="{{ $vendor_data->term_seq }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="issuedate" class="label_input"> {{ __('vendor.issuedate') }} </label>
                    <input type="text" id="issuedate" class="input_text"
                        value="{{ date('d-m-Y', strtotime($vendor_data->issuedate)) }}" disabled readonly>
                </div>
                <div>
                    <label for="validdate" class="label_input"> {{ __('vendor.validdate') }} </label>
                    <input type="text" id="validdate" class="input_text"
                        value="{{ date('d-m-Y', strtotime($vendor_data->validdate)) }}" disabled readonly>
                </div>
                <div>
                    <label for="vendor_name" class="label_input"> {{ __('vendor.vendor_name') }} </label>
                    <input type="text" id="vendor_name" class="input_text" value="{{ $vendor_data->vendor_name }}"
                        disabled readonly>
                </div>
                <div>
                    <label for="vendor_food" class="label_input"> {{ __('vendor.vendor_food') }} </label>
                    <input type="text" id="vendor_food" class="input_text" value="{{ $vendor_data->vendor_food }}"
                        disabled readonly>
                </div>
                <div>
                    <label for="vendor_subfood" class="label_input"> {{ __('vendor.vendor_subfood') }} </label>
                    <input type="text" id="vendor_subfood" class="input_text" value="{{ $vendor_data->vendor_subfood }}"
                        disabled readonly>
                </div>
                <div>
                    <label for="ar_sap" class="label_input"> {{ __('vendor.ar_sap') }} </label>
                    <input type="text" id="ar_sap" class="input_text" value="{{ $vendor_data->ar_sap }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="vendorno" class="label_input"> {{ __('vendor.vendor_no') }} </label>
                    <input type="text" id="vendorno" class="input_text" value="{{ $vendor_data->vendorno }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="productno" class="label_input"> {{ __('vendor.product_no') }} </label>
                    <input type="text" id="productno" class="input_text" value="{{ $vendor_data->productno }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="pmino" class="label_input"> {{ __('vendor.pmino') }} </label>
                    <input type="text" id="pmino" class="input_text" value="{{ $vendor_data->pmino }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="taxbranch" class="label_input"> {{ __('vendor.taxbranch') }} </label>
                    <input type="text" id="taxbranch" class="input_text" value="{{ $vendor_data->taxbranch }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="owner_shop" class="label_input"> {{ __('vendor.owner_shop') }} </label>
                    <select class="input_text" id="owner_shop" disabled>
                        <option value="N" @if ($vendor_data->owner_shop == ' ') selected @endif> </option>
                        <option value="N" @if ($vendor_data->owner_shop == 'N') selected @endif>
                            {{ __('vendor.vendor_normal') }}</option>
                        <option value="Y" @if ($vendor_data->owner_shop == 'Y') selected @endif>
                            {{ __('vendor.vendor_center') }}</option>
                    </select>
                </div>
                <div>
                    <label for="vendor_locate" class="label_input"> {{ __('vendor.vendor_locate') }} </label>
                    <input type="text" id="vendor_locate" class="input_text"
                        value="{{ $vendor_data->vendor_locate }}" disabled readonly>
                </div>
                <div>
                    <label for="serialno" class="label_input"> {{ __('vendor.serial_no') }} </label>
                    <input type="text" id="serialno" class="input_text" value="{{ $vendor_data->serialno }}"
                        disabled readonly>
                </div>
                <div>
                    <label for="ipaddress" class="label_input"> {{ __('vendor.ip_addr') }} </label>
                    <input type="text" id="ipaddress" class="input_text" value="{{ $vendor_data->ipaddress }}"
                        disabled readonly>
                </div>
                <div>
                    <label for="txnno" class="label_input"> {{ __('vendor.txnno') }} </label>
                    <input type="text" id="txnno" class="input_text" value="{{ $vendor_data->txnno }}" disabled
                        readonly>
                </div>
                <div>
                    <label for="vendor_batchno" class="label_input"> {{ __('vendor.vendor_batchno') }} </label>
                    <input type="text" id="vendor_batchno" class="input_text"
                        value="{{ $vendor_data->vendor_batchno }}" disabled readonly>
                </div>
                <div>
                    <label for="billcount" class="label_input"> {{ __('vendor.vendor_billcount') }} </label>
                    <input type="text" id="billcount" class="input_text" value="{{ $vendor_data->billcount }}"
                        disabled readonly>
                </div>
            </div>
        </div>

        <div class=" mb-2">
            <a href=" {{ route('vendor-page.edit', $vendor_data->vendor_id) }} ">
                <button type="button" class="submit_btn"> {{ __('menu.button.edit') }}
                </button>
            </a>
            <a href="{{ route('vendor-page.index') }}">
                <button type="button" class="cancel_btn" onclick="clear_button()"> {{ __('menu.button.back') }}
                </button>
            </a>
        </div>

    </form>
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
                        data-tabs-target="#vendor_garantee" type="button" role="tab" aria-controls="vendor_garantee"
                        aria-selected="false"> {{ __('vendor.vendor_garantee_title') }} </button>
                </li>
                {{-- <li role="presentation">
                    <button class="tab_button hover:text-gray-600 hover:border-gray-300 " id="contacts-tab"
                        data-tabs-target="#contacts" type="button" role="tab" aria-controls="contacts"
                        aria-selected="false">Contacts</button>
                </li> --}}
            </ul>
        </div>
    </div>
    <div id="default-tab-content">
        <div class="hidden p-4 rounded-lg " id="vendor_product" role="tabpanel" aria-labelledby="vendor_product_tab">
            @include('pages.vendors.vendor_product.index', [
                'vendor_id' => $vendor_data->vendor_id,
                'branch_id' => $vendor_data->branch_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_user" role="tabpanel" aria-labelledby="vendor_user_tab">

            @include('pages.vendors.vendor_user.index', [
                'vendor_data' => $vendor_data,
                'vendor_id' => $vendor_data->vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_def" role="tabpanel" aria-labelledby="vendor_def_tab">
            @include('pages.vendors.vendor_def.index', [
                'vendor_id' => $vendor_data->vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_stock" role="tabpanel" aria-labelledby="vendor_stock_tab">
            @include('pages.vendors.vendor_stock.index', [
                'vendor_id' => $vendor_data->vendor_id,
                'vendor_name' => $vendor_data->vendor_name,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_promo_dis" role="tabpanel" aria-labelledby="vendor_promo_tab">
            @include('pages.vendors.promo_discout.index', [
                'vendor_id' => $vendor_data->vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_invoice" role="tabpanel" aria-labelledby="vendor_invoice_tab">
            @include('pages.vendors.vendor_invoince.index', [
                'vendor_id' => $vendor_data->vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_rab" role="tabpanel" aria-labelledby="vendor_rabbit">
            @include('pages.vendors.vendor_rabbit.index', [
                'vendor_id' => $vendor_data->vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_line" role="tabpanel" aria-labelledby="vendor_linepay">
            @include('pages.vendors.vendor_linepay.index', [
                'vendor_id' => $vendor_data->vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_gp" role="tabpanel" aria-labelledby="vendor_gp_tab">
            @include('pages.vendors.vendor_gp.index', [
                'vendor_id' => $vendor_data->vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg " id="vendor_garantee" role="tabpanel" aria-labelledby="vendor_garantee_tab">
            @include('pages.vendors.vendor_garantee.index', [
                'vendor_id' => $vendor_data->vendor_id,
            ])
        </div>
        {{-- <div class="hidden p-4 rounded-lg " id="contacts" role="tabpanel" aria-labelledby="contacts-tab"> </div> --}}
    </div>
@endsection
@section('js-scripts')
    @vite(['resources/js/vendor_tab.js'])
    <script>
        function back() {
            localStorage.removeItem('activeTab');

            window.history.back();
        }

        function clear_button() {
            localStorage.removeItem('activeTab');
        }

        function edit_button() {
            localStorage.removeItem('activeTab');
        }
    </script>
@endsection
