@vite(['resources/css/app.css', 'resources/js/app.js'])

@php
    $promo_dis = DB::table('vendor_info')
        ->select(
            'vendor_id',
            'typediscount',
            'discountamt',
            'cur_discount',
            'def_discount',
            'use_discount',
            'discount_bdate',
            'discount_btime',
            'discount_edate',
            'discount_etime',
        )
        ->where('vendor_id', $vendor_id)
        ->first();
@endphp

{{-- @dd($promo_dis) --}}
<div class="flex justify-between items-center">
    <section>
        <form id="vendor_promo_f" method="post">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-6 border border-gray-200 rounded-lg p-3">
                <div class="w-full h-auto">
                    <section class="mt-4">
                        <label for="typediscount" class="label_input"> {{ __('vendor.typediscount') }} </label>
                        {{-- <input type="text" id="typediscount" name="typediscount" class="input_text" value="{{ $promo_dis->typediscount }}"> --}}
                        <select name="typediscount" id="typediscount" class="input_text" disabled>
                            <option value="0" @if ($promo_dis->typediscount == 0) selected @endif>
                                {{ __('vendor.typediscount_0') }} </option>
                            <option value="1" @if ($promo_dis->typediscount == 1) selected @endif>
                                {{ __('vendor.typediscount_1') }} </option>
                            <option value="2" @if ($promo_dis->typediscount == 2) selected @endif>
                                {{ __('vendor.typediscount_2') }} </option>
                        </select>
                    </section>
                    <section class="mt-4">
                        <label for="discountamt" class="label_input"> {{ __('vendor.discountamt') }} </label>
                        <input type="text" id="discountamt" name="discountamt" class="input_text" disabled
                            value="{{ $promo_dis->discountamt }}">
                    </section>
                    <section class="mt-4">
                        <label for="cur_discount" class="label_input"> {{ __('vendor.cur_discount') }} </label>
                        <input type="text" id="cur_discount" name="cur_discount" class="input_text" disabled
                            value="{{ $promo_dis->cur_discount }}">
                    </section>
                    <section class="mt-4">
                        <label for="def_discount" class="label_input"> {{ __('vendor.def_discount') }} </label>
                        <input type="text" id="def_discount" name="def_discount" class="input_text" disabled
                            value="{{ $promo_dis->def_discount }}">
                    </section>
                    <section class="mt-4">
                        <label for="use_discount" class="label_input"> {{ __('vendor.use_discount') }} </label>
                        <input type="text" id="use_discount" name="use_discount" class="input_text" disabled
                            value="{{ $promo_dis->use_discount }}">
                    </section>
                    <section class="mt-4 grid grid-col grid-cols-2 gap-10">
                        <section>
                            <label for="discount_bdate" class="label_input"> {{ __('vendor.discount_bdate') }} </label>
                            <input type="date" id="discount_bdate" name="discount_bdate" class="input_text" disabled
                                value="{{ !empty($promo_dis->discount_bdate) ? date('Y-m-d', strtotime($promo_dis->discount_bdate)) : '-' }}">
                        </section>
                        <section>
                            <label for="discount_btime" class="label_input"> {{ __('vendor.discount_btime') }} </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="time" id="discount_btime" name="discount_btime" class="input_text" disabled
                                    value="{{ !empty($promo_dis->discount_btime) ? date('H:i', strtotime($promo_dis->discount_btime)) : '-' }}" />
                            </div>
                        </section>
                        <section>
                            <label for="discount_edate" class="label_input"> {{ __('vendor.discount_edate') }} </label>
                            <input type="date" id="discount_edate" name="discount_edate" class="input_text" disabled
                                value="{{ !empty($promo_dis->discount_edate) ? date('Y-m-d', strtotime($promo_dis->discount_edate)) : '-' }}" />
                        </section>
                        <section>
                            <label for="discount_etime" class="label_input"> {{ __('vendor.discount_etime') }} </label>
                            <div class="relative">
                                <div
                                    class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="time" id="discount_etime" name="discount_etime" class="input_text" disabled
                                    value="{{ !empty($promo_dis->discount_etime) ? date('H:i', strtotime($promo_dis->discount_etime)) : '-' }}" />
                            </div>
                        </section>
                    </section>
                </div>
                <div class="">
                    {{-- <button id="saveButton" class="submit_btn">{{ __('menu.button.save') }}</button> --}}
                    {{-- <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button> --}}

                </div>
            </div>
        </form>
    </section>
</div>
<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('vendor_promo_f');
        const saveButton = document.getElementById('saveButton');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitForm();
        });

        function submitForm() {
            // Disable submit button to prevent double submission
            saveButton.disabled = true;

            // Get form data
            const formData = new FormData(form);

            // Get the form action URL
            const url = form.getAttribute('action');

            // Show loading state
            saveButton.innerHTML = 'กำลังบันทึก...';

            // Make Ajax request
            fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Show success message without confirmButtonText
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกสำเร็จ',
                            text: 'ข้อมูลถูกบันทึกเรียบร้อยแล้ว',
                            showConfirmButton: false,
                            timer: 1000,
                        }).then(() => {
                            // Optionally reload page or update UI
                            window.location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'เกิดข้อผิดพลาดในการบันทึกข้อมูล');
                    }
                })
                .catch(error => {
                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.message || 'กรุณาลองใหม่อีกครั้ง',
                    });
                })
                .finally(() => {
                    // Re-enable submit button and restore original text
                    saveButton.disabled = false;
                    saveButton.innerHTML = document.querySelector('button.submit_btn').textContent;
                });
        }
    });
</script>
<script>
    function cancel() {
        localStorage.clear();
    }
</script>
