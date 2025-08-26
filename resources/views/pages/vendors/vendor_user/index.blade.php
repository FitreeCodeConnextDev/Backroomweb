@vite(['resources/css/app.css', 'resources/js/app.js'])

<section class="">
    <div class="grid grid-cols-1 gap-6 border border-gray-200 rounded-lg p-5">
        {{-- <div>
            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                class="modal_button_add" type="button">
                เพิ่ม
            </button>
        </div> --}}
        <div>
            <table class="table-data overflow-x-auto">
                <thead>
                    <tr>
                        <th>{{ __('vendor.vendor_user_id') }}</th>
                        <th> {{ __('vendor.vendor_user_name') }} </th>
                        {{-- <th> Action </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendor_user as $item)
                        <tr>
                            <td> {{ $item->user_id }} </td>
                            <td> {{ $item->user_name }} </td>
                            {{-- <td>
                                <form action="" method="post" id="delete-form-{{ $vendor_id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button id="del-button" class="del-button" data-item-id="{{ $vendor_id }}"
                                        data-name="{{ $item->user_name }}">
                                        <svg class="w-[16px] h-[16px]" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.6"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                        </svg>
                                    </button>
                                </form>
                            </td> --}}
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
                            <select name="user_id" id="vendor_user_id" class="input_text">
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
                        <button id="saveButton" class="submit_btn">{{ __('menu.button.save') }}</button>
                </div>
                </form>
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
