@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    $vendor_linepay = DB::table('vendorpromotionlinepay_info')->where('vendor_id', $vendor_id)->first();
    $product_info = DB::table('product_info')
        ->select('product_id', 'product_desc')
        ->where('rabbit_discount', 'Y')
        ->get();

    // Check if $vendor_linepay is not null before processing
    if ($vendor_linepay && !empty($vendor_linepay->day_use)) {
        $day_split = str_split($vendor_linepay->day_use);
        $day_use = [
            'monday' => $day_split[0] ?? '',
            'tuesday' => $day_split[1] ?? '',
            'wednesday' => $day_split[2],
            'thursday' => $day_split[3],
            'friday' => $day_split[4],
            'saturday' => $day_split[5],
            'sunday' => $day_split[6],
        ];
    } else {
        $day_use = '';
    }
@endphp
<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

    <div class=" mt-3 border border-gray-200 rounded-lg p-5">
        <h1 class=" text-xl font-semibold"> {{ __('vendor.vendor_linepay') }} </h1>
        <form action="" class="tabs_form" method="post">
            <div>
                <div class=" mt-4 grid grid-col grid-cols-2 gap-2">
                    <div>
                        <label for="start_date" class="label_input"> {{ __('vendor.start_date') }} </label>
                        <input type="date" name="start_date" class="input_text"
                            value="{{ $vendor_linepay && strtotime($vendor_linepay->start_date) ? date('Y-m-d', strtotime($vendor_linepay->start_date)) : '' }}"
                            readonly disabled>
                    </div>
                    <div>
                        <label for="" class="label_input"> {{ __('vendor.valid_date') }} </label>
                        <input type="date" name="valid_date" class="input_text"
                            value="{{ $vendor_linepay && strtotime($vendor_linepay->valid_date) ? date('Y-m-d', strtotime($vendor_linepay->valid_date)) : '' }}"
                            readonly disabled>
                    </div>
                    <section>
                        <label for="start_time" class="label_input"> {{ __('vendor.start_time') }} </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="time" id="start_time" name="start_time" class="input_text"
                                value="{{ $vendor_linepay && strtotime($vendor_linepay->start_date) ? date('H:i', strtotime($vendor_linepay->start_date)) : '' }}"
                                readonly disabled />
                        </div>
                    </section>
                    <section>
                        <label for="start_time" class="label_input"> {{ __('vendor.valid_time') }} </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 " aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="time" id="valid_time" name="valid_time" class="input_text"
                                value="{{ $vendor_linepay && strtotime($vendor_linepay->valid_date) ? date('H:i', strtotime($vendor_linepay->valid_date)) : '' }}"
                                readonly disabled />
                        </div>
                    </section>
                </div>
                <div class=" grid grid-flow-col grid-rows-4 gap-2 ">
                    <section class="mt-2">
                        <input id="default-checkbox" type="hidden" name="monday" value="0">
                        <input id="monday" type="checkbox" name="monday" value="1" readonly disabled
                            @if (isset($day_use['monday']) && $day_use['monday'] == 1) checked @endif class="checkbox_input">
                        <label for="monday" class="label_checkbox">{{ __('vendor.mon_day') }}</label>
                    </section>
                    <section class="mt-2">
                        <input id="default-checkbox" type="hidden" name="tuesday" value="0">
                        <input id="tuesday" type="checkbox" name="tuesday" value="1" readonly disabled
                            @if (isset($day_use['tuesday']) && $day_use['tuesday'] == 1) checked @endif class="checkbox_input">
                        <label for="tuesday" class="label_checkbox">{{ __('vendor.tue_day') }}</label>
                    </section>
                    <section class="mt-2">
                        <input id="default-checkbox" type="hidden" name="wednesday" value="0">
                        <input id="wednesday" type="checkbox" name="wednesday" value="1" readonly disabled
                            @if (isset($day_use['wednesday']) && $day_use['wednesday'] == 1) checked @endif class="checkbox_input">
                        <label for="wednesday" class="label_checkbox">{{ __('vendor.wed_day') }}</label>
                    </section>
                    <section class="mt-2">
                        <input id="default-checkbox" type="hidden" name="thursday" value="0">
                        <input id="thursday" type="checkbox" name="thursday" value="1" readonly disabled
                            @if (isset($day_use['thursday']) && $day_use['thursday'] == 1) checked @endif class="checkbox_input">
                        <label for="thursday" class="label_checkbox">{{ __('vendor.thu_day') }}</label>
                    </section>
                    <section class="mt-2">
                        <input id="default-checkbox" type="hidden" name="friday" value="0">
                        <input id="friday" type="checkbox" name="friday" value="1" readonly disabled
                            @if (isset($day_use['friday']) && $day_use['friday'] == 1) checked @endif class="checkbox_input">
                        <label for="friday" class="label_checkbox">{{ __('vendor.fri_day') }}</label>
                    </section>
                    <section class="mt-2">
                        <input id="default-checkbox" type="hidden" name="saturday" value="0">
                        <input id="saturday" type="checkbox" name="saturday" value="1" readonly disabled
                            @if (isset($day_use['saturday']) && $day_use['saturday'] == 1) checked @endif class="checkbox_input">
                        <label for="saturday" class="label_checkbox">{{ __('vendor.sat_day') }}</label>
                    </section>
                    <section class="mt-2">
                        <input id="default-checkbox" type="hidden" name="sunday" value="0">
                        <input id="sunday" type="checkbox" name="sunday" value="1" readonly disabled
                            @if (isset($day_use['sunday']) && $day_use['sunday'] == 1) checked @endif class="checkbox_input">
                        <label for="sunday" class="label_checkbox">{{ __('vendor.sun_day') }}</label>
                    </section>
                </div>
                <div class="mt-6">
                    <label for="amount_use" class="label_input"> {{ __('vendor.amount_use') }} </label>
                    <input type="text" class="input_text" name="amount_use" id="amount_use" readonly disabled
                        value="{{ $vendor_linepay->amount_use ?? '' }}">
                </div>
                <div class="mt-6">
                    <label for="product_id" class="label_input"> {{ __('vendor.product_id') }} </label>
                    <select class="input_text" name="product_id" id="product_id" readonly disabled>
                        <option value="" selected> {{ __('vendor.select_product') }} </option>
                        @foreach ($product_info as $product)
                            <option value="{{ $product->product_id }}"
                                @if (isset($vendor_linepay->product_id) && $vendor_linepay->product_id == $product->product_id) selected @endif>
                                {{ $product->product_desc }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4">
                {{-- <button class="saveButton submit_btn">{{ __('menu.button.save') }}</button> --}}
                {{-- <button type="reset" class="cancel_btn">{{ __('menu.button.cancel') }}</button> --}}
            </div>

        </form>
    </div>
</div>
