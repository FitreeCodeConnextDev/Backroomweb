@vite(['resources/css/app.css', 'resources/js/app.js'])
<section>

    <div class="grid grid-cols-1 gap-3">
        <div>
            <button type="button" data-modal-target="vedor_product_promo-modal"
                data-modal-toggle="vedor_product_promo-modal" class="modal_button_add" type="button">
                {{ __('menu.button.add') }}
            </button>
        </div>
        <div class="overflow-x-auto">

            <table class="table-data">
                <thead>
                    <tr>
                        <th scope="col"> {{ __('vendor_product.product_desc') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_startdate') }}</th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_enddate') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_starttime') }} </th>
                        <th scope="col"> {{ __('vendor_product.vendorproduct_endtime') }} </th>
                        <th scope="col"> {{ __('vendor_product.product_price') }} </th>
                        <th scope="col"> {{ __('vendor_product.product_gp') }} </th>
                        <th scope="col"> ACTION </th>

                    </tr>
                </thead>
                @php
                    $vendorproduct_promo = DB::table('vendorproductpromotion_info')
                        ->join('product_info', 'product_info.product_id', '=', 'vendorproductpromotion_info.product_id')
                        ->where('vendor_id', '=', $vendor_id)
                        ->where('branch_id', '=', $branch_id)
                        ->get();
                    $vendor_product = DB::table('vendorproduct_info')
                        ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
                        ->where('vendor_id', '=', $vendor_id)
                        ->where('branch_id', '=', $branch_id)
                        ->orderBy('product_seq', 'asc')
                        ->paginate($perPage = 10, $columns = ['*']);
                    $vendor_gp = DB::table('vendorgp_info')->where('vendor_id', '=', $vendor_id)->get();
                @endphp
                <tbody>
                    @foreach ($vendorproduct_promo as $item_product)
                        <tr>
                            <td>{{ $item_product->product_desc }}</td>
                            <td> {{ date('d/m/Y', strtotime($item_product->start_date)) }} </td>
                            <td> {{ date('d/m/Y', strtotime($item_product->end_date)) }} </td>
                            <td>{{ date('H:i', strtotime($item_product->start_time)) }}</td>
                            <td>{{ date('H:i', strtotime($item_product->end_time)) }}</td>
                            <td> {{ $item_product->priceunit }} </td>
                            <td> {{ $item_product->gp_normal }} </td>
                            <td>
                                <div>
                                    <form
                                        action="{{ route('vendorproduct_promotion_delete', [$item_product->time_seq, $item_product->vendor_id, $item_product->branch_id]) }}"
                                        method="post" id="delete-form-{{ $item_product->time_seq }}">
                                        @csrf
                                        @method('PUT')
                                        <button id="del-button" class="del-button"
                                            data-item-id="{{ $item_product->time_seq }}"
                                            data-name="{{ $item_product->time_seq }}">
                                            <svg class="w-[16px] h-[16px]" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.6"
                                                    d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</section>
<div id="vedor_product_promo-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-5xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 ">
                    {{ __('vendor_product.vendor_product_promo') }}
                </h3>
                <button type="button" class="" data-modal-toggle="vedor_product_promo-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form class="p-4 md:p-5" method="post" id="vendor_productpromo_form">
                @csrf
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="grid gap-4 mb-4 grid-cols-1 lg:grid-cols-2">
                    <input type="text" class=" sr-only" name="vendor_id" value="{{ $vendor_id }}">
                    <input type="text" class=" sr-only" name="branch_id" value="{{ $branch_id }}">
                    <input type="text" class=" sr-only" name="term_id" value="{{ $term_id }}">
                    <div>
                        <label for="product_id" class="label_input"> {{ __('vendor_product.product_id') }} </label>
                        {{-- <input type="text" id="product_id" name="product_id" class="input_text" > --}}
                        <select class="input_text" name="product_id" id="product_id_1">
                            <option selected disabled> {{ __('vendor_product.select_products') }} </option>
                            @foreach ($vendor_product as $product)
                                <option value="{{ $product->product_id }}">({{ $product->product_id }})
                                    {{ $product->product_desc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="product_desc" class="label_input">{{ __('vendor_product.product_desc') }}</label>
                        <input type="text" id="product_desc_1" name="product_desc" class="input_text" disabled>
                    </div>
                    <div>
                        <label for="start_date"
                            class="label_input">{{ __('vendor_product.vendorproduct_startdate') }}</label>
                        <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="start_date" name="start_date"
                            class="input_text">
                    </div>
                    <div>
                        <label for="end_date"
                            class="label_input">{{ __('vendor_product.vendorproduct_enddate') }}</label>
                        <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="end_date" name="end_date"
                            class="input_text">
                    </div>
                    <div>
                        <label for="start_time"
                            class="label_input">{{ __('vendor_product.vendorproduct_starttime') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="time" id="start_time" name="start_time" class="input_text" />
                        </div>
                    </div>
                    <div>
                        <label for="end_time"
                            class="label_input">{{ __('vendor_product.vendorproduct_endtime') }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="time" id="end_time" name="end_time" class="input_text" />
                        </div>
                    </div>
                </div>
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2 mt-2 border border-gray-200 rounded-md p-2">
                        <div>
                            <label for="priceunit" class="label_input">
                                {{ __('vendor_product.product_priceunit') }}
                            </label>
                            <input type="number" id="priceunit" name="priceunit" class="input_text" step="0.01"
                                min="0" required>
                        </div>
                        <div>
                            <label for="gp_normal" class="label_input">
                                {{ __('vendor_product.product_gp_normal') }}</label>
                            <select name="gp_normal" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_normal }} ">{{ $gp->gp_normal }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pricediscount" class="label_input">
                                {{ __('vendor_product.product_pricediscount') }}
                            </label>
                            <input type="text" id="pricediscount" name="pricediscount" class="input_text"
                                required>
                        </div>
                        <div>
                            <label for="gp_promotion" class="label_input">
                                {{ __('vendor_product.product_gp_promotion') }}</label>
                            <select name="gp_promotion" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_promotion }} ">{{ $gp->gp_promotion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pricemember" class="label_input">
                                {{ __('vendor_product.product_price_member') }}
                            </label>
                            <input type="text" id="pricemember" name="pricemember" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_member" class="label_input">
                                {{ __('vendor_product.product_gp_member') }}</label>
                            <select name="gp_member" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_member }} ">{{ $gp->gp_member }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pricestaff" class="label_input">
                                {{ __('vendor_product.product_price_staff') }}
                            </label>
                            <input type="text" id="pricestaff" name="pricestaff" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_staff" class="label_input">
                                {{ __('vendor_product.product_gp_staff') }}</label>
                            <select name="gp_staff" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_staff }} ">{{ $gp->gp_staff }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pricerabbit" class="label_input">
                                {{ __('vendor_product.product_price_rabbit') }}
                            </label>
                            <input type="text" id="pricerabbit" name="pricerabbit" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_rabbit" class="label_input">
                                {{ __('vendor_product.product_gp_rabbit') }}</label>
                            <select name="gp_rabbit" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_rabbit }} ">{{ $gp->gp_rabbit }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="priceqr" class="label_input">
                                {{ __('vendor_product.product_price_qr') }}
                            </label>
                            <input type="text" id="priceqr" name="priceqr" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_qr" class="label_input">
                                {{ __('vendor_product.product_gp_qr') }}</label>
                            <select name="gp_qr" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_qr }} ">{{ $gp->gp_qr }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-2 mt-2 border border-gray-200 rounded-md p-2">
                        <div>
                            <label for="pricesp1" class="label_input">
                                {{ __('vendor_product.product_sp1') }}
                            </label>
                            <input type="text" id="pricesp1" name="pricesp1" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_sp1" class="label_input">
                                {{ __('vendor_product.product_gp_sp1') }}</label>
                            <select name="gp_sp1" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_sp1 }} ">{{ $gp->gp_sp1 }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pricesp2" class="label_input">
                                {{ __('vendor_product.product_sp2') }}
                            </label>
                            <input type="text" id="pricesp2" name="pricesp2" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_sp2" class="label_input">
                                {{ __('vendor_product.product_gp_sp2') }}</label>
                            <select name="gp_sp2" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_sp2 }} ">{{ $gp->gp_sp2 }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pricesp3" class="label_input">
                                {{ __('vendor_product.product_sp3') }}
                            </label>
                            <input type="text" id="pricesp3" name="pricesp3" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_sp3" class="label_input">
                                {{ __('vendor_product.product_gp_sp3') }}</label>
                            <select name="gp_sp3" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_sp3 }} ">{{ $gp->gp_sp3 }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pricesp4" class="label_input">
                                {{ __('vendor_product.product_sp4') }}
                            </label>
                            <input type="text" id="pricesp4" name="pricesp4" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_sp4" class="label_input">
                                {{ __('vendor_product.product_gp_sp4') }}</label>
                            <select name="gp_sp4" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_sp4 }} ">{{ $gp->gp_sp4 }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="pricesp5" class="label_input">
                                {{ __('vendor_product.product_sp5') }}
                            </label>
                            <input type="text" id="pricesp5" name="pricesp5" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_sp5" class="label_input">
                                {{ __('vendor_product.product_gp_sp5') }}
                            </label>
                            <select name="gp_sp5" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_sp5 }} ">{{ $gp->gp_sp5 }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="priceedc" class="label_input">
                                {{ __('vendor_product.product_price_edc') }}
                            </label>
                            <input type="text" id="priceedc" name="priceedc" class="input_text" required>
                        </div>
                        <div>
                            <label for="gp_edc" class="label_input">
                                {{ __('vendor_product.product_gp_edc') }}
                            </label>
                            <select name="gp_edc" class="input_text" id="">
                                @foreach ($vendor_gp as $gp)
                                    <option value="{{ $gp->gp_edc }} ">{{ $gp->gp_edc }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <button id="vendor_productpromo_submit" class="submit_btn">
                        {{ __('menu.button.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="module">
    $(document).ready(function() { // Set up CSRF token for all Ajax requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Form submission handler
        $('#vendor_productpromo_submit').on('click', function(e) {
            e.preventDefault();

            // Validate all required fields before submission
            if (!$('#vendor_productpromo_form')[0].checkValidity()) {
                $('#vendor_productpromo_form')[0].reportValidity();
                return;
            }

            // Get form data
            var formData = new FormData($('#vendor_productpromo_form')[0]);
            $.ajax({
                url: '{{ route('vendor_promotion_insert') }}', // URL ที่จะส่งข้อมูลไป
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
                    $('#vedor_product_promo-modal').addClass('hidden');

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
        $('[data-modal-hide="vedor_product_promo-modal"]').on('click', function() {
            $('#vedor_product_promo-modal').addClass('hidden');
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id_1');

        productSelect.addEventListener('change', function(event) {
            const productId = event.target.value;

            if (productId) {
                // ส่งคำขอไปยัง Laravel Route
                fetch(`/get-product-details/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            // ถ้าข้อผิดพลาดเกิดขึ้น เช่น Product ไม่เจอ
                            console.error(data.error);
                            return;
                        }

                        // เติมค่าให้กับ input fields ตามที่ได้รับจาก Controller
                        document.getElementById('product_desc_1').value = data.product_desc;
                    })
                    .catch(error => {
                        console.error('Error fetching product details:', error);
                    });
            }
        });
    });
</script>
