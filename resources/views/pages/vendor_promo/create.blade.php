@extends('layouts.createpage')

@section('breadcrumb-index')
    <a href="{{ route('vendor-promotion.index') }}" class="first_bc_a">
        {{ __('menu.vendor_promotion') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.vendor_promo_add') }}
    </a>
@endsection
@section('title_page')
    {{ __('menu.vendor_promo_add') }}
@endsection
@section('form-section')
    <form action="{{ route('vendor-promotion.store') }}" id="vendor_promo" method="post">
        @csrf
        <div class="grid_page">
            <div>
                <label for="promo_code" class="label_input">{{ __('vendor_promo.promo_code') }}</label>
                <input type="text" id="promo_code" name="promo_code" maxlength="2" placeholder="..." class="input_text"
                    value="{{ old('promo_code') }}" required />
                @error('promo_code')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="promo_desc" class=" label_input">{{ __('vendor_promo.promo_desc') }}</label>
                <input type="text" id="promo_desc" name="promo_desc" placeholder=" สงกรานต์, New Year Fest"
                    class="input_text " value="{{ old('promo_desc') }}" required />
                @error('promo_desc')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="start_date" class="label_input">{{ __('vendor_promo.start_date') }}</label>
                <input type="date" id="start_date" name="start_date" class="input_text" />
                @error('start_date')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="label_input">{{ __('vendor_promo.end_date') }}</label>
                <input type="date" id="end_date" name="end_date" class="input_text" />
                @error('end_date')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="start_time" class="label_input">{{ __('vendor_promo.start_time') }}</label>
                <div class="relative">
                    <div class="time_svg">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="time" id="start_time" name="start_time" class="input_time"
                        required />
                    @error('start_time')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="end_time" class="label_input">{{ __('vendor_promo.end_time') }}</label>
                <div class="relative">
                    <div class="time_svg">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="time" id="end_time" name="end_time" class="input_time" />
                    @error('end_time')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            {{-- การให้ส่วนลด --}}
            <div>
                <div class="bg-white rounded-lg shadow p-4 md:p-6 mt-2">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ __('vendor_promo.discount') }}</h3>
                        <hr class="mb-4">
                        <section class=" my-3">
                            <label for="use_discount" class="label_input">{{ __('vendor_promo.use_discount') }}</label>
                            <select id="use_discount" name="use_discount" class="input_text p-2.5">
                                <option selected value="0">{{ __('vendor_promo.use_discount_0') }}</option>
                                <option value="1">{{ __('vendor_promo.use_discount_1') }}</option>
                                <option value="2">{{ __('vendor_promo.use_discount_2') }}</option>
                            </select>
                            @error('use_discount')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </section>
                        <section class=" my-3">
                            <label for="discountrate" class="label_input">{{ __('vendor_promo.discountrate') }}</label>
                            <input type="number" id="discountrate" name="discountrate" value="1.00"
                                class="input_text " />
                            @error('discountrate')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </section>
                        <section class=" my-3">
                            <label for="discountamt" class="label_input">{{ __('vendor_promo.discountamt') }}</label>
                            <input type="number" id="discountamt" name="discountamt" value="1.00"
                                class="input_text " />
                            @error('discountamt')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </section>
                    </div>
                </div>
            </div>
            {{-- การให้ส่วนลด --}}

            {{-- การเพิ่มมูลค่า --}}
            <div>
                <div class="bg-white rounded-lg shadow p-4 md:p-6 mt-2">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ __('vendor_promo.use_p') }}
                        </h3>
                        <hr class="mb-4">
                        <section class=" my-3">
                            <label for="promo-use" class="label_input">{{ __('vendor_promo.use_point') }}</label>
                            <select id="countries" name="use_point" class="input_text p-2.5">
                                <option selected value="N">{{ __('vendor_promo.use_point_N') }}</option>
                                <option value="Y">{{ __('vendor_promo.use_point_Y') }}</option>
                            </select>
                        </section>
                        <section class=" my-3">
                            <label for="use_min" class="label_input">{{ __('vendor_promo.use_min') }}</label>
                            <input type="number" id="use_min" name="use_min" value="1.00"
                                class="input_text " />
                        </section>
                        <section class=" my-3">
                            <label for="add_point" class="label_input">{{ __('vendor_promo.add_point') }}</label>
                            <input type="number" id="add_point" name="add_point" value="1.00"
                                class="input_text " />
                        </section>
                    </div>
                </div>
            </div>
            {{-- การเพิ่มมูลค่า --}}
        </div>
        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('vendor-promotion.index') }}">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>

    </form>
@endsection
@section('js-scripts')
    <script type="module">
        $('#vendor_promo').validate({
            rules: {
                promo_code: "required",
                promo_desc: "required",
                start_date: "required",
                start_time: "required",
                end_date: "required",
                end_time: "required",
                use_discount: "required",
                discountrate: "required",
                discountamt: "required",
                use_min: "required",
                add_point: "required"
            },
            messages: {
                promo_code: `{{ __('vendor_promo.promo_code_valid') }}`,
                promo_desc: `{{ __('vendor_promo.promo_desc_valid') }}`,
                start_date: `{{ __('vendor_promo.start_date_valid') }}`,
                start_time: `{{ __('vendor_promo.start_time_valid') }}`,
                end_date: `{{ __('vendor_promo.end_date_valid') }}`,
                end_time: `{{ __('vendor_promo.end_time_valid') }}`,
                discountrate: `{{ __('vendor_promo.discountrate_valid') }}`,
                discountamt: `{{ __('vendor_promo.discountamt_valid') }}`,
                use_min: `{{ __('vendor_promo.use_min_valid') }}`,
                add_point: `{{ __('vendor_promo.add_point_valid') }}`,
            }
        });
    </script>
@endsection
