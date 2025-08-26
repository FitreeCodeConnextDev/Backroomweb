@vite(['resources/css/app.css', 'resources/js/app.js'])
<meta charset="UTF-8">

{{-- @dd($stock_data) --}}

@php
    $stock_data = DB::table('stock_info')
        ->select('product_id', 'product_desc', 'cur_balance')
        ->where('vendor_id', $vendor_id)
        ->get();

@endphp
<div class=" border border-gray-200 rounded-lg p-5">
    <div class="grid grid-cols-1 gap-1">
        <div class="flex justify-end">
            <button id="exportButton" class="excel_button" data-id="{{ $vendor_name }}" title="Export Excel"
                @if ($stock_data->isEmpty()) disabled hidden @endif>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="6" height="6"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 3v4a1 1 0 0 1-1 1H5m8-2h3m-3 3h3m-4 3v6m4-3H8M19 4v16a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V7.914a1 1 0 0 1 .293-.707l3.914-3.914A1 1 0 0 1 9.914 3H18a1 1 0 0 1 1 1ZM8 12v6h8v-6H8Z" />
                </svg>
            </button>

        </div>
        <div class="overflow-y-auto max-h-96">
            <table class="table-data " id="stock_table">
                <thead>
                    <tr>
                        <th scope="col"> {{ __('vendor.stock_product_id') }} </th>
                        <th scope="col"> {{ __('vendor.stock_product_desc') }} </th>
                        <th scope="col"> {{ __('vendor.stock_cur_balance') }} </th>
                    </tr>
                </thead>

                {{-- @dd($stock_data) --}}
                <tbody class="overflow-y-auto max-h-96">
                    @foreach ($stock_data as $item)
                        <tr>
                            <td> {{ $item->product_id }} </td>
                            <td> {{ $item->product_desc }} </td>
                            <td> {{ $item->cur_balance }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- <input type="text" id="vendor_name" value="{{ $vendor_name }}" class=" sr-only "> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>
<script>
    document.getElementById("exportButton").addEventListener("click", function() {
        // เรียกตาราง HTML
        var table = document.getElementById("stock_table");
        const itemName = this.getAttribute('data-id'); // ดึงข้อมูลจาก data-id

        // แปลงตารางเป็น JSON
        var wb = XLSX.utils.table_to_book(table, {
            sheet: "Sheet 1"
        });

        // ตั้งค่าฟอร์แมตในคอลัมน์จำนวน (คอลัมน์ที่ 3) ให้เป็นทศนิยม 2 ตำแหน่ง
        var range = XLSX.utils.decode_range(wb.Sheets["Sheet 1"]['!ref']); // หาช่วงข้อมูลทั้งหมด
        for (var row = range.s.r + 1; row <= range.e.r; row++) {
            var cell = wb.Sheets["Sheet 1"][XLSX.utils.encode_cell({
                r: row,
                c: 2
            })]; // เข้าถึงคอลัมน์ที่ 3 (จำนวน)
            if (cell) {
                cell.z = '#,##0.00'; // ตั้งค่าฟอร์แมตเป็นทศนิยม 2 ตำแหน่ง
            }
        }

        // ดาวน์โหลดไฟล์ Excel
        XLSX.writeFile(wb, "Stock_" + itemName + ".xlsx"); // แก้ไขการประกอบชื่อไฟล์
    });
</script>
