@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    $branch_id = session('auth_user.branch_id');
    if ($branch_id == '000') {
        $vendor_product = DB::table('vendorproduct_info')
            ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', '=', $vendor_id)
            ->where('vendorproduct_info.activeflag', '=', 1)
            ->orderBy('product_seq', 'asc')
            ->paginate(10);
    } else {
        $vendor_product = DB::table('vendorproduct_info')
            ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', '=', $vendor_id)
            ->where('branch_id', '=', $branch_id)
            ->where('vendorproduct_info.activeflag', '=', 1)
            ->orderBy('product_seq', 'asc')
            ->paginate(10);
    }

@endphp
<section class="grid grid-cols-1 gap-3">
    <div class="overflow-x-auto">
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
                        <td> {{ $product->priceunit }} </td>
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
