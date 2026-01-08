@vite(['resources/css/app.css', 'resources/js/app.js'])

@php
    $vendor_gp_data = DB::table('vendorgp_info')->where('vendor_id', '=', $vendor_id)->get();
@endphp
<section>
    <div class="grid grid-cols-1 gap-6 border border-gray-200 rounded-lg p-5">
        <div class=" flex justify-end">
            <button data-modal-target="vendor_gp_modal" data-modal-toggle="vendor_gp_modal" class="modal_button_add"
                type="button">
                {{ __('menu.button.add') }}
            </button>
        </div>
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
                        <th> Action </th>
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
                            <td>
                                <form action="{{ route('vendor_gp_del', [$item->gp_seq, $item->vendor_id]) }}"
                                    method="post" id="delete-form-{{ $item->gp_seq }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="del-button" data-item-id="{{ $item->gp_seq }}"
                                        data-name="{{ $item->gp_seq }}">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
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
    </div>

    <div id="vendor_gp_modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b   border-gray-200">

                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="vendor_gp_modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" id="vendorgp_form" method="post">
                        @csrf
                        <input type="text" class=" sr-only" name="vendor_id" value=" {{ $vendor_id }} ">
                        <div class=" grid grid-cols-1 lg:grid-cols-2 gap-2">
                            <div>
                                <label for="gp_code" class="label_input"> {{ __('vendor.gp_code') }} </label>
                                <input type="text" name="gp_code" id="gp_code" class="input_text" required>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                                <div>
                                    <label for="start_date" class="label_input"> {{ __('vendor.start_date') }} </label>
                                    <input type="date" name="start_date" id="start_date" class="input_text" required>
                                </div>
                                <div>
                                    <label for="valid_date" class="label_input"> {{ __('vendor.valid_date') }} </label>
                                    <input type="date" name="valid_date" id="valid_date" class="input_text">
                                </div>
                            </div>
                            <div>
                                <label for="gp_min" class="label_input"> {{ __('vendor.min_guarantee') }}
                                </label>
                                <input type="number" name="gp_min" id="gp_min" class="input_text" required>
                            </div>
                        </div>
                        <div class=" grid grid-cols-1 lg:grid-cols-3 gap-2">

                            <div>
                                <label for="gp_normal" class="label_input">{{ __('vendor.gp_min') }}
                                    {{ __('vendor.gp_normal') }} </label>
                                <input type="number" name="gp_normal" id="gp_normal" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_promotion" class="label_input">{{ __('vendor.gp_min') }}
                                    {{ __('vendor.gp_promotion') }} </label>
                                <input type="number" name="gp_promotion" id="gp_promotion" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_member" class="label_input">{{ __('vendor.gp_min') }}
                                    {{ __('vendor.gp_member') }} </label>
                                <input type="number" name="gp_member" id="gp_member" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_staff" class="label_input">{{ __('vendor.gp_min') }}
                                    {{ __('vendor.gp_staff') }} </label>
                                <input type="number" name="gp_staff" id="gp_staff" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_rabbit" class="label_input">{{ __('vendor.gp_min') }}
                                    {{ __('vendor.gp_rabbit') }} </label>
                                <input type="number" name="gp_rabbit" id="gp_rabbit" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_qr" class="label_input">{{ __('vendor.gp_min') }}
                                    {{ __('vendor.gp_qr') }} </label>
                                <input type="number" name="gp_qr" id="gp_qr" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp1" class="label_input">
                                    {{ __('vendor_product.product_gp_sp1') }} </label>
                                <input type="number" name="gp_sp1" id="gp_sp1" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp2" class="label_input">
                                    {{ __('vendor_product.product_gp_sp2') }} </label>
                                <input type="number" name="gp_sp2" id="gp_sp2" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp3" class="label_input">
                                    {{ __('vendor_product.product_gp_sp3') }} </label>
                                <input type="number" name="gp_sp3" id="gp_sp3" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp4" class="label_input">
                                    {{ __('vendor_product.product_gp_sp4') }} </label>
                                <input type="number" name="gp_sp4" id="gp_sp4" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp5" class="label_input">
                                    {{ __('vendor_product.product_gp_sp5') }} </label>
                                <input type="number" name="gp_sp5" id="gp_sp5" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_edc" class="label_input">
                                    {{ __('vendor_product.product_gp_edc') }} </label>
                                <input type="number" name="gp_edc" id="gp_edc" class="input_text" required>
                            </div>
                        </div>
                        <button id="gp_submit" class="submit_btn">{{ __('menu.button.save') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script type="module">
    $(document).ready(function() {
        // เมื่อคลิกปุ่มที่มี id="saveButton"
        $('#gp_submit').on('click', function(e) {
            e.preventDefault(); // หยุดการทำงานของ submit แบบปกติ

            // ใช้ FormData เพื่อจับข้อมูลจากฟอร์ม
            var formData = new FormData($('#vendorgp_form')[0]);

            // ส่งข้อมูลไปยัง Route ที่กำหนดโดยใช้ Ajax
            $.ajax({
                url: '{{ route('vendor_gp_insert') }}', // URL ที่จะส่งข้อมูลไป
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
                    $('#vendor_gp_modal').addClass('hidden');

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

        // Delete button handler
        $(document).on('click', '.del-button', function(e) {
            e.preventDefault();
            const itemId = $(this).data('item-id');
            const form = $('#delete-form-' + itemId);

            Swal.fire({
                title: `{{ __('menu.deleted_title') }}`,
                html: `{{ __('menu.deleted_text') }} <b>${itemName}</b>`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: `{{ __('menu.deleted_yes') }}`,
                cancelButtonText: `{{ __('menu.deleted_no') }}`,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // ปิด Modal เมื่อคลิกปุ่มปิด
        $('[data-modal-hide="vendor_gp_modal"]').on('click', function() {
            $('#vendor_gp_modal').addClass('hidden');
        });
    });
</script>
