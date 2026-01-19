@php
    $search_compo = request()->get('search_compo', '');
    $vendor_product_detail = DB::table('productdetail_info')
        ->join('product_info', 'product_info.product_id', '=', 'productdetail_info.product_id')
        ->where('vendor_id', '=', $vendor_id)
        ->where(function ($query) use ($search_compo) {
            if ($search_compo) {
                $query
                    ->where('productdetail_info.product_id', 'like', '%' . $search_compo . '%')
                    ->orWhere('product_desc', 'like', '%' . $search_compo . '%');
            }
        })
        ->paginate(10);
@endphp
<div class="grid grid-cols-1 gap-3">
    <div class="overflow-x-auto">
        <div class="flex justify-start mb-3">
            <form action="{{ route('vendor_product_info_search_show', [$vendor_id, 'pages_search' => 'show']) }}"
                id="vendor_product_compo" method="GET">
                <input placeholder="Search..." name="search_compo" value="{{ $search_compo }}"
                    class="input block w-64 px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    name="search" type="search" />
            </form>
        </div>
        <table class="table-data" id="vendorproduct_component-table">
            <thead>
                <tr>
                    <th scope="col"> {{ __('vendor_product.product_desc') }} </th>
                    <th scope="col"> {{ __('vendor_product.product_component') }}</th>
                    <th scope="col"> {{ __('menu.product_unit_unit_name') }}</th>
                    <th scope="col"> {{ __('vendor_product.qty') }} </th>
                </tr>
            </thead>

            <tbody>

                @foreach ($vendor_product_detail as $vpd)
                    @php
                        $product_detail_names = DB::table('product_info')
                            ->select('product_desc as product_name')
                            ->where('product_id', $vpd->productdetail_id)
                            ->first(); // Use first() instead of get()
                        $product_unit = DB::table('unit_info')
                            ->select('unit_name')
                            ->where('unit_id', $vpd->unit_id)
                            ->first();
                    @endphp
                    <tr>
                        {{-- <td> {{ $vpd->product_id }} </td> --}}
                        <td> {{ $vpd->product_desc }} </td>
                        <td> {{ $product_detail_names->product_name }} </td>
                        <td> {{ !empty($product_unit->unit_name) ? $product_unit->unit_name : __('vendor_product.non_unit') }}
                        </td>
                        <td> {{ $vpd->qty }} </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class=" mt-2">
        {{ $vendor_product_detail->links() }}
    </div>
</div>
