@vite(['resources/css/app.css', 'resources/js/app.js'])

<section>
    <div class="grid grid-cols-1 gap-3">
        <div class="overflow-x-auto">
            <table class="table-data">
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
                @php
                    $vendorproduct_promo = DB::table('vendorproductpromotion_info')
                        ->where('vendor_id', '=', $vendor_id)
                        ->where('branch_id', '=', $branch_id)
                        ->get();

                @endphp
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
    </div>
</section>
