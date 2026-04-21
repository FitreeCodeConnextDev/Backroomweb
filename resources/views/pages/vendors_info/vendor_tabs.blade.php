<div class="tab_div">
    <ul class="tab_ul" id="default-tab" data-tabs-toggle="#default-tab-content" data-tabs-active-classes="tab_active"
        data-tabs-inactive-classes="tab_inactive" role="tablist">
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
                data-tabs-target="#vendor_promo_dis" type="button" role="tab" aria-controls="vendor_promo_dis"
                aria-selected="false"> {{ __('vendor.vendor_promo_dis') }}
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
                aria-selected="false"> {{ __('vendor.vendor_garantee_title') }}
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
    <div class="hidden p-4 rounded-lg " id="vendor_product" role="tabpanel" aria-labelledby="vendor_product_tab">
        @include('pages.vendors_info.vendor_product.index', [
            'vendor_id' => $vendor_data->vendor_id,
            'branch_id' => $vendor_data->branch_id,
            'term_id' => $vendor_data->term_id,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_user" role="tabpanel" aria-labelledby="vendor_user_tab">

        @include('pages.vendors_info.vendor_user.index', [
            'vendor_data' => $vendor_data,
            'vendor_id' => $vendor_data->vendor_id,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_def" role="tabpanel" aria-labelledby="vendor_def_tab">
        @include('pages.vendors_info.vendor_def.index', [
            'vendor_id' => $vendor_data->vendor_id,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_stock" role="tabpanel" aria-labelledby="vendor_stock_tab">
        @include('pages.vendors_info.vendor_stock.index', [
            'vendor_id' => $vendor_data->vendor_id,
            'vendor_name' => $vendor_data->vendor_name,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_promo_dis" role="tabpanel" aria-labelledby="vendor_promo_tab">
        @include('pages.vendors_info.vendor_discout.index', [
            'vendor_id' => $vendor_data->vendor_id,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_invoice" role="tabpanel" aria-labelledby="vendor_invoice_tab">
        @include('pages.vendors_info.vendor_invoince.index', [
            'vendor_id' => $vendor_data->vendor_id,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_rab" role="tabpanel" aria-labelledby="vendor_rabbit">
        @include('pages.vendors_info.vendor_rabbit.index', [
            'vendor_id' => $vendor_data->vendor_id,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_line" role="tabpanel" aria-labelledby="vendor_linepay">
        @include('pages.vendors_info.vendor_linepay.index', [
            'vendor_id' => $vendor_data->vendor_id,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_gp" role="tabpanel" aria-labelledby="vendor_gp_tab">
        @include('pages.vendors_info.vendor_gp.index', [
            'vendor_id' => $vendor_data->vendor_id,
        ])
    </div>
    <div class="hidden p-4 rounded-lg " id="vendor_garantee" role="tabpanel" aria-labelledby="vendor_garantee_tab">
        @include('pages.vendors_info.vendor_garantee.index', [
            'vendor_id' => $vendor_data->vendor_id,
        ])
    </div>
    {{-- <div class="hidden p-4 rounded-lg " id="contacts" role="tabpanel" aria-labelledby="contacts-tab"> </div> --}}
</div>
