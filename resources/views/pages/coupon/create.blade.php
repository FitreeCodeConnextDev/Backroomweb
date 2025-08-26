@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.coupons_add') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('coupons.index') }}" class="first_bc_a">
        {{ __('menu.coupons') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.coupons_add') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.coupons_add') }}
@endsection
@section('form-section')
    <form action="{{ route('coupons.store') }}" method="post" id="coupon_form">
        @csrf
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-4 mt-3">
            <div>
                <label for="coupon_id" class="label_input">{{ __('coupon.coupon_id') }}</label>
                <input type="text" name="coupon_id" id="coupon_id" class="input_text"
                    placeholder="{{ __('coupon.coupon_id') }}" required>
                @error('coupon_id')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="coupon_promo_code" class="label_input">{{ __('coupon.coupon_promo_code') }}</label>
                <select name="coupon_promo_code" id="coupon_promo_code" class="input_text">
                    <option value="">{{ __('coupon.select_coupon_promo_code') }}</option>
                    @foreach ($promo_code as $promo)
                        <option value="{{ $promo->promo_code }}">{{ $promo->promo_desc }}</option>
                    @endforeach
                </select>

            </div>
            <div>
                <label for="coupon_name" class="label_input">{{ __('coupon.coupon_name') }}</label>
                <input type="text" name="coupon_name" id="coupon_name" class="input_text"
                    placeholder="{{ __('coupon.coupon_name') }}" required>
                @error('coupon_name')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-4 ">
                    <div>
                        <label for="start_date" class="label_input">{{ __('coupon.coupon_start_date') }}</label>
                        <input type="date" name="start_date" id="start_date" class="input_text"
                            placeholder="{{ __('coupon.start_date') }}" required>
                        @error('start_date')
                            <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                                </span>
                                {{ $message }} </p>
                        @enderror
                    </div>
                    <div>
                        <label for="valid_date" class="label_input">{{ __('coupon.coupon_valid_date') }}</label>
                        <input type="date" name="valid_date" id="valid_date" class="input_text"
                            placeholder="{{ __('coupon.coupon_valid_date') }}" required>
                        @error('valid_date')
                            <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                                </span>
                                {{ $message }} </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div>
                <label for="coupon_countday" class="label_input">{{ __('coupon.coupon_countday') }}</label>
                <input type="text" name="coupon_countday" id="coupon_countday" class="input_text" value="0"
                    placeholder="{{ __('coupon.coupon_countday') }}">
                @error('coupon_countday')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="coupon_countall" class="label_input">{{ __('coupon.coupon_countall') }}</label>
                <input type="text" name="coupon_countall" id="coupon_countall" class="input_text" value="0"
                    placeholder="{{ __('coupon.coupon_countall') }}">
                @error('coupon_countall')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                        </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <div class="grid grid-cols-1 gap-4 mt-2">
                    <div class="flex space-x-3 lg:mt-5 mt-3">
                        <div>
                            <input type="hidden" name="coupon_limit" id="default-checkbox" value="N">
                            <input id="coupon_limit" name="coupon_limit" type="checkbox" value="Y"
                                class="checkbox_input">
                            <label for="coupon_limit" class="label_checkbox"> {{ __('coupon.coupon_limit') }} </label>
                        </div>
                        <div>
                            <input type="text" class="input_text" name="coupon_limitqty" id="coupon_limitqty"
                                value="0">
                            @error('coupon_limitqty')
                                <p class="mt-2 text-sm text-red-600"><span class=" font-medium">
                                        {{ __(__('menu.is_warning')) }}
                                    </span>
                                    {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex space-x-3 lg:mt-5 mt-3">
                        <div>
                            <input type="hidden" name="coupon_limitall" id="default-checkbox" value="N">
                            <input id="coupon_limitall" name="coupon_limitall" type="checkbox" value="Y"
                                class="checkbox_input">
                            <label for="coupon_limitall" class="label_checkbox"> {{ __('coupon.coupon_limit_all') }}
                            </label>

                        </div>
                        <div>
                            <input type="text" class="input_text" name="coupon_limitallqty" id="coupon_limitallqty"
                                value="0">
                            @error('coupon_limitallqty')
                                <p class="mt-2 text-sm text-red-600"><span class=" font-medium">
                                        {{ __(__('menu.is_warning')) }}
                                    </span>
                                    {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex space-x-3 lg:mt-5 mt-3">
                        <div>
                            <input type="hidden" name="print_tax" id="default-checkbox" value="N">
                            <input id="print_tax" name="print_tax" type="checkbox" value="Y"
                                class="checkbox_input">
                            <label for="print_tax" class="label_checkbox"> {{ __('coupon.print_tax') }}
                            </label>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
            <a href="{{ route('coupons.index') }}">
                <button type="button" class="cancel_btn">
                    {{ __('menu.button.cancel') }}
                </button>
            </a>
        </div>
        {{-- @if ($errors->any())
            <div class="error_alert" role="alert">
                <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
            </div>
        @endif --}}
    </form>
@endsection
@section('js-scripts')
    <script>
        $('#coupon_form').validate({
            rules: {
                coupon_id: {
                    required: true
                },
                coupon_name: {
                    required: true
                },
                start_date: {
                    required: true
                },
                valid_date: {
                    required: true
                },
                coupon_countday: {
                    required: true
                },
                coupon_countall: {
                    required: true
                },
                coupon_limitqty: {
                    required: true
                },
                coupon_limitallqty: {
                    required: true
                }
            },
            messages: {
                coupon_id: {
                    required: "{{ __('coupon.coupon_id_required') }}"
                },
                coupon_name: {
                    required: "{{ __('coupon.coupon_name_required') }}"
                },
                start_date: {
                    required: "{{ __('coupon.coupon_start_date_required') }}"
                },
                valid_date: {
                    required: "{{ __('coupon.coupon_valid_date_required') }}"
                },
                coupon_countday: {
                    required: "{{ __('coupon.coupon_countday_required') }}"
                },
                coupon_countall: {
                    required: "{{ __('coupon.coupon_countall_required') }}"
                },
                coupon_limitqty: {
                    required: "{{ __('coupon.coupon_limitqty_required') }}"
                },
                coupon_limitallqty: {
                    required: "{{ __('coupon.coupon_limitallqty_required') }}"
                }
            }
        })
    </script>
@endsection
