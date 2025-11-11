@extends('layouts.createpage')

@section('breadcrumb-index')
    <a href="{{ route('vendor-promotion.index') }}" class="first_bc_a">
        {{ __('menu.vendor_promotion') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.vendor_promo_edit') }}
    </a>
@endsection
@section('title_page')
    {{ __('menu.vendor_promo_edit') }}
@endsection
@section('form-section')
    <form action="{{ route('vendor-promotion.update', $vendor_promo->promo_code) }}" id="vendor_promo" method="post">
        @csrf
        @method('PUT')
        <div class="grid_page">
            <div>
                <label for="promo_desc" class="label_input">{{ __('vendor_promo.promo_code') }}</label>
                <input type="text" id="promo_desc" name="promo_code" placeholder="0001, 0002 ..." class="input_text"
                    value="{{ $vendor_promo->promo_code }}" readonly />
                @error('promo_code')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="promo_desc" class=" label_input">{{ __('vendor_promo.promo_desc') }}</label>
                <input type="text" id="promo_desc" name="promo_desc" placeholder=" สงกรานต์, New Year Fest"
                    class="input_text " value="{{ $vendor_promo->promo_desc }}" required />
                @error('promo_desc')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="start_date" class="label_input">{{ __('vendor_promo.start_date') }}</label>
                {{-- <input type="date" placeholder="dd/mm/yyyy" pattern="\d{2}/\d{2}/\d{4}" id="start-date" name="start_date" class="input_text" value="{{ $vendor_promo->start_date }}" /> --}}
                <input type="date" id="start_date" name="start_date"
                    value="{{ date('Y-m-d', strtotime($vendor_promo->start_date)) }}" pattern="\d{2}/\d{2}/\d{4}"
                    class="input_text">
                @error('start_date')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="end_date" class="label_input">{{ __('vendor_promo.end_date') }}</label>
                <input type="date" value="{{ date('Y-m-d', strtotime($vendor_promo->end_date)) }}"
                    pattern="\d{2}/\d{2}/\d{4}" id="end_date" name="end_date" class="input_text" />
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
                    <input type="time" id="start_time" name="start_time" min='1:30' max='2:30' class="input_time"
                        value="{{ date('H:i', strtotime($vendor_promo->start_time)) }}" placeholder="00:00" />
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
                    <input type="time" id="end_time" name="end_time" min='1:30' max='2:30' class="input_time"
                        value="{{ date('H:i', strtotime($vendor_promo->end_time)) }}" placeholder="00:00" />
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
                        <h3 class="text-lg font-semibold text-gray-900">
                            {{ __('vendor_promo.discount') }}
                        </h3>
                        <hr class="mb-4">
                        <section class=" my-3">
                            <label for="use_discount" class="label_input">{{ __('vendor_promo.use_discount') }}</label>
                            <select id="use_discount" name="use_discount" class="input_text p-2.5">
                                <option value="0" @if ($vendor_promo->use_discount == 0) selected @endif>
                                    {{ __('vendor_promo.use_discount_0') }}</option>
                                <option value="1" @if ($vendor_promo->use_discount == 1) selected @endif>
                                    {{ __('vendor_promo.use_discount_1') }}
                                </option>
                                <option value="2" @if ($vendor_promo->use_discount == 2) selected @endif>
                                    {{ __('vendor_promo.use_discount_2') }}
                                </option>
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
                            <input type="number" id="discountrate" name="discountrate"
                                value="{{ $vendor_promo->discountrate }}" class="input_text " />
                            @error('discountrate')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </section>
                        <section class=" my-3">
                            <label for="discountamt" class="label_input">{{ __('vendor_promo.discountamt') }}</label>
                            <input type="number" id="discountamt" name="discountamt"
                                value="{{ $vendor_promo->discountamt }}" class="input_text " />
                        </section>
                        @error('discountamt')
                            <p class="mt-2 text-sm text-red-600 "><span
                                    class="font-medium">{{ __('menu.is_warning') }}</span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- การให้ส่วนลด --}}

            {{-- การเพิ่มมูลค่า --}}
            <div>
                <div class="bg-white rounded-lg shadow p-4 md:p-6 mt-2">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                            {{ __('vendor_promo.use_p') }}</h3>
                        <hr class="mb-4">
                        <section class=" my-3">
                            <label for="promo-use" class="label_input">{{ __('vendor_promo.use_point') }}</label>
                            <select id="countries" name="use_point" class="input_text p-2.5">
                                <option value="N" @if ($vendor_promo->use_point == 'N') selected @endif>ไม่ใช้</option>
                                <option value="Y" @if ($vendor_promo->use_point == 'Y') selected @endif>ใช้</option>
                            </select>
                            @error('use_point')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </section>
                        <section class=" my-3">
                            <label for="use_min" class="label_input">{{ __('vendor_promo.use_min') }}</label>
                            <input type="number" id="use_min" name="use_min" value="{{ $vendor_promo->use_min }}"
                                class="input_text" />
                            @error('use_min')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </section>
                        <section class=" my-3">
                            <label for="add_point" class="label_input">{{ __('vendor_promo.add_point') }}</label>
                            <input type="number" id="add_point" name="add_point"
                                value="{{ $vendor_promo->add_point }}" class="input_text" />
                            @error('add_point')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
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
