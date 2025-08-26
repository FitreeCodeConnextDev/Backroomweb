@php

    $vendor_product_detail = DB::table('productdetail_info')
        ->join('product_info', 'product_info.product_id', '=', 'productdetail_info.product_id')
        ->where('vendor_id', '=', $vendor_id)
        ->get();
@endphp
<div class="grid grid-cols-1 gap-3">
    <div class="overflow-x-auto">
        <table class="table-data" id="">
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
</div>
