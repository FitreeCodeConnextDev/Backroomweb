@vite(['resources/css/app.css', 'resources/js/app.js'])
<section>
    @php

        $vendorpromo = DB::table('vendorpromotionprint_info')
            ->join('product_info', 'vendorpromotionprint_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', $vendor_id)
            ->get();
    @endphp
    <div class="grid grid-cols-1 gap-3">

        <div class="overflow-x-auto">
            <table class="table-data" id="">
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
</section>
