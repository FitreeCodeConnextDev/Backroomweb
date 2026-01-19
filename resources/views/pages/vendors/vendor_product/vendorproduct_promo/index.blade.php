@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    $search_promo = request()->get('search_promo', '');
    $vendorproduct_promo = DB::table('vendorproductpromotion_info')
        ->join('product_info', 'product_info.product_id', '=', 'vendorproductpromotion_info.product_id')
        ->where('vendor_id', '=', $vendor_id)
        ->where('branch_id', '=', $branch_id)
        ->where(function ($query) use ($search_promo) {
            if ($search_promo) {
                $query
                    ->where('vendorproductpromotion_info.start_date', 'like', '%' . $search_promo . '%')
                    ->orWhere('product_info.product_desc', 'like', '%' . $search_promo . '%')
                    ->orWhere('vendorproductpromotion_info.end_date', 'like', '%' . $search_promo . '%');
            }
        })
        ->paginate(10);

@endphp
<section>
    <div class="grid grid-cols-1 gap-3">
        <div class="overflow-x-auto">
            <div class="flex justify-start mb-3">
                <form action="{{ route('vendor_product_info_search_show', [$vendor_id, 'pages_search' => 'show']) }}"
                    id="vendor_product_compo" method="GET">
                    <input placeholder="Search..." name="search_promo" value="{{ $search_promo }}"
                        class="input block w-64 px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        name="search" type="search" />
                </form>
            </div>
            <table class="table-data" id="vendorproduct_promo-table">
                <thead>
                    <tr>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_startdate') }}</th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_enddate') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_starttime') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_endtime') }} </th>
                        <th scope="col"> {{ __('vendor_product.product_price') }} </th>
                        <th scope="col"> {{ __('vendor_product.product_gp') }} </th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($vendorproduct_promo as $item_product)
                        <tr>
                            <td> {{ date('d/m/Y', strtotime($item_product->start_date)) }} </td>
                            <td> {{ date('d/m/Y', strtotime($item_product->end_date)) }} </td>
                            <td>{{ date('H:i', strtotime($item_product->start_time)) }}</td>
                            <td>{{ date('H:i', strtotime($item_product->end_time)) }}</td>
                            <td> {{ $item_product->priceunit }} </td>
                            <td> {{ $item_product->gp_normal }} </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class=" mt-2">
            {{ $vendorproduct_promo->links() }}
        </div>
    </div>
</section>
