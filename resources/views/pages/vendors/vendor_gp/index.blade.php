@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    $vendor_gp_data = DB::table('vendorgp_info')->where('vendor_id', '=', $vendor_id)->get();
@endphp
<div class="grid grid-cols-1 gap-3 border border-gray-200 rounded-lg p-3">
    <div class="overflow-x-auto">
        <table class="table-data ">
            <thead>
                <tr>
                    <th>{{ __('vendor.start_date') }}</th>
                    <th> {{ __('vendor.valid_date') }} </th>
                    <th> {{ __('vendor.gp_code') }} </th>
                    <th> {{ __('vendor.gp_normal') }} </th>
                    <th> {{ __('vendor.gp_promotion') }} </th>
                    <th> {{ __('vendor.gp_member') }} </th>
                    <th> {{ __('vendor.gp_staff') }} </th>
                    <th> {{ __('vendor.gp_rabbit') }} </th>
                    <th> {{ __('vendor.gp_qr') }} </th>
                    <th> {{ __('vendor.min_guarantee') }} </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendor_gp_data as $item)
                    <tr>

                        <td> {{ date('d/m/Y', strtotime($item->start_date)) }} </td>
                        <td> {{ date('d/m/Y', strtotime($item->valid_date)) }} </td>
                        <td> {{ $item->gp_code }} </td>
                        <td>{{ $item->gp_normal }}</td>
                        <td>{{ $item->gp_promotion }}</td>
                        <td>{{ $item->gp_member }}</td>
                        <td>{{ $item->gp_staff }}</td>
                        <td>{{ $item->gp_rabbit }}</td>
                        <td>{{ $item->gp_qr }}</td>
                        <td>{{ $item->gp_min }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
