@vite(['resources/css/app.css', 'resources/js/app.js'])
<section>
    @php
        $search_compo = request()->get('search_compo', '');
        $vendor_product = DB::table('vendorproduct_info')
            ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', '=', $vendor_id)
            ->where('branch_id', '=', $branch_id)
            ->where('vendorproduct_info.activeflag', '=', '1')
            ->orderBy('product_seq', 'asc')
            ->get();
        // and Product_id Not in และ select vendorproduct
        $products = DB::table('product_info')
            ->where('activeflag', '1')
            ->whereNotIn('product_id', function ($query) {
                $query->select('product_id')->from('vendorproduct_info');
            })
            ->orderBy('product_desc', 'asc')
            ->get();

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
    {{-- Product info จะมี unit ดึง join unit_info เพื่อแสดงชื่อ --}}
    <div class="grid grid-cols-1 gap-3">
        <div class=" flex justify-self-end">
            <button type="button" data-modal-target="vendor_product_component"
                data-modal-toggle="vendor_product_component" class="modal_button_add" type="button">
                {{ __('menu.button.add') }}
            </button>
        </div>
        <div class="overflow-x-auto">
            <div class="flex justify-start mb-3">
                <form action="{{ route('vendor_product_info_search', [$vendor_id, 'pages_search' => 'edit']) }}"
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
                        <th scope="col">Action</th>

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
                            <td>
                                <form action="{{ route('del_component', [$vpd->product_id, $vpd->productdetail_id]) }}"
                                    method="post" id="delete-form-{{ $vpd->product_id }}">
                                    @csrf
                                    @method('PUT')
                                    <button id="del-button" class="del-button" data-item-id="{{ $vpd->product_id }}"
                                        data-name="{{ $vpd->product_desc }}">
                                        <svg class="w-[16px] h-[16px]" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.6"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class=" mt-2">
            {{ $vendor_product_detail->links() }}
        </div>
    </div>
</section>
<section>
    <div id="vendor_product_component" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-3xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 ">
                        {{ __('vendor_product.vendor_component') }}
                    </h3>
                    <button type="button" class="" data-modal-toggle="vendor_product_component">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="post" id="vendor_product_form1">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-1 lg:grid-cols-3">
                        <input type="text" class=" sr-only" name="vendor_id" value="{{ $vendor_id }}">
                        <div>
                            <label for="product_id" class="label_input"> {{ __('vendor_product.product_id') }} </label>
                            <select class="input_text" name="product_id" id="product_id_2" required>
                                <option selected disabled> {{ __('vendor_product.select_products') }} </option>
                                @foreach ($vendor_product as $product)
                                    <option value="{{ $product->product_id }}">({{ $product->product_id }})
                                        {{ $product->product_desc }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div>
                            <label for="product_id" class="label_input"> {{ __('vendor_product.product_component') }}
                            </label>
                            <select class="input_text" name="productdetail_id" id="productdetail_id" required>
                                <option selected disabled> {{ __('vendor_product.select_component') }} </option>
                                @foreach ($products as $pro_duct)
                                    <option value="{{ $pro_duct->product_id }}">({{ $pro_duct->product_id }})
                                        {{ $pro_duct->product_desc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="qty" class="label_input"> {{ __('vendor_product.qty') }} </label>
                            <input type="number" id="qty_2" name="qty" class="input_text" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button id="compoButton2" class="submit_btn">
                            {{ __('menu.button.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<script type="module">
    new TomSelect('#productdetail_id', {
        plugins: ['dropdown_input'],
    });
    $(document).ready(function() {
        // เมื่อคลิกปุ่มที่มี id="saveButton"
        $('#compoButton2').on('click', function(e) {
            e.preventDefault(); // หยุดการทำงานของ submit แบบปกติ

            // ใช้ FormData เพื่อจับข้อมูลจากฟอร์ม
            var formData = new FormData($('#vendor_product_form1')[0]);

            // ส่งข้อมูลไปยัง Route ที่กำหนดโดยใช้ Ajax
            $.ajax({
                url: '{{ route('insert_product_component') }}', // URL ที่จะส่งข้อมูลไป
                type: 'POST', // ใช้ Method POST
                data: formData, // ข้อมูลที่ส่งไป
                processData: false, // บอกว่าไม่ต้องแปลงข้อมูล
                contentType: false, // บอกว่าไม่ต้องตั้ง Content-Type
                success: function(response) {
                    // เมื่อส่งข้อมูลสำเร็จ
                    Swal.fire({
                        text: `{{ __('menu.edit_is_success') }}`,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    // ปิด Modal
                    $('#vendor_product_component').addClass('hidden');

                    // หากต้องการรีเฟรชข้อมูล หรือทำอะไรก่อนปิดฟอร์ม
                    window.location.reload(); // รีโหลดหน้า (ถ้าต้องการ)
                },
                error: function(xhr, status, error) {
                    let errorMessage = `{{ __('menu.is_failed') }}`;

                    // Check if the error is a validation error
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Gather all validation errors and display them
                        let errorList = '';
                        for (let field in xhr.responseJSON.errors) {
                            errorList +=
                                `<li>${xhr.responseJSON.errors[field].join(', ')}</li>`;
                        }
                        errorMessage = `<ul>${errorList}</ul>`;
                    }

                    // Show error message with the validation errors
                    Swal.fire({
                        title: `{{ __('menu.save_is_failed') }}`, // Failure title
                        html: errorMessage, // Show validation error list
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                    // เมื่อเกิดข้อผิดพลาด
                    // alert('เกิดข้อผิดพลาด: ' + error);
                    // console.log(xhr.responseText); // แสดงข้อผิดพลาดใน console
                }
            });
        });

        // ปิด Modal เมื่อคลิกปุ่มปิด
        $('[data-modal-hide="vendor_product_component"]').on('click', function() {
            $('#vendor_product_component').addClass('hidden');
        });
    });
</script>
