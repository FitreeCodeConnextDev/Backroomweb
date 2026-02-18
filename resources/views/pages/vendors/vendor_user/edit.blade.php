@vite(['resources/css/app.css', 'resources/js/app.js'])

<section>
    <div class="grid grid-cols-1 gap-6 border border-gray-200 rounded-lg p-5">
        <div class="flex justify-end ">
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                class="modal_button_add" type="button">
                {{ __('menu.button.add') }}
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="table-data ">
                <thead>
                    <tr>
                        <th>{{ __('vendor.vendor_user_id') }}</th>
                        <th> {{ __('vendor.vendor_user_name') }} </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendor_user as $item)
                        <tr>
                            <td> {{ $item->user_id }} </td>
                            <td> {{ $item->user_name }} </td>
                            <td>
                                {{-- <button onclick="deleteItem(this)" data-id="{{ $item->user_id }}"
                                    class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Delete</button> --}}
                                <form action="{{ route('vendor_user_delete', [$item->user_id, $vendor_id]) }}"
                                    method="post" id="delete-form-{{ $item->user_id }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" class="del-button" data-item-id="{{ $item->user_id }}"
                                        data-name="{{ $item->user_name }}">
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

    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">

                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                @php
                    $user_info = DB::table('user_info')
                        ->select('user_id', 'user_name')
                        ->groupBy('user_id', 'user_name')
                        ->get();
                @endphp
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form class="space-y-4" id="vendor_user_f" method="post">
                        @csrf
                        <input type="text" class=" sr-only" name="vendor_id" value=" {{ $vendor_id }} ">
                        <div>
                            <label for="vendor_user" class="label_input"> {{ __('vendor.vendor_user_id') }} </label>
                            <select name="user_id" id="vendor_user_id" class="input_text" required>
                                <option disabled selected><--></option>
                                @foreach ($user_info as $item)
                                    <option value="{{ $item->user_id }}" data-user-name="{{ $item->user_name }}">
                                        {{ $item->user_id }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="vendor_user_name" class="label_input"> {{ __('vendor.vendor_user_name') }}
                            </label>
                            <input type="text" id="vendor_user_name" name="vendor_user_name" class="input_text"
                                required>
                        </div>
                        <button id="user_vendor_save" class="submit_btn">{{ __('menu.button.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('vendor_user_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var userName = selectedOption.getAttribute('data-user-name');

        // Set the corresponding user_name in the text input
        document.getElementById('vendor_user_name').value = userName;
    });
</script>
<script type="module">
    $(document).ready(function() {
        // เมื่อคลิกปุ่มที่มี id="saveButton"
        $('#user_vendor_save').on('click', function(e) {
            e.preventDefault(); // หยุดการทำงานของ submit แบบปกติ

            // ใช้ FormData เพื่อจับข้อมูลจากฟอร์ม
            var formData = new FormData($('#vendor_user_f')[0]);

            // ส่งข้อมูลไปยัง Route ที่กำหนดโดยใช้ Ajax
            $.ajax({
                url: '{{ route('vendor_user') }}', // URL ที่จะส่งข้อมูลไป
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

        // ปิด Modal เมื่อคลิกปุ่มปิด
        $('[data-modal-hide="vendor_gp_modal"]').on('click', function() {
            $('#vendor_gp_modal').addClass('hidden');
        });
    });
</script>
