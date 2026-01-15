@vite(['resources/css/app.css', 'resources/js/app.js'])

<header>
    <div class="tab_div">
        <ul class="tab_ul-2" id="vendor-product" data-tabs-toggle="#vendor_producttab-content" role="tablist">
            <li class="me-2" role="presentation">
                <button class="tab_button_2" id="vendor_producttab" data-tabs-target="#vendor-product-t" type="button"
                    role="tab" aria-controls="vendor-product-t" aria-selected="false">
                    {{ __('vendor_product.vendor_product_data') }} </button>
            </li>

            <li class="me-2" role="presentation">
                <button class="tab_button_2 hover:border-gray-300 dark:hover:text-gray-300" id="vendor_component-tab"
                    data-tabs-target="#vendor_component" type="button" role="tab" aria-controls="vendor_component"
                    aria-selected="false">
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
                    id="vendorproduct_promoprint-tab" data-tabs-target="#vendorproduct_promoprint" type="button"
                    role="tab" aria-controls="vendorproduct_promoprint" aria-selected="false">
                    {{ __('vendor_product.vendor_product_promoprint') }}
                </button>
            </li>
        </ul>
    </div>
</header>
<main>
    <div id="vendor_producttab-content">
        <div class="hidden p-4 rounded-lg" id="vendor-product-t" role="tabpanel" aria-labelledby="vendor_producttab">
            @include('pages.vendors.vendor_product.vendor_product_info.edit', [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
                'term_id' => $term_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg" id="vendor_component" role="tabpanel" aria-labelledby="vendor_component-tab">
            @include('pages.vendors.vendor_product.vendorproduct_component.edit', [
                'vendor_id' => $vendor_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg" id="vendorproduct_promo" role="tabpanel"
            aria-labelledby="vendorproduct_promo-tab">
            @include('pages.vendors.vendor_product.vendorproduct_promo.edit', [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
            ])
        </div>
        <div class="hidden p-4 rounded-lg" id="vendorproduct_promoprint" role="tabpanel"
            aria-labelledby="vendorproduct_promoprint-tab">
            @include('pages.vendors.vendor_product.vendorproduct_promoprint.edit', [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
            ])
        </div>
    </div>
</main>
