@vite(['resources/css/app.css', 'resources/js/app.js'])

@php
    $vendor_func = DB::table('vendor_info')
        ->select('vendor_id', 'vendor_function')
        ->where('vendor_id', $vendor_id)
        ->first();
    $vendor_s = str_split($vendor_func->vendor_function);
    $vendor_split_f = [
        'func_0' => $vendor_s[0] ?? '',
        'func_1' => $vendor_s[1] ?? '',
        'func_2' => $vendor_s[2] ?? '',
        'func_3' => $vendor_s[3] ?? '',
        'func_4' => $vendor_s[4] ?? '',
        'func_5' => $vendor_s[5] ?? '',
        'func_6' => $vendor_s[6] ?? '',
    ];
@endphp
{{-- @dd($vendor_s) --}}

<div class="grid lg:grid-cols-4 grid-cols-1">
    <section>
        {{-- <form action="{{ route('vendor_function', ['id' => $vendor_id]) }}" method="post"> --}}
        <form action="{{ route('vendor_function_update', ['id' => $vendor_id]) }}" id="for_ven_function" method="post">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-3 border border-gray-200 rounded-lg p-5">
                <section class="mt-2">
                    <input id="default-checkbox" type="hidden" name="vendor_function_1" value="0">
                    <input id="vendor_function_1" type="checkbox" name="vendor_function_1" value="1" disabled
                        @if ($vendor_split_f['func_1'] == 1) checked @endif class="checkbox_input">
                    <label for="vendor_function_1" class="label_checkbox">{{ __('vendor.def_1') }}</label>
                </section>
                <section class="mt-2">
                    <input id="default-checkbox" type="hidden" name="vendor_function_2" value="0">
                    <input id="vendor_function_2" type="checkbox" name="vendor_function_2" value="1" disabled
                        @if ($vendor_split_f['func_2'] == 1) checked @endif class="checkbox_input">
                    <label for="vendor_function_2" class="label_checkbox">{{ __('vendor.def_2') }}</label>
                </section>
                <section class="mt-2">
                    <input id="default-checkbox" type="hidden" name="vendor_function_3" value="0">
                    <input id="vendor_function_3" type="checkbox" name="vendor_function_3" value="1" disabled
                        @if ($vendor_split_f['func_3'] == 1) checked @endif class="checkbox_input">
                    <label for="vendor_function_3" class="label_checkbox">{{ __('vendor.def_3') }}</label>
                </section>
                <section class="mt-2 w-48">
                    <label for="vendor_function_4" class="label_input">{{ __('vendor.def_4') }}</label>
                    <select name="vendor_function_4" id="vendor_function_4" class="input_text" disabled>
                        <option value=" " @if ($vendor_split_f['func_4'] == null) selected @else disabled hidden @endif>
                            ไม่ได้เลือก</option>
                        <option value="1" @if ($vendor_split_f['func_4'] == 1) selected @endif>1</option>
                        <option value="2" @if ($vendor_split_f['func_4'] == 2) selected @endif>2</option>
                        <option value="3" @if ($vendor_split_f['func_4'] == 3) selected @endif>3</option>
                        <option value="4" @if ($vendor_split_f['func_4'] == 4) selected @endif>4</option>
                        <option value="5" @if ($vendor_split_f['func_4'] == 5) selected @endif>5</option>
                        <option value="6" @if ($vendor_split_f['func_4'] == 6) selected @endif>6</option>
                        <option value="7" @if ($vendor_split_f['func_4'] == 7) selected @endif>7</option>
                        <option value="8" @if ($vendor_split_f['func_4'] == 8) selected @endif>8</option>
                        <option value="9" @if ($vendor_split_f['func_4'] == 9) selected @endif>9</option>
                        <option value="10" @if ($vendor_split_f['func_4'] == 10) selected @endif>10</option>
                    </select>
                </section>
                <section class="mt-2 w-48">
                    <label for="vendor_function_5" class="label_input">{{ __('vendor.def_5') }}</label>
                    <select name="vendor_function_5" id="vendor_function_5" class="input_text" disabled>
                        <option value=" "
                            @if ($vendor_split_f['func_5'] == null) selected @else disabled hidden @endif>
                            ไม่ได้เลือก</option>
                        <option value="1" @if ($vendor_split_f['func_5'] == 1) selected @endif>1</option>
                        <option value="2" @if ($vendor_split_f['func_5'] == 2) selected @endif>2</option>
                        <option value="3" @if ($vendor_split_f['func_5'] == 3) selected @endif>3</option>
                        <option value="4" @if ($vendor_split_f['func_5'] == 4) selected @endif>4</option>
                        <option value="5" @if ($vendor_split_f['func_5'] == 5) selected @endif>5</option>
                        <option value="6" @if ($vendor_split_f['func_5'] == 6) selected @endif>6</option>
                        <option value="7" @if ($vendor_split_f['func_5'] == 7) selected @endif>7</option>
                        <option value="8" @if ($vendor_split_f['func_5'] == 8) selected @endif>8</option>
                        <option value="9" @if ($vendor_split_f['func_5'] == 9) selected @endif>9</option>
                        <option value="10" @if ($vendor_split_f['func_5'] == 10) selected @endif>10</option>
                    </select>
                </section>
                <section class="mt-2 sr-only">
                    <input id="default-checkbox" type="hidden" name="vendor_function_6" value="0">
                    <input id="default-checkbox" type="hidden" name="vendor_function_7" value="0">
                    <input id="vendor_function_6" type="checkbox" name="vendor_function_6" value="1" disabled
                        @if ($vendor_split_f['func_6'] == 1) checked @endif class="checkbox_input">
                    <label for="vendor_function_6" class="label_checkbox">{{ __('vendor.def_3') }}</label>
                </section>
                <div class="mt-3">
                    <!-- ปรับปุ่มให้ใช้ onclick -->
                    {{-- <button id="saveButton" class="submit_btn">{{ __('menu.button.save') }}</button> --}}
                </div>
            </div>
        </form>
    </section>
</div>

<script>
    function back() {
        localStorage.clear();
        window.history.back(); // ใช้ย้อนกลับไปยังหน้าก่อนหน้า
    }
</script>
