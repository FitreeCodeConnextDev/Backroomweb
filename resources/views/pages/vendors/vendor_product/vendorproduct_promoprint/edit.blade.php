@vite(['resources/css/app.css', 'resources/js/app.js'])
<section>
    @php
        $search_print = request()->get('search_print', '');
        $vendor_product = DB::table('vendorproduct_info')
            ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', '=', $vendor_id)
            ->where('branch_id', '=', $branch_id)
            ->where('vendorproduct_info.activeflag', '=', '1')
            ->orderBy('product_seq', 'asc')
            ->get();
        $vendorpromo = DB::table('vendorpromotionprint_info')
            ->join('product_info', 'vendorpromotionprint_info.product_id', '=', 'product_info.product_id')
            ->where('vendor_id', $vendor_id)
            ->where(function ($query) use ($search_print) {
                if ($search_print) {
                    $query
                        ->where('vendorpromotionprint_info.promo_seq', 'like', '%' . $search_print . '%')
                        ->orWhere('product_info.product_desc', 'like', '%' . $search_print . '%')
                        ->orWhere('vendorpromotionprint_info.description1', 'like', '%' . $search_print . '%')
                        ->orWhere('vendorpromotionprint_info.description2', 'like', '%' . $search_print . '%');
                }
            })
            ->paginate(10);
    @endphp
    <div class="grid grid-cols-1 gap-3">
        <div class=" flex justify-end">
            <button type="button" data-modal-target="vendor_product_promo_print_modal"
                data-modal-toggle="vendor_product_promo_print_modal" class="modal_button_add" type="button">
                {{ __('menu.button.add') }}
            </button>
        </div>
        <div class="overflow-x-auto">
            <div class="flex justify-start mb-3">
                <form action="{{ route('vendor_product_info_search', [$vendor_id, 'pages_search' => 'edit']) }}"
                    id="vendor_product_compo" method="GET">
                    <input placeholder="Search..." name="search_print" value="{{ $search_print }}"
                        class="input block w-64 px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        name="search" type="search" />
                </form>
            </div>
            <table class="table-data" id="vendorproduct_promo_print-table">
                <thead>
                    <tr>
                        <th scope="col"> {{ __('vendor_product.product_desc') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_datestart') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_dateend') }}</th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_text1') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_text2') }} </th>
                        <th scope="col">Action</th>

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
                            <td>
                                <form action="{{ route('del_promo_print', [$vpr->vendor_id, $vpr->promo_seq]) }}"
                                    method="post" id="delete-form-{{ $vpr->promo_seq }}">
                                    @csrf
                                    @method('PUT')
                                    <button id="del-button" class="del-button" data-item-id="{{ $vpr->promo_seq }}"
                                        data-name="{{ $vpr->product_desc }} [Promotion: {{ $vpr->description1 }}]">
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
</section>
<div id="vendor_product_promo_print_modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b  rounded-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 ">
                    {{ __('vendor_product.vendor_product_promoprint') }}
                </h3>
                <button type="button" class="" data-modal-toggle="vendor_product_promo_print_modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" method="post" id="insert_promo_print">
                @csrf
                <div class="grid gap-4 mb-4 grid-cols-1 lg:grid-cols-3">
                    <input type="hidden" name="vendor_id" value="{{ $vendor_id }}">
                    <div>
                        <label for="product_id" class="label_input"> {{ __('vendor_product.product_id') }} </label>
                        {{-- <input type="text" id="product_id" name="product_id" class="input_text" > --}}
                        <select class="input_text" name="product_id" id="product_id_2">
                            <option selected disabled> {{ __('vendor_product.select_products') }} </option>
                            @foreach ($vendor_product as $product)
                                <option value="{{ $product->product_id }}">({{ $product->product_id }})
                                    {{ $product->product_desc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="start_date" class="label_input"> {{ __('vendor_product.vendorproduct_datestart') }}
                        </label>
                        <input type="date" id="start_date" name="start_date" class="input_text" required>
                    </div>
                    <div>
                        <label for="valid_date" class="label_input"> {{ __('vendor_product.vendorproduct_dateend') }}
                        </label>
                        <input type="date" id="valid_date" name="valid_date" class="input_text" required>
                    </div>

                </div>
                <div class="mb-2">
                    <label for="description1" class="label_input">
                        {{ __('vendor_product.vendorproduct_text1') }}
                    </label>
                    <input type="text" id="description1" name="description1" class="input_text" required>
                </div>
                <div class="mb-2">
                    <label for="description2" class="label_input">
                        {{ __('vendor_product.vendorproduct_text2') }}
                    </label>
                    <input type="text" id="description2" name="description2" class="input_text" required>
                </div>
                <div class="mb-2">
                    <label for="barcode" class="label_input"> {{ __('vendor_product.vendorproduct_barcode') }}
                    </label>
                    <input type="text" id="barcode" name="barcode" class="input_text" required>
                </div>
                <div>
                    <label for="amount_check" class="label_input">
                        {{ __('vendor_product.vendorproduct_amoute_check') }}
                    </label>
                    <input type="number" id="amount_check" name="amount_check" value="0" class="input_text"
                        required>
                </div>
                <div class="mt-4">
                    <h3 class=" font-normal text-base"> {{ __('vendor_product.vendorproduct_use_card') }} </h3>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 mt-2 border border-gray-200 rounded-md p-3">
                    <div>
                        <input id="default-checkbox" type="hidden" name="card_barcode" value="0">
                        <input id="card_barcode" type="checkbox" name="card_barcode" value="1"
                            class="checkbox_input">
                        <label for="card_barcode"
                            class="label_checkbox">{{ __('vendor_product.vendorproduct_card_barcode') }}</label>
                    </div>
                    <div>
                        <input id="default-checkbox" type="hidden" name="card_before" value="0">
                        <input id="card_before" type="checkbox" name="card_before" value="1"
                            class="checkbox_input">
                        <label for="card_before"
                            class="label_checkbox">{{ __('vendor_product.vendorproduct_card_before') }}</label>
                    </div>
                    <div>
                        <input id="default-checkbox" type="hidden" name="card_staff" value="0">
                        <input id="card_staff" type="checkbox" name="card_staff" value="1"
                            class="checkbox_input">
                        <label for="card_staff"
                            class="label_checkbox">{{ __('vendor_product.vendorproduct_card_staff') }}</label>
                    </div>
                    <div>
                        <input id="default-checkbox" type="hidden" name="card_member" value="0">
                        <input id="card_member" type="checkbox" name="card_member" value="1"
                            class="checkbox_input">
                        <label for="card_member"
                            class="label_checkbox">{{ __('vendor_product.vendorproduct_card_member') }}</label>
                    </div>
                    <div>
                        <input id="default-checkbox" type="hidden" name="card_rabbit" value="0">
                        <input id="card_rabbit" type="checkbox" name="card_rabbit" value="1"
                            class="checkbox_input">
                        <label for="card_rabbit"
                            class="label_checkbox">{{ __('vendor_product.vendorproduct_card_rabbit_line') }}</label>
                    </div>
                    <div>
                        <input id="default-checkbox" type="hidden" name="card_qr" value="0">
                        <input id="card_qr" type="checkbox" name="card_qr" value="1" class="checkbox_input">
                        <label for="card_qr"
                            class="label_checkbox">{{ __('vendor_product.vendorproduct_card_qr') }}</label>
                    </div>
                </div>
                <div class="mt-3">
                    <button id="save_promo_print" class="submit_btn">
                        {{ __('menu.button.save') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<script type="module">
    $(document).ready(function() {
        // เมื่อคลิกปุ่มที่มี id="saveButton"
        $('#save_promo_print').on('click', function(e) {
            e.preventDefault(); // หยุดการทำงานของ submit แบบปกติ

            // ใช้ FormData เพื่อจับข้อมูลจากฟอร์ม
            var formData = new FormData($('#insert_promo_print')[0]);

            // ส่งข้อมูลไปยัง Route ที่กำหนดโดยใช้ Ajax
            $.ajax({
                url: '{{ route('insert_promo_print') }}', // URL ที่จะส่งข้อมูลไป
                type: 'POST', // ใช้ Method POST
                data: formData, // ข้อมูลที่ส่งไป
                processData: false, // บอกว่าไม่ต้องแปลงข้อมูล
                contentType: false, // บอกว่าไม่ต้องตั้ง Content-Type
                success: function(response) {
                    // เมื่อส่งข้อมูลสำเร็จ
                    Swal.fire({
                        text: `{{ __('menu.save_is_success') }}`,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    // ปิด Modal
                    $('#vedor_product_info').addClass('hidden');

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
        $('[data-modal-hide="vedor_product_info"]').on('click', function() {
            $('#vedor_product_info').addClass('hidden');
        });
    });
</script>
