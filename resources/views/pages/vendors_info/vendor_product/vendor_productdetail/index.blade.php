@php
    $search = request()->input('productdetail_search', '');
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
        ->when($search, function ($query) use ($search) {
            $query->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('productdetail_info.product_id', 'like', '%' . $search . '%')
                    ->orWhere('product_desc', 'like', '%' . $search . '%');
            });
        })
        ->paginate(10)
        ->appends(['productdetail_search' => $search]);
    $vendor_clone_id = DB::table('vendor_info')
        ->where('vendor_id', '!=', $vendor_id)
        ->where('activeflag', '=', 1)
        ->select('vendor_id', 'vendor_name')
        ->orderBy('vendor_id', 'asc')
        ->get();
@endphp
<div class="grid grid-cols-1 gap-3">
    @if (!Route::is('vendor-page.show'))
        <div class=" flex justify-self-end space-x-2">
            <button type="button" data-modal-target="vendor_product_detail" data-modal-toggle="vendor_product_detail"
                class="modal_button_add" type="button">
                {{ __('menu.button.add') }}
            </button>
            <div>
                <button data-modal-target="clone_product_detail" data-modal-toggle="clone_product_detail"
                    class="modal_button_clone" type="button">
                    Clone
                </button>
            </div>
        </div>
    @endif
    <div class="overflow-x-auto">
        <div class="flex justify-start mb-3">
            <form method="GET">
                <input placeholder="Search..." name="productdetail_search" value="{{ $search }}"
                    class="input block w-64 px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                    type="search" />
            </form>
        </div>
        <table class="table-data" id="vendorproduct_component-table">
            <thead>
                <tr>
                    <th scope="col"> {{ __('vendor_product.product_desc') }} </th>
                    <th scope="col"> {{ __('vendor_product.product_component') }}</th>
                    <th scope="col"> {{ __('menu.product_unit_unit_name') }}</th>
                    <th scope="col"> {{ __('vendor_product.qty') }} </th>
                    @if (!Route::is('vendor-page.show'))
                        <th scope="col">Action</th>
                    @endif

                </tr>
            </thead>

            <tbody>
                @foreach ($vendor_product_detail as $vpd)
                    @php
                        $product_detail_names = DB::table('product_info')
                            ->select('product_desc as product_name', 'unit_id')
                            ->where('product_id', $vpd->productdetail_id)
                            ->first(); // Use first() instead of get()
                        $product_unit = DB::table('unit_info')
                            ->select('unit_name')
                            ->where('unit_id', $product_detail_names->unit_id)
                            ->first();
                    @endphp
                    <tr>
                        {{-- <td> {{ $vpd->product_id }} </td> --}}
                        <td> {{ $vpd->product_desc }} </td>
                        <td> {{ $product_detail_names->product_name }} </td>
                        <td> {{ !empty($product_unit->unit_name) ? $product_unit->unit_name : __('vendor_product.non_unit') }}
                        </td>
                        <td> {{ $vpd->qty }} </td>
                        @if (!Route::is('vendor-page.show'))
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
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class=" mt-2">
        {{ $vendor_product_detail->links() }}
    </div>
</div>
<section>
    <div id="vendor_product_detail" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-3xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 ">
                        {{ __('vendor_product.vendor_component') }}
                    </h3>
                    <button type="button" class="" data-modal-toggle="vendor_product_detail">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="post" id="vendor_product_detail_form">
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
                            <label for="productdetail_id" class="label_input">
                                {{ __('vendor_product.product_component') }}
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
                            <label for="unit_id" class="label_input"> {{ __('vendor_product.unit_id') }} </label>
                            <input type="text" id="unit_name" class="input_text" required readonly>
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
    <div id="clone_product_detail" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded dark:border-gray-600 border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('vendor_product.clone_productdetail') }}
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="clone_product_detail">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" action="{{ route('vendor_product_clone_product_detail') }}"
                        method="POST">
                        @csrf
                        <div>
                            <input type="hidden" name="product_vendor_id" id="product_vendor_id"
                                value="{{ $vendor_id }}">
                            <label for="clone_vendor_id" class="label_input">
                                {{ __('vendor_product.clone_vendor') }}</label>
                            <select name="clone_vendor_id" id="clone_vendor_id" class="input_text">
                                <option value=" ">{{ __('vendor_product.choose_vendor') }}</option>
                                @foreach ($vendor_clone_id as $vendorclone)
                                    <option value="{{ $vendorclone->vendor_id }}">
                                        {{ $vendorclone->vendor_name }} ({{ $vendorclone->vendor_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="submit_btn">{{ __('menu.button.confirm') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('productdetail_id');

            productSelect.addEventListener('change', function(event) {
                const productdetail_id = event.target.value;

                if (productdetail_id) {
                    // ส่งคำขอไปยัง Laravel Route
                    fetch(`/get-unitProductdetail/${productdetail_id}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                // ถ้าข้อผิดพลาดเกิดขึ้น เช่น Product ไม่เจอ
                                console.error(data.error);
                                return;
                            }

                            // เติมค่าให้กับ input fields ตามที่ได้รับจาก Controller
                            document.getElementById('unit_name').value = data.unit_name;
                        })
                        .catch(error => {
                            console.error('Error fetching product details:', error);
                        });
                }
            });
        });
    </script>
    <script type="module">
        new TomSelect('#productdetail_id', {
            plugins: ['dropdown_input'],
        });
        $(document).ready(function() {
            // เมื่อคลิกปุ่มที่มี id="saveButton"
            $('#compoButton2').on('click', function(e) {
                e.preventDefault(); // หยุดการทำงานของ submit แบบปกติ

                // ใช้ FormData เพื่อจับข้อมูลจากฟอร์ม
                var formData = new FormData($('#vendor_product_detail_form')[0]);

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
                            title: 'Success',
                            text: `{{ __('menu.edit_is_success') }}`,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 3000,
                        });

                        // ปิด Modal
                        $('#vendor_product_detail').addClass('hidden');

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
                            confirmButtonText: `{{ __('menu.button.confirm') }}`
                        });
                        // เมื่อเกิดข้อผิดพลาด
                        // alert('เกิดข้อผิดพลาด: ' + error);
                        // console.log(xhr.responseText); // แสดงข้อผิดพลาดใน console
                    }
                });
            });

            // ปิด Modal เมื่อคลิกปุ่มปิด
            $('[data-modal-hide="vendor_product_detail"]').on('click', function() {
                $('#vendor_product_detail').addClass('hidden');
            });
        });
    </script>
@endpush
