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
        {{ __('menu.card_promo_add') }}
    </a>
@endsection

@section('page_title')
    {{ __('menu.card_promo_add') }}
@endsection

@section('form-section')
    <form id="promo_form" action="{{ route('card-promotion.store') }}" method="post">
        @csrf
        <div class="grid gap-6 mb-4 md:grid-cols-3 border-b-2 border-gray-200 py-4">
            <div>
                <label for="promo_code" class="label_input"> {{ __('card_promo.promo_code') }} </label>
                <input type="text" id="promo_code" name="promo_code" maxlength="10" placeholder="..." class="input_text"
                    value="" required />
                @error('promo_code')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="promo_desc" class=" label_input"> {{ __('card_promo.promo_desc') }} </label>
                <input type="text" id="promo_desc" name="promo_desc" class="input_text " value="" required />
                @error('promo_desc')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="promo_seq" class=" label_input"> {{ __('card_promo.promo_seq') }} </label>
                <input type="text" id="promo_seq" name="promo_seq" placeholder=" 1, 2" class="input_text" value=""
                    required />
                @error('promo_seq')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="start_date" class=" label_input"> {{ __('card_promo.start_date') }} </label>
                <input type="date" id="start_date" name="start_date" class="input_text" />
                @error('start_date')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="end_date" class=" label_input">{{ __('card_promo.end_date') }}</label>
                <input type="date" id="end_date" name="end_date" class="input_text" />
                @error('end_date')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
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
                    <input type="time" id="start_time" name="start_time" class="input_text" value="00:00" />
                    @error('start_time')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                            {{ $message }}
                        </p>
                    @enderror
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
                    <input type="time" id="end_time" name="end_time" class="input_text" value="00:00" />
                    @error('end_time')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                            {{ $message }}
                        </p>
                    @enderror
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
        <div class="mb-4 border-b  border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-gray-200 rounded-t-lg" id="condiction_tab"
                        data-tabs-target="#condiction" type="button" role="tab" aria-controls="condiction"
                        aria-selected="false"> {{ __('card_promo.condiction_tab') }} </button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg" id="condiction" role="tabpanel" aria-labelledby="condiction_tab">
                <div class="flex flex-row border border-gray-200 rounded-lg p-7">
                    <div class="grid grid-cols-1 lg:grid-cols-3 w-full h-auto ">
                        <div class=" rounded-lg shadow  p-4 md:p-6 mt-2 m-2">
                            <h2 class="text-md font-semibold"></h2>
                            <section class="mt-2">
                                <input id="default-checkbox" type="hidden" name="expense_owner" value="N">
                                <input id="expense_owner" type="checkbox" name="expense_owner" value="Y"
                                    {{ old('expense_owner') == 'Y' ? 'checked' : '' }} class="checkbox_input">
                                <label for="expense_owner"
                                    class="label_checkbox">{{ __('card_promo.expense_owner') }}</label>
                            </section>
                            <section class="mt-2">
                                <input id="default-checkbox" type="hidden" name="req_refno" value="N">
                                <input id="req_refno" type="checkbox" name="req_refno" value="Y"
                                    {{ old('req_refno') == 'Y' ? 'checked' : '' }} class="checkbox_input">
                                <label for="req_refno" class="label_checkbox">{{ __('card_promo.req_refno') }}</label>
                            </section>
                        </div>
                        <div class=" rounded-lg shadow  p-4 md:p-6 mt-2 m-2">
                            <h2 class="text-md font-semibold">การซื้อ</h2>
                            <section class="mt-2">
                                <label for="buy_amt" class=" label_input">{{ __('card_promo.buy_amt') }}</label>
                                <input type="text" id="buy_amt" name="buy_amt" class="input_text " value=""
                                    required />
                                @error('buy_amt')
                                    <p class="mt-2 text-sm text-red-600 "><span
                                            class="font-medium">{{ __('menu.is_warning') }}</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </section>
                            <section class="mt-2">
                                <label for="get_amt" class=" label_input">{{ __('card_promo.get_amt') }}</label>
                                <input type="text" id="get_amt" name="get_amt" class="input_text " value=""
                                    required />
                                @error('get_amt')
                                    <p class="mt-2 text-sm text-red-600 "><span
                                            class="font-medium">{{ __('menu.is_warning') }}</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </section>
                            <section class="mt-2">
                                <label for="get_point" class=" label_input">{{ __('card_promo.get_point') }}</label>
                                <input type="text" id="get_point" name="get_point" class="input_text "
                                    value="" required />
                                @error('get_point')
                                    <p class="mt-2 text-sm text-red-600 "><span
                                            class="font-medium">{{ __('menu.is_warning') }}</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </section>

                        </div>
                        <div class=" rounded-lg shadow  p-4 md:p-6 mt-2 m-2">
                            <h2 class="text-md font-semibold">{{ __('card_promo.adjust') }}</h2>
                            <section class="mt-2">
                                <label for="adj_amt" class=" label_input">{{ __('card_promo.adj_amt') }}</label>
                                <input type="text" id="adj_amt" name="adj_amt" class="input_text " value=""
                                    required />
                                @error('adj_amt')
                                    <p class="mt-2 text-sm text-red-600 "><span
                                            class="font-medium">{{ __('menu.is_warning') }}</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </section>
                            <section class="mt-2">
                                <label for="adjget_amt" class=" label_input">{{ __('card_promo.adjget_amt') }}</label>
                                <input type="text" id="adjget_amt" name="adjget_amt" class="input_text "
                                    value="" required />
                                @error('adjget_amt')
                                    <p class="mt-2 text-sm text-red-600 "><span
                                            class="font-medium">{{ __('menu.is_warning') }}</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </section>
                            <section class="mt-2">
                                <label for="adjget_point"
                                    class=" label_input">{{ __('card_promo.adjget_point') }}</label>
                                <input type="text" id="adjget_point" name="adjget_point" class="input_text "
                                    value="" required />
                                @error('adjget_point')
                                    <p class="mt-2 text-sm text-red-600 "><span
                                            class="font-medium">{{ __('menu.is_warning') }}</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </section>
                            <section class="mt-2">
                                <input id="default-checkbox" type="hidden" name="promo_topup_verify" value="N">
                                <input id="promo_topup_verify" type="checkbox" name="promo_topup_verify" value="Y"
                                    {{ old('promo_topup_verify') == '1' ? 'checked' : '' }} class="checkbox_input">
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
                                        {{ old('mon_day') == 'Y' ? 'checked' : '' }} class="checkbox_input">
                                    <label for="mon_day" class="label_checkbox">{{ __('card_promo.mon_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="tue_day" value="N">
                                    <input id="tue_day" type="checkbox" name="tue_day" value="Y"
                                        {{ old('tue_day') == 'Y' ? 'checked' : '' }} class="checkbox_input">
                                    <label for="tue_day" class="label_checkbox">{{ __('card_promo.tue_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="wed_day" value="N">
                                    <input id="wed_day" type="checkbox" name="wed_day" value="Y"
                                        {{ old('wed_day') == 'Y' ? 'checked' : '' }} class="checkbox_input">
                                    <label for="wed_day" class="label_checkbox">{{ __('card_promo.wed_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="thu_day" value="N">
                                    <input id="thu_day" type="checkbox" name="thu_day" value="Y"
                                        {{ old('thu_day') == 'Y' ? 'checked' : '' }} class="checkbox_input">
                                    <label for="thu_day" class="label_checkbox">{{ __('card_promo.thu_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="fri_day" value="N">
                                    <input id="fri_day" type="checkbox" name="fri_day" value="Y"
                                        {{ old('fri_day') == 'Y' ? 'checked' : '' }} class="checkbox_input">
                                    <label for="fri_day" class="label_checkbox">{{ __('card_promo.fri_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="sat_day" value="N">
                                    <input id="sat_day" type="checkbox" name="sat_day" value="Y"
                                        {{ old('sat_day') == 'Y' ? 'checked' : '' }} class="checkbox_input">
                                    <label for="sat_day" class="label_checkbox">{{ __('card_promo.sat_day') }}</label>
                                </section>
                                <section class="mt-2">
                                    <input id="default-checkbox" type="hidden" name="sun_day" value="N">
                                    <input id="sun_day" type="checkbox" name="sun_day" value="Y"
                                        {{ old('sun_day') == 'Y' ? 'checked' : '' }} class="checkbox_input">
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
                            value="{{ old('expire_day') }}" />
                    </div>
                    <div>
                        <label for="pio_rity" class="label_input">{{ __('card_promo.priority') }}</label>
                        <input type="text" id="pio_rity" name="priority" class="input_text "
                            value="{{ old('priority') }}" />
                    </div>
                    <div>
                        <label for="deposit" class="label_input">{{ __('card_promo.deposit') }}</label>
                        <input type="text" id="deposit" name="deposit" class="input_text "
                            value="{{ old('deposit') }}" />
                    </div>
                    <div>
                        <label for="expire_checkby" class=" label_input">{{ __('card_promo.expire_checkby') }}</label>
                        <select name="expire_checkby" class="input_text" id="expire_checkby"
                            onchange="handleSelectChange()">
                            <option value="1">{{ __('card_promo.expire_check_1') }}</option>
                            <option value="2">{{ __('card_promo.expire_check_2') }}</option>
                            <option value="3">{{ __('card_promo.expire_check_3') }}</option>
                            <option id="input_opt" value="4">{{ __('card_promo.expire_check_4') }}</option>
                            <option id="input_opt" value="5">{{ __('card_promo.expire_check_5') }}</option>
                        </select>
                    </div>
                    <div id="weekday" style="display: none;">
                        <label for="expire_date" class=" label_input"> {{ __('card_promo.choose_day') }} </label>
                        <select name="expire_weekday" class="input_text" id="weekday_input">
                            <option value=" " selected>{{ __('card_promo.choose_emp') }} </option>
                            <option value="1">{{ __('card_promo.sun_day') }}</option>
                            <option value="2">{{ __('card_promo.mon_day') }}</option>
                            <option value="3">{{ __('card_promo.tue_day') }}</option>
                            <option value="4">{{ __('card_promo.wed_day') }}</option>
                            <option value="5">{{ __('card_promo.thu_day') }}</option>
                            <option value="6">{{ __('card_promo.fri_day') }}</option>
                            <option value="7">{{ __('card_promo.sat_day') }}</option>
                        </select>
                    </div>
                    <div id="date_input" style="display: none;">
                        <label for="expire_date" class=" label_input"> {{ __('card_promo.type_date') }} </label>
                        <input type="date" id="expire_date" value=" " name="expire_date" class="input_text" />
                    </div>
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
            <span class="font-medium text-xl">!{{ __('menu.is_warning') }}</span> {{ $errors->first() }}
        </div>
    @endif
@endsection
@section('js-scripts')
    <script type="module">
        $(document).ready(function() {
            $('#promo_form').validate({
                rules: {
                    promo_code: "required",
                    promo_desc: "required",
                    promo_seq: "required",
                    start_date: "required",
                    end_date: "required",
                    start_time: "required",
                    end_time: "required",
                    buy_amt: "required",
                    get_amt: "required",
                    get_point: "required",
                    adj_amt: "required",
                    adjget_amt: "required",
                    adjget_point: "required",
                },
                messages: {
                    promo_code: `{{ __('card_promo.promo_code_valid') }}`,
                    promo_desc: `{{ __('card_promo.promo_desc_valid') }}`,
                    promo_seq: `{{ __('card_promo.promo_seq_valid') }}`,
                    start_date: `{{ __('card_promo.start_date_valid') }}`,
                    end_date: `{{ __('card_promo.end_date_valid') }}`,
                    start_time: `{{ __('card_promo.start_time_valid') }}`,
                    end_time: `{{ __('card_promo.end_time_valid') }}`,
                    buy_amt: `{{ __('card_promo.buy_amt_valid') }}`,
                    get_amt: `{{ __('card_promo.get_amt_valid') }}`,
                    get_point: `{{ __('card_promo.get_point_valid') }}`,
                    adj_amt: `{{ __('card_promo.adj_amt_valid') }}`,
                    adjget_amt: `{{ __('card_promo.adjget_amt_valid') }}`,
                    adjget_point: `{{ __('card_promo.adjget_point_valid') }}`,
                }
            });
        });
    </script>
    {{-- @vite(['resources/js/card_promo.js']) --}}
    <script src="/js/card_promo/card_promo.js"></script>
@endsection
