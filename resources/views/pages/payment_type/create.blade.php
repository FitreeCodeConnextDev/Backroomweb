@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.payment_types') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('payment_type.index') }}" class="first_bc_a" id="cancel_button">
        {{ __('menu.payment_types') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.payment_types_add') }}
    </a>
@endsection

@section('page_title')
    {{ __('menu.payment_types_add') }}
@endsection
@section('form-section')
    <form id="payment_form" action="{{ route('payment_type.store') }}" method="post">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <div>
                <label for="payment_code" class="label_input"> {{ __('payment_type.payment_code') }} </label>
                <input type="text" class="input_text" id="payment_code" maxlength="10" name="payment_code">
                @error('payment_code')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="py-7">
                <label class="inline-flex items-center cursor-pointer">
                    <input id="default-checkbox" type="hidden" name="refund" value="N">
                    <input type="checkbox" name="refund" value="Y" class="sr-only peer">
                    <div
                        class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span
                        class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('payment_type.refund') }}</span>
                </label>
            </div>
            <div>
                <label for="payment_group" class="label_input"> {{ __('payment_type.payment_group') }} </label>
                <select name="payment_group" name="payment_group" id="payment_group" class="input_text">
                    @foreach ($payment_g as $item)
                        <option value="{{ $item->payment_group }}"> {{ $item->description }} </option>
                    @endforeach

                </select>
                @error('payment_group')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="payment_desc" class="label_input">{{ __('payment_type.payment_desc') }}</label>
                <input type="text" class="input_text" id="payment_desc" name="payment_desc">
                @error('payment_desc')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="payment_seq" class="label_input">{{ __('payment_type.payment_seq') }}</label>
                <input type="text" class="input_text" id="payment_seq" name="payment_seq">
                @error('payment_seq')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="acc_sap" class="label_input">{{ __('payment_type.acc_sap') }}</label>
                <input type="text" class="input_text" name="acc_sap" id="acc_sap">
                @error('acc_sap')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex flex-row border border-gray-200 rounded-lg p-7">
                <div class="grid grid-cols-1 gap-9">
                    <div class="mt-3">
                        <h1>
                            <h2 class="text-md font-semibold">{{ __('payment_type.interfaces') }}</h2>
                        </h1>
                    </div>
                    <div>
                        <input type="text" name="interface_port" class="sr-only" value="0">
                        <input id="no_con" type="radio" value="0" name="interface_type" checked
                            class="radio_input">
                        <input type="text" class=" sr-only" name="interface_header" value=" ">
                        <label for="no_con" class="label_checkbox">{{ __('payment_type.interfaces_no') }}</label>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mt-1">
                        <div>
                            <input id="edc" type="radio" value="1" name="interface_type" class="radio_input">
                            <label for="edc" class="label_checkbox">{{ __('payment_type.interfaces_edc') }}</label>
                        </div>
                        <div>
                            <input type="text" placeholder="Port" name="interface_port" class="input_text" id="edc_input"
                                disabled>
                            @error('interface_port')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
                            <input type="text" class=" sr-only" name="interface_header" value=" ">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mt-1">
                        <div>
                            <input id="rabbit" type="radio" value="2" name="interface_type"
                                class="radio_input">
                            <label for="rabbit"
                                class="label_checkbox">{{ __('payment_type.interfaces_rabbit') }}</label>
                        </div>
                        <div>
                            <input type="text" placeholder="Port" name="interface_port" class="input_text"
                                id="rabbit_input" disabled>
                            @error('interface_port')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror

                            <input type="text" class=" sr-only" name="interface_header" value=" ">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 mt-1">
                        <div>
                            <input id="qr_payment" type="radio" value="3" name="interface_type"
                                class="radio_input">
                            <label for="qr_payment" class="label_checkbox">{{ __('payment_type.interfaces_qr') }}</label>
                        </div>
                        <div>
                            <input type="text" placeholder="Port" name="interface_port"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-36 p-2.5"
                                id="qr_input" disabled>
                        </div>
                        <div>
                            <input type="text" placeholder="QR Header" name="interface_header"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-36 p-2.5"
                                id="qr_input_header" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" id="submit_button" class="submit_btn"> {{ __('menu.button.save') }} </button>
            <a href="{{ route('payment_type.index') }}" id="cancel_button">
                <button type="button" class="cancel_btn">
                    {{ __('menu.button.cancel') }}
                </button>
            </a>
        </div>
    </form>
@endsection
@section('js-scripts')
    <script>
        // Select radio buttons and input fields
        const noConRadio = document.getElementById('no_con');
        const edcRadio = document.getElementById('edc');
        const rabbitRadio = document.getElementById('rabbit');
        const qrRadio = document.getElementById('qr_payment');

        const edcInput = document.getElementById('edc_input');
        const rabbitInput = document.getElementById('rabbit_input');
        const qrInput = document.getElementById('qr_input');
        const qrInputHeader = document.getElementById('qr_input_header');

        // Function to handle radio button change
        function handleRadioChange() {
            // Disable and clear all input fields initially
            edcInput.disabled = true;
            rabbitInput.disabled = true;
            qrInput.disabled = true;
            qrInputHeader.disabled = true;

            edcInput.value = '';
            rabbitInput.value = '';
            qrInput.value = '';
            qrInputHeader.value = '';

            // If "no_con" is selected, clear the text fields and keep them disabled
            if (noConRadio.checked) {
                return; // No need to enable any input field
            }
            // Enable the corresponding input field based on the selected radio button
            if (edcRadio.checked) {
                edcInput.disabled = false;
            } else if (rabbitRadio.checked) {
                rabbitInput.disabled = false;
            } else if (qrRadio.checked) {
                qrInput.disabled = false;
                qrInputHeader.disabled = false;
            }
        }

        // Add event listeners to radio buttons
        noConRadio.addEventListener('change', handleRadioChange);
        edcRadio.addEventListener('change', handleRadioChange);
        rabbitRadio.addEventListener('change', handleRadioChange);
        qrRadio.addEventListener('change', handleRadioChange);
    </script>
    <script>
        $('#payment_form').validate({
            rules: {
                payment_code: "required",
                payment_group: "required",
                payment_desc: "required",
                payment_seq: "required",
            },
            messages: {
                payment_code: `{{ __('payment_type.payment_code_valid') }}`,
                payment_group: `{{ __('payment_type.payment_group_valid') }}`,
                payment_desc: `{{ __('payment_type.payment_desc_valid') }}`,
                payment_seq: `{{ __('payment_type.payment_seq_valid') }}`,

            }
        });
    </script>
@endsection
