@vite(['resources/css/app.css', 'resources/js/app.js'])
<section>
    @php

        $search_print = request()->get('search_print', '');
        $vendorpromo = DB::table('vendorpromotionprint_info')
            ->join('product_info', 'vendorpromotionprint_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', $vendor_id)
            ->where(function ($query) use ($search_print) {
                if ($search_print) {
                    $query
                        ->where('vendorpromotionprint_info.promo_seq', 'like', '%' . $search_print . '%')
                        ->orWhere('product_info.product_desc', 'like', '%' . $search_print . '%')
                        ->orWhere('vendorpromotionprint_info.description1', 'like', '%' . $search_print . '%')
                        ->orWhere('vendorpromotionprint_info.description2', 'like', '%' . $search_print . '%');
                }
            })
            ->paginate(10);
    @endphp
    <div class="grid grid-cols-1 gap-3">

        <div class="overflow-x-auto">
            <div class="flex justify-start mb-3">
                <form action="{{ route('vendor_product_info_search_show', [$vendor_id, 'pages_search' => 'show']) }}"
                    id="vendor_product_compo" method="GET">
                    <input placeholder="Search..." name="search_print" value="{{ $search_print }}"
                        class="input block w-64 px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        name="search" type="search" />
                </form>
            </div>
            <table class="table-data" id="vendorproduct_promo_print-table">
                <thead>
                    <tr>
                        <th scope="col"> {{ __('vendor_product.product_desc') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_datestart') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_dateend') }}</th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_text1') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_text2') }} </th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($vendorpromo as $vpr)
                        <tr>
                            <td> {{ $vpr->product_desc }} </td>
                            <td> {{ date('d/m/Y', strtotime($vpr->start_date)) }} </td>
                            <td> {{ date('d/m/Y', strtotime($vpr->valid_date)) }} </td>
                            <td> {{ $vpr->description1 }} </td>
                            <td> {{ $vpr->description2 }} </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class=" mt-2">
            {{ $vendorpromo->links() }}
        </div>
</section>
