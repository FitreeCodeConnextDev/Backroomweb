@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    $branch_id = session('auth_user.branch_id');
    if ($branch_id == '000000') {
        $vendor_product = DB::table('vendorproduct_info')
            ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', '=', $vendor_id)
            ->where('vendorproduct_info.activeflag', '=', 1)
            ->when(request()->get('search'), function ($query) {
                $search = request()->get('search');
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('vendorproduct_info.product_id', 'like', '%' . $search . '%')
                        ->orWhere('product_info.product_desc', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('product_seq', 'asc')
            ->paginate(10);
    } else {
        $vendor_product = DB::table('vendorproduct_info')
            ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', '=', $vendor_id)
            ->where('branch_id', '=', $branch_id)
            ->where('vendorproduct_info.activeflag', '=', 1)
            ->when(request()->get('search'), function ($query) {
                $search = request()->get('search');
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('vendorproduct_info.product_id', 'like', '%' . $search . '%')
                        ->orWhere('product_info.product_desc', 'like', '%' . $search . '%')
                        ->orWhere('vendorproduct_info.product_seq', 'like', '%' . $search . '%')
                        ->orWhere('vendorproduct_info.priceunit', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('product_seq', 'asc')
            ->paginate(10);
    }
    $search = request()->get('search', '');

@endphp
<section class="grid grid-cols-1 gap-3">
    <div class="overflow-x-auto">
        <div class="flex justify-start mb-3">
            <form action="{{ route('vendor_product_info_search_show', [$vendor_id, 'pages_search' => 'show']) }}"
                method="GET">
                <input placeholder="Search..." name="search" value="{{ $search }}"
                    class="input block w-64 px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    name="search" type="search" />
            </form>
        </div>
        <table class="table-data" id="vendorproduct-table">
            <thead>
                <tr>
                    <th scope="col"> {{ __('vendor_product.product_no') }} </th>
                    <th scope="col"> {{ __('vendor_product.product_id') }} </th>
                    <th scope="col"> {{ __('vendor_product.product_desc') }} </th>
                    <th scope="col"> {{ __('vendor_product.product_price') }} </th>
                    <th scope="col"> {{ __('vendor_product.product_gp') }} </th>
                </tr>
            </thead>

            <tbody>
                @foreach ($vendor_product as $product)
                    <tr>
                        <td> {{ $product->product_seq }} </td>
                        <td> {{ $product->product_id }} </td>
                        <td> {{ $product->product_desc }} </td>
                        <td> {{ number_format($product->priceunit, 2) }} </td>
                        <td> {{ $product->gp_normal }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class=" mt-2">
            {{ $vendor_product->links() }}
        </div>
    </div>
</section>
