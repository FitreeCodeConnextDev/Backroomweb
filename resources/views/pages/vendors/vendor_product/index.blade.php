@vite(['resources/css/app.css', 'resources/js/app.js'])

<header>
    <div class="tab_div">
        <ul class="tab_ul-2" id="vendor-product-tab" data-tabs-toggle="#vendor-product-tab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="tab_button_2" id="vendor-product-tab" data-tabs-target="#vendor-product" type="button"
                    role="tab" aria-controls="vendor-product" aria-selected="false">
                    {{ __('vendor_product.vendor_product_data') }} </button>
            </li>
            <li class="me-2" role="presentation">
                <button class="tab_button_2 hover:border-gray-300 dark:hover:text-gray-300"
                    id="vendorproduct_component-tab" data-tabs-target="#vendorproduct_component" type="button"
                    role="tab" aria-controls="vendorproduct_component" aria-selected="false">
                    {{ __('vendor_product.vendor_component') }}
                </button>
            </li>
            <li class="me-2" role="presentation">
                <button class="tab_button_2 hover:border-gray-300 dark:hover:text-gray-300" id="vendorproduct_promo-tab"
                    data-tabs-target="#vendorproduct_promo" type="button" role="tab"
                    aria-controls="vendorproduct_promo" aria-selected="false">
                    {{ __('vendor_product.vendor_product_promo') }}
                </button>
            </li>
            <li class="me-2" role="presentation">
                <button class="tab_button_2 hover:border-gray-300 dark:hover:text-gray-300"
                    id="vendorproduct_promo_print-tab" data-tabs-target="#vendorproduct_promo_print" type="button"
                    role="tab" aria-controls="vendorproduct_promo_print" aria-selected="false">
                    {{ __('vendor_product.vendor_product_promoprint') }}
                </button>
            </li>
        </ul>
    </div>
</header>
<main>
    <div id="vendor-product-tab-content">
        <div class="hidden p-4 rounded-lg" id="vendor-product" role="tabpanel" aria-labelledby="vendor-product-tab">
            @include('pages.vendors.vendor_product.vendor_product_info.index', [
                'vendor_id' => $vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg" id="vendorproduct_component" role="tabpanel"
            aria-labelledby="vendorproduct_component-tab">
            @include('pages.vendors.vendor_product.vendorproduct_component.index', [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg" id="vendorproduct_promo" role="tabpanel"
            aria-labelledby="vendorproduct_promo-tab">
            @include('pages.vendors.vendor_product.vendorproduct_promo.index', [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg" id="vendorproduct_promo_print" role="tabpanel"
            aria-labelledby="vendorproduct_promo_print-tab">
            @include('pages.vendors.vendor_product.vendorproduct_promoprint.index', [
                'vendor_id' => $vendor_id,
            ])
        </div>
    </div>
</main>
