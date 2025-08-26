@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.branch_add') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('branch.index') }}" class="first_bc_a">
        {{ __('menu.branch') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.branch_add') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.branch_add') }}
@endsection

@section('form-section')
    <form action="{{ route('branch.store') }}" id="branch_form" method="post">
        @csrf
        <div class="grid gap-6 mb-4 grid-cols-1 lg:grid-cols-3">
            <div>
                <label for="branch_id" class="label_input">{{ __('branch.branch_id') }}</label>
                <input type="text" id="branch_id" maxlength="6" name="branch_id" placeholder="..." class="input_text"
                    value="" required />
                @error('branch_id')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="branch_name" class="label_input">{{ __('branch.branch_name') }}</label>
                <input type="text" id="branch_name" name="branch_name" placeholder=" Kevin, David" class="input_text "
                    value="" required />
                @error('branch_name')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div class="py-7">
                <label class="inline-flex items-center cursor-pointer">
                    <input id="default-checkbox" type="hidden" name="online" value="0">
                    <input type="checkbox" name="online" value="1" class="sr-only peer">
                    <div
                        class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                        {{ __('branch.branch_online') }} </span>
                </label>
            </div>
            <div>
                <label for="branch_addr1" class="label_input">{{ __('branch.branch_addr1') }}</label>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <div>
                        <input type="text" id="branch_addr1" name="branch_addr1" placeholder="..." class="input_text "
                            value="" required />
                        @error('branch_addr1')
                            <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                                </span>
                                {{ $message }} </p>
                        @enderror
                    </div>
                    <div>
                        <input type="text" id="branch_addr2" name="branch_addr2" class="input_text " value="" />
                    </div>
                </div>
            </div>
            <div>
                <label for="branch_tel" class=" label_input">{{ __('branch.branch_tel') }}</label>
                <input type="text" id="branch_tel" maxlength="10" name="branch_tel" placeholder="000-000-0000"
                    class="input_text " value="" required />
                @error('branch_tel')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="tax_id" class=" label_input">{{ __('branch.tax_id') }}</label>
                <input type="text" id="tax_id" maxlength="13" name="tax_id" placeholder="..." class="input_text "
                    value="" required />
                @error('tax_id')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="tax_name" class=" label_input">{{ __('branch.tax_name') }}</label>
                <input type="text" id="tax_name" name="tax_name" placeholder="..." class="input_text " value=""
                    required />
                @error('tax_name')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="tax_addr1" class="label_input">{{ __('branch.tax_addr1') }}</label>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <div>
                        <input type="text" id="tax_addr1" name="tax_addr1" placeholder="..." class="input_text "
                            value="" required />
                        @error('tax_addr1')
                            <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }}
                                </span>
                                {{ $message }} </p>
                        @enderror
                    </div>
                    <div>
                        <input type="text" id="tax_addr2" name="tax_addr2" class="input_text " value="" />
                    </div>
                </div>
            </div>
            <div>
                <label for="tax_name_e" class=" label_input">{{ __('branch.tax_name_e') }}</label>
                <input type="text" id="tax_name_e" name="tax_name_e" placeholder="..." class="input_text "
                    value="" />
            </div>
            <div>
                <label for="tax_addr1_e" class="label_input">{{ __('branch.tax_addr1_e') }}</label>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <div>
                        <input type="text" id="tax_addr1_e" name="tax_addr1_e" placeholder="..." class="input_text "
                            value="" />
                    </div>
                    <div>
                        <input type="text" id="tax_addr2_e" name="tax_addr2_e" class="input_text "
                            value="" />
                    </div>
                </div>
            </div>
            <div>
                <label for="ipaddress" class=" label_input">{{ __('branch.ipaddress') }}</label>
                <input type="text" class="input_text" name="ipaddress" id="ipaddress" placeholder="xxx.xxx.xxx.xxx"
                    pattern="^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$" />
                @error('branch_addr1')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="batchno" class=" label_input">{{ __('branch.batchno') }}</label>
                <input type="text" id="batchno" name="batchno" placeholder="78" class="input_text" value=""
                    required />
            </div>
            <div>
                <label for="businessdate" class="label_input">{{ __('branch.businessdate') }}</label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="businessdate" name="businessdate"
                    class="input_text" />
                @error('businessdate')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="deposit" class=" label_input">{{ __('branch.deposit') }}</label>
                <input type="text" id="deposit" name="deposit" placeholder="0.00" class="input_text "
                    value="0.00" required />
                @error('deposit')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="vatrate" class=" label_input">{{ __('branch.vatrate') }}</label>
                <input type="text" id="vatrate" name="vatrate" placeholder="0.00" value="7.00"
                    class="input_text " value="" required />
                @error('vatrate')
                    <p class="mt-2 text-sm text-red-600"><span class=" font-medium"> {{ __(__('menu.is_warning')) }} </span>
                        {{ $message }} </p>
                @enderror
            </div>
            <div>
                <label for="message1" class=" label_input">{{ __('branch.message1') }}</label>
                <input type="text" id="message1" name="message1" placeholder="..." class="input_text "
                    value="" />
            </div>
            <div>
                <label for="message2" class=" label_input">{{ __('branch.message2') }}</label>
                <input type="text" id="message2" name="message2" placeholder="..." class="input_text "
                    value="" />
            </div>
            <div>
                <label for="message3" class=" label_input">{{ __('branch.message3') }}</label>
                <input type="text" id="message3" name="message3" placeholder="..." class="input_text "
                    value="" />
            </div>
            <div>
                <label for="message4" class=" label_input">{{ __('branch.message4') }}</label>
                <input type="text" id="message4" name="message4" placeholder="..." class="input_text "
                    value="" />
            </div>

        </div>
        {{-- @if ($errors->any())
            <div class="error_alert" role="alert">
                <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
            </div>
        @endif --}}
        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('branch.index') }}">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection

@section('js-scripts')
    <script>
        $('#branch_form').validate({
            rules: {
                branch_id: {
                    required: true,
                    maxlength: 6
                },
                branch_name: {
                    required: true
                },
                branch_addr1: {
                    required: true
                },
                branch_tel: {
                    required: true,
                    maxlength: 10,
                    number: true
                },
                tax_id: {
                    required: true
                },
                tax_name: {
                    required: true
                },
                tax_addr1: {
                    required: true
                },
                batchno: {
                    required: true
                },
                businessdate: {
                    required: true
                },
            },
            messages: {
                branch_id: {
                    required: `{{ __('branch.branch_id_required') }}`,
                    maxlength: `{{ __('branch.branch_id_max') }}`
                },
                branch_name: {
                    required: `{{ __('branch.branch_name_required') }}`
                },
                branch_addr1: {
                    required: `{{ __('branch.branch_addr1_required') }}`
                },
                branch_tel: {
                    required: `{{ __('branch.branch_tel_required') }}`,
                    maxlength: `{{ __('branch.branch_tel_max') }}`,
                    number: `{{ __('branch.branch_tel_num') }}`
                },
                tax_id: {
                    required: `{{ __('branch.tax_id_required') }}`
                },
                tax_name: {
                    required: `{{ __('branch.tax_name_required') }}`
                },
                tax_addr1: {
                    required: `{{ __('branch.tax_addr1_required') }}`
                },
                batchno: {
                    required: `{{ __('branch.batchno_required') }}`
                },
                businessdate: {
                    required: `{{ __('branch.businessdate_required') }}`
                },
            }
        })
    </script>
@endsection
