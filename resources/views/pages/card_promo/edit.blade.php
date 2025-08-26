@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.card_promo') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('card-promotion.index') }}" class="first_bc_a" id="index_page">
        {{ __('menu.card_promo') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.card_promo_edit') }}
    </a>
@endsection

@section('page_title')
    {{ __('menu.card_promo_edit') }}
@endsection

@section('form-section')
    <form id="promo_form" action="{{ route('card-promotion.update', $card_promo->promo_code) }}" method="post">
        @csrf
        @method('PUT')
        <div class="grid gap-6 mb-4 md:grid-cols-3 border-b-2 border-gray-200 py-4">
            <div>
                <label for="promo_code" class="label_input"> {{ __('card_promo.promo_code') }} </label>
                <input type="text" id="promo_code" maxlength="10" placeholder="..." class="input_text"
                    value="{{ $card_promo->promo_code }}" readonly disabled />
            </div>
            <div>
                <label for="promo_desc" class=" label_input"> {{ __('card_promo.promo_desc') }} </label>
                <input type="text" id="promo_desc" name="promo_desc" class="input_text "
                    value="{{ $card_promo->promo_desc }}" required />
            </div>
            <div>
                <label for="promo_seq" class=" label_input"> {{ __('card_promo.promo_seq') }} </label>
                <input type="text" id="promo_seq" name="promo_seq" placeholder=" 1, 2" class="input_text"
                    value="{{ $card_promo->promo_seq }}" required />
            </div>
            <div>
                <label for="start_date" class=" label_input"> {{ __('card_promo.start_date') }} </label>
                <input type="date" id="start_date" name="start_date" class="input_text"
                    value="{{ date('Y-m-d', strtotime($card_promo->start_date)) }}" />
            </div>
            <div>
                <label for="end_date" class=" label_input">{{ __('card_promo.end_date') }}</label>
                <input type="date" id="end_date" name="end_date" class="input_text"
                    value="{{ date('Y-m-d', strtotime($card_promo->end_date)) }}" />
            </div>
            {{-- <div>
                <label for="countries" class="label_input ">ใช้ราคา</label>
                <select id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full">
                    <option selected>ราคาโปรโมชั่น</option>
                    <option value="US">ราคาพิเศษ #1</option>
                </select>
            </div>
            <div>
                <label for="countries" class="label_input ">แสดงข้อมูล KIOSK </label>
                <select id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full">
                    <option value="" selected>ไม่แสดง</option>
                    <option value="#">แสดง</option>
                </select>
            </div> --}}
            <div>
                <label for="start_time" class=" label_input">{{ __('card_promo.start_time') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="time" id="start_time" name="start_time" class="input_text"
                        value="{{ date('H:i', strtotime($card_promo->start_time)) }}" />
                </div>
            </div>
            <div>
                <label for="end_time" class="label_input">{{ __('card_promo.end_time') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="time" id="end_time" name="end_time" class="input_text"
                        value="{{ date('H:i', strtotime($card_promo->end_time)) }}" />
                </div>
            </div>
            {{-- <div>
                <label for="gp" class=" mb-2 text-sm font-medium text-gray-900">ปรับ GP ขาย</label>
                <input type="text" id="gp" name="" placeholder=" 0.00"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full"
                    value="" required />
            </div>
            <div>
                <label for="key-search" class=" mb-2 text-sm font-medium text-gray-900">Key Search</label>
                <input type="text" id="key-search" name="" placeholder=" "
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full"
                    value="" required />
            </div> --}}
        </div>
        {{-- TAP --}}
        <div class="mb-4 border-b  border-gray-200 ">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">

                    <button class="inline-block p-4 border-b-2 border-gray-200 rounded-t-lg hover:text-gray-600 hover:border-gray-300 "
                        id="condiction_tab" data-tabs-target="#condiction" type="button" role="tab"
                        aria-controls="condiction" aria-selected="false">{{ __('card_promo.condiction_tab') }}</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-gray-200 rounded-t-lg hover:text-gray-600 hover:border-gray-300 "
                        id="text_promo_tab" data-tabs-target="#text_promo" type="button" role="tab"
                        aria-controls="text_promo" aria-selected="false">{{ __('card_promo.text_promo_tab') }}</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content" class="border-b border-gray-200 mb-5">
            <div class="hidden p-4 rounded-lg" id="condiction" role="tabpanel" aria-labelledby="condiction_tab">
                <div class="flex flex-row border border-gray-200 rounded-lg p-7">
                    <div class="grid grid-cols-1 lg:grid-cols-3 w-full h-auto ">
                        <div class=" rounded-lg shadow  p-4 md:p-6 mt-2 m-2">
                            <h2 class="text-md font-semibold"></h2>
                            <section class="mt-2">
                                <input id="default-checkbox" type="hidden" name="expense_owner" value="N">
                                <input id="expense_owner" type="checkbox" name="expense_owner" value="Y"
                                    @if ($card_promo->expense_owner === 'Y') checked @endif class="checkbox_input">
                                <label for="expense_owner"
                                    class="label_checkbox">{{ __('card_promo.expense_owner') }}</label>
                            </section>
                            <section class="mt-2">
                                <input id="default-checkbox" type="hidden" name="req_refno" value="N">
                                <input id="req_refno" type="checkbox" name="req_refno" value="Y"
                                    class="checkbox_input" @if ($card_promo->expense_owner === 'Y') checked @endif>
                                <label for="req_refno" class="label_checkbox">{{ __('card_promo.req_refno') }}</label>
                            </section>
                        </div>
                        <div class=" rounded-lg shadow  p-4 md:p-6 mt-2 m-2">
                            <h2 class="text-md font-semibold">การซื้อ</h2>
                            <section class="mt-2">
                                <label for="buy_amt" class=" label_input">{{ __('card_promo.buy_amt') }}</label>
                                <input type="text" id="buy_amt" name="buy_amt" class="input_text "
                                    value="{{ $card_promo->buy_amt }}" required />
                            </section>
                            <section class="mt-2">
                                <label for="get_amt" class=" label_input">{{ __('card_promo.get_amt') }}</label>
                                <input type="text" id="get_amt" name="get_amt" class="input_text "
                                    value="{{ $card_promo->get_amt }}" required />
                            </section>
                            <section class="mt-2">
                                <label for="get_point" class=" label_input">{{ __('card_promo.get_point') }}</label>
                                <input type="text" id="get_point" name="get_point" class="input_text "
                                    value="{{ $card_promo->get_point }}" required />
                            </section>

                        </div>
                        <div class=" rounded-lg shadow  p-4 md:p-6 mt-2 m-2">
                            <h2 class="text-md font-semibold">{{ __('card_promo.adjust') }}</h2>
                            <section class="mt-2">
                                <label for="adj_amt" class=" label_input">{{ __('card_promo.adj_amt') }}</label>
                                <input type="text" id="adj_amt" name="adj_amt" class="input_text "
                                    value="{{ $card_promo->adj_amt }}" required />
                            </section>
                            <section class="mt-2">
                                <label for="adjget_amt" class=" label_input">{{ __('card_promo.adjget_amt') }}</label>
                                <input type="text" id="adjget_amt" name="adjget_amt" class="input_text "
                                    value="{{ $card_promo->adjget_amt }}" required />
                            </section>
                            <section class="mt-2">
                                <label for="adjget_point"
                                    class=" label_input">{{ __('card_promo.adjget_point') }}</label>
                                <input type="text" id="adjget_point" name="adjget_point" class="input_text "
                                    value="{{ $card_promo->adjget_point }}" required />
                            </section>
                            <section class="mt-2">
                                <input id="default-checkbox" type="hidden" name="promo_topup_verify" value="N">
                                <input id="promo_topup_verify" type="checkbox" name="promo_topup_verify" value="Y"
                                    @if ($card_promo->promo_topup_verify === 'Y') checked @endif class="checkbox_input">
                                <label for="promo_topup_verify"
                                    class="label_checkbox">{{ __('card_promo.promo_topup_verify') }}</label>
                            </section>
                        </div>
                        <div class=" rounded-lg shadow  p-4 md:p-6 mt-2 ">
                            <h2 class="text-md font-semibold"> {{ __('card_promo.day_use') }} </h2>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="mon_day" value="N">
                                    <input id="mon_day" type="checkbox" name="mon_day" value="Y"
                                        @if ($day_split['mon_day'] == 'Y') checked @endif class="checkbox_input">
                                    <label for="mon_day" class="label_checkbox">{{ __('card_promo.mon_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="tue_day" value="N">
                                    <input id="tue_day" type="checkbox" name="tue_day" value="Y"
                                        @if ($day_split['tue_day'] == 'Y') checked @endif class="checkbox_input">
                                    <label for="tue_day" class="label_checkbox">{{ __('card_promo.tue_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="wed_day" value="N">
                                    <input id="wed_day" type="checkbox" name="wed_day" value="Y"
                                        @if ($day_split['wed_day'] == 'Y') checked @endif class="checkbox_input">
                                    <label for="wed_day" class="label_checkbox">{{ __('card_promo.wed_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="thu_day" value="N">
                                    <input id="thu_day" type="checkbox" name="thu_day" value="Y"
                                        @if ($day_split['thu_day'] == 'Y') checked @endif class="checkbox_input">
                                    <label for="thu_day" class="label_checkbox">{{ __('card_promo.thu_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="fri_day" value="N">
                                    <input id="fri_day" type="checkbox" name="fri_day" value="Y"
                                        @if ($day_split['fri_day'] == 'Y') checked @endif class="checkbox_input">
                                    <label for="fri_day" class="label_checkbox">{{ __('card_promo.fri_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="sat_day" value="N">
                                    <input id="sat_day" type="checkbox" name="sat_day" value="Y"
                                        @if ($day_split['sat_day'] == 'Y') checked @endif class="checkbox_input">
                                    <label for="sat_day" class="label_checkbox">{{ __('card_promo.sat_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="sun_day" value="N">
                                    <input id="sun_day" type="checkbox" name="sun_day" value="Y"
                                        @if ($day_split['sun_day'] == 'Y') checked @endif class="checkbox_input">
                                    <label for="sun_day" class="label_checkbox">{{ __('card_promo.sun_day') }}</label>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid gap-6 mb-4 md:grid-cols-3 mt-3">
                    <div>
                        <label for="expire_day" class="label_input">{{ __('card_promo.expire_day') }}</label>
                        <input type="text" id="expire_day" name="expire_day" class="input_text "
                            value="{{ $card_promo_expire->expire_day }}" />
                    </div>
                    <div>
                        <label for="pio_rity" class="label_input">{{ __('card_promo.priority') }}</label>
                        <input type="text" id="pio_rity" name="priority" class="input_text "
                            value="{{ $card_promo_expire->priority }}" />
                    </div>
                    <div>
                        <label for="deposit" class="label_input">{{ __('card_promo.deposit') }}</label>
                        <input type="text" id="deposit" name="deposit" class="input_text "
                            value="{{ $card_promo_expire->deposit }}" />
                    </div>
                    <div>
                        <label for="expire_checkby" class=" label_input">{{ __('card_promo.expire_checkby') }}</label>
                        <select name="expire_checkby" class="input_text" id="expire_checkby"
                            onchange="handleSelectChange()">
                            <option value="1" @if ($card_promo_expire->expire_checkby == 1) selected @endif>
                                {{ __('card_promo.expire_check_1') }}</option>
                            <option value="2" @if ($card_promo_expire->expire_checkby == 2) selected @endif>
                                {{ __('card_promo.expire_check_2') }}</option>
                            <option value="3" @if ($card_promo_expire->expire_checkby == 3) selected @endif>
                                {{ __('card_promo.expire_check_3') }}</option>
                            <option id="input_opt" value="4" @if ($card_promo_expire->expire_checkby == 4) selected @endif>
                                {{ __('card_promo.expire_check_4') }}</option>
                            <option id="input_opt" value="5" @if ($card_promo_expire->expire_checkby == 5) selected @endif>
                                {{ __('card_promo.expire_check_5') }}</option>
                        </select>
                    </div>
                    <div id="weekday" style="display: none;">
                        <label for="expire_date" class=" label_input"> {{ __('card_promo.choose_day') }} </label>
                        <select name="expire_weekday" class="input_text" id="weekday_input">
                            <option value=" " selected>{{ __('card_promo.choose_emp') }} </option>
                            <option value="1" @if ($card_promo_expire->expire_weekday == 1) selected @endif>
                                {{ __('card_promo.sun_day') }}</option>
                            <option value="2" @if ($card_promo_expire->expire_weekday == 2) selected @endif>
                                {{ __('card_promo.mon_day') }}</option>
                            <option value="3" @if ($card_promo_expire->expire_weekday == 3) selected @endif>
                                {{ __('card_promo.tue_day') }}</option>
                            <option value="4" @if ($card_promo_expire->expire_weekday == 4) selected @endif>
                                {{ __('card_promo.wed_day') }}</option>
                            <option value="5" @if ($card_promo_expire->expire_weekday == 5) selected @endif>
                                {{ __('card_promo.thu_day') }}</option>
                            <option value="6" @if ($card_promo_expire->expire_weekday == 6) selected @endif>
                                {{ __('card_promo.fri_day') }}</option>
                            <option value="7" @if ($card_promo_expire->expire_weekday == 7) selected @endif>
                                {{ __('card_promo.sat_day') }}</option>
                        </select>
                    </div>
                    <div id="date_input" style="display: none;">
                        <label for="expire_date" class=" label_input"> {{ __('card_promo.type_date') }} </label>
                        <input type="date" id="expire_date"
                            value="{{ date('Y-m-d', strtotime($card_promo_expire->expire_date)) }}" name="expire_date"
                            class="input_text" />
                    </div>
                </div>
            </div>

            <div class="hidden p-4 rounded-lg" id="text_promo" role="tabpanel" aria-labelledby="text_promo_tab">
                <div class=" my-3 ">
                    <div class="flex space-x-2 mb-2">
                        <div>
                            <h3 class="text-md font-semibold">{{ __('card_promo.text_promo_tab') }}</h3>
                        </div>
                        <div>
                            <button class="modal_button_add" type="button" data-modal-target="authentication-modal"
                                data-modal-toggle="authentication-modal">เพิ่ม</button>
                        </div>
                    </div>
                    <table class="table-data">
                        <thead>
                            <tr>
                                <th scope="col"> {{ __('card_promo.text_1') }} </th>
                                <th scope="col"> {{ __('card_promo.text_2') }}</th>
                                <th scope="col"> {{ __('card_promo.show_barcode') }}</th>
                                <th scope="col"> {{ __('card_promo.start_date') }}</th>
                                <th scope="col"> {{ __('card_promo.end_date') }}</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($promo_print as $print)
                                <tr>
                                    <td> {{ $print->description1 }} </td>
                                    <td> {{ $print->description2 }}</td>
                                    <td> {{ $print->barcode }}</td>
                                    <td> {{ $print->start_date }}</td>
                                    <td> {{ $print->valid_date }}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB --}}
        <div>
            <button type="submit" id="submit_button" class="submit_btn">{{ __('menu.button.save') }}</button>
            <a href="{{ route('card-promotion.index') }}" id="cancel_button">
                <button type="button" class="cancel_btn">
                    {{ __('menu.button.cancel') }}
                </button>
            </a>
        </div>
    </form>
    @if ($errors->any())
        <div class="error_alert" role="alert">
            <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
        </div>
    @endif

    <div id="authentication-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="bg-white rounded-lg shadow-sm">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b  rounded-t border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ __('card_promo.expireprint_title') }}
                    </h3>
                    <!-- close button -->
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="authentication-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-5 md:p-5">
                    <form id="promo_expire_print_form" method="post">
                        @csrf
                        <div class="p-3">
                            <div class="mt-2">
                                <label for="print_start" class="label_input">
                                    {{ __('card_promo.start_date') }} </label>
                                <input type="date" id="print_start" name="start_date" class="input_text"
                                    value="{{ date('Y-m-d', strtotime($card_promo->start_date)) }}" readonly />
                            </div>
                            <div class="mt-2">
                                <label for="print_end" class="label_input">{{ __('card_promo.end_date') }}</label>
                                <input type="date" id="print_end" name="valid_date" class="input_text"
                                    value="{{ date('Y-m-d', strtotime($card_promo->end_date)) }}" readonly />
                            </div>
                            <div class="mt-2">
                                <label for="decs_1" class="label_input">{{ __('card_promo.text_1') }}</label>
                                <input type="text" class="input_text" name="description1">
                            </div>
                            <div class="mt-2">
                                <label for="decs_1" class="label_input">{{ __('card_promo.text_2') }}</label>
                                <input type="text" class="input_text" name="description2">
                            </div>
                            <div class="mt-2">
                                <label for="decs_1" class="label_input">{{ __('card_promo.show_barcode') }}</label>
                                <input type="text" class="input_text" name="barcode">
                            </div>
                        </div>
                        <div>
                            <button id="saveButton" class="submit_btn">{{ __('menu.button.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-scripts')
    
    <script type="module">
        $(document).ready(function() {
            // เมื่อคลิกปุ่มที่มี id="saveButton"
            $('#saveButton').on('click', function(e) {
                e.preventDefault(); // หยุดการทำงานของ submit แบบปกติ

                // ใช้ FormData เพื่อจับข้อมูลจากฟอร์ม
                var formData = new FormData($('#promo_expire_print_form')[0]);

                // ส่งข้อมูลไปยัง Route ที่กำหนดโดยใช้ Ajax
                $.ajax({
                    url: '{{ route('card_promotion_print', ['id' => $card_promo->promo_code]) }}', // URL ที่จะส่งข้อมูลไป
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
                        $('#authentication-modal').addClass('hidden');

                        // หากต้องการรีเฟรชข้อมูล หรือทำอะไรก่อนปิดฟอร์ม
                        window.location.reload(); // รีโหลดหน้า (ถ้าต้องการ)
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: `{{ __('menu.edit_is_failed') }}` + error,
                            text: response.message,
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
            $('[data-modal-hide="authentication-modal"]').on('click', function() {
                $('#authentication-modal').addClass('hidden');
            });
        });
    </script>
    <script type="text/javascript">
        function handleSelectChange() {
            var selectedValue = document.getElementById("expire_checkby").value;
            var weekday = document.getElementById("weekday");
            var date_input = document.getElementById("date_input");

            // เปรียบเทียบค่าที่เลือกจาก <select>
            if (selectedValue === "4") {
                weekday.style.display = "block";
                date_input.style.display = "none";
            } else if (selectedValue === "5") {
                weekday.style.display = "none";
                date_input.style.display = "block";
            } else {
                weekday.style.display = "none";
                date_input.style.display = "none";
            }
        }
        window.onload = function() {
            handleSelectChange();
        };
    </script>
@endsection
