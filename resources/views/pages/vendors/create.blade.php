    @extends('layouts.createpage')
    @section('title_page')
        {{ __('menu.vendor_add') }}
    @endsection
    @section('breadcrumb-index')
        <a href="{{ route('vendor-page.index') }}" class="first_bc_a">
            {{ __('menu.vendor') }}
        </a>
    @endsection
    @section('breadcrumb-create-page')
        <a href="#" class="first_bc_a">
            {{ __('menu.vendor_add') }}
        </a>
    @endsection
    @section('page_title')
        {{ __('menu.vendor_add') }}
    @endsection
    @php
        $user_session = session('auth_user');
        $user_branch_id = $user_session['branch_id'];
    @endphp
    @section('form-section')
        <form id="vendor_form" action="{{ route('vendor-page.store') }}" onsubmit="SaveToLocal()" method="post">
            @csrf
            <div class="flex flex-row border border-gray-200 rounded-lg mt-3 ">
                <div class="grid grid-cols-1 lg:grid-cols-6 gap-3 p-7 w-full ">
                    @php
                        $select_vendor_id = DB::table('vendor_info')->max('vendor_id');
                        $vendor_ids = $select_vendor_id + 1;
                    @endphp
                    <div>
                        <label for="vendor_id" class="label_input"> {{ __('vendor.vendor_id') }} </label>
                        <input type="text" id="vendor_id" readonly name="vendor_id" class="input_text"
                            value="{{ $vendor_ids }}" maxlength="6">
                        @error('vendor_id')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="branch_id" class="label_input">{{ __('vendor.branch_id') }}</label>
                        <input type="text" readonly id="branch_id" name="branch_id" value="{{ $user_branch_id }}"
                            class="input_text" required>
                        @error('branch_id')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="term_id" class="label_input">{{ __('vendor.term_id') }}</label>
                        <select name="term_id" id="term_id" class="input_text" required>
                            <option value="000" selected>000</option>
                        </select>
                        @error('term_id')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="term_seq" class="label_input"> {{ __('vendor.term_seq') }} </label>
                        <input type="text" name="term_seq" id="term_seq" class="input_text">
                        @error('term_seq')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="issuedate" class="label_input"> {{ __('vendor.issuedate') }} </label>
                        <input type="date" name="issuedate" id="issuedate" class="input_text">
                        @error('issuedate')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="validdate" class="label_input"> {{ __('vendor.validdate') }} </label>
                        <input type="date" name="validdate" id="validdate" class="input_text">
                        @error('validdate')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="vendor_name" class="label_input"> {{ __('vendor.vendor_name') }} </label>
                        <input type="text" name="vendor_name" id="vendor_name" class="input_text">
                        @error('vendor_name')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="vendor_food" class="label_input"> {{ __('vendor.vendor_food') }} </label>
                        <input type="text" name="vendor_food" id="vendor_food" class="input_text">
                        @error('vendor_food')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="vendor_subfood" class="label_input"> {{ __('vendor.vendor_subfood') }} </label>
                        <input type="text" name="vendor_subfood" id="vendor_subfood" class="input_text">
                        @error('vendor_subfood')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="ar_sap" class="label_input"> {{ __('vendor.ar_sap') }} </label>
                        <input type="text" name="ar_sap" id="ar_sap" class="input_text">
                        @error('ar_sap')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="vendorno" class="label_input"> {{ __('vendor.vendor_no') }} </label>
                        <input type="text" name="vendorno" id="vendorno" class="input_text">
                        @error('vendorno')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="productno" class="label_input"> {{ __('vendor.product_no') }} </label>
                        <input type="text" name="productno" id="productno" class="input_text">
                        @error('productno')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="pmino" class="label_input"> {{ __('vendor.pmino') }} </label>
                        <input type="text" name="pmino" id="pmino" class="input_text">
                        @error('pmino')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="taxbranch" class="label_input"> {{ __('vendor.taxbranch') }} </label>
                        <input type="text" name="taxbranch" id="taxbranch" class="input_text">
                        @error('taxbranch')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="owner_shop" class="label_input"> {{ __('vendor.owner_shop') }} </label>
                        <select class="input_text" name="owner_shop" id="owner_shop">
                            <option value="N">
                                {{ __('vendor.vendor_normal') }}</option>
                            <option value="Y">
                                {{ __('vendor.vendor_center') }}</option>
                        </select>
                        @error('owner_shop')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="vendor_locate" class="label_input"> {{ __('vendor.vendor_locate') }} </label>
                        <input type="text" name="vendor_locate" id="vendor_locate" class="input_text">
                        @error('vendor_locate')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="serialno" class="label_input"> {{ __('vendor.serial_no') }} </label>
                        <input type="text" name="serialno" id="serialno" class="input_text">
                        @error('serialno')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="ipaddress" class="label_input"> {{ __('vendor.ip_addr') }} </label>
                        <input type="text" name="ipaddress" id="ipaddress" class="input_text">
                        @error('ipaddress')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="txnno" class="label_input"> {{ __('vendor.txnno') }} </label>
                        <input type="text" name="txnno" id="txnno" value="1" class="input_text">
                        @error('txnno')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="vendor_batchno" class="label_input"> {{ __('vendor.vendor_batchno') }} </label>
                        <input type="text" name="vendor_batchno" value="1" id="vendor_batchno" class="input_text">
                        @error('vendor_batchno')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="billcount" class="label_input"> {{ __('vendor.vendor_billcount') }} </label>
                        <input type="text" name="billcount" value="1" id="billcount" class="input_text">
                        @error('billcount')
                            <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }}
                                </span>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-2">
                <button type="submit" class="submit_btn"> {{ __('menu.button.save') }} </button>
                {{-- <button type="button" class="cancel_btn" onclick="back()"> {{ __('menu.button.cancel') }} </button> --}}
                <a href="{{ route('vendor-page.index') }}" onclick="back()">
                    <button type="button" class="cancel_btn">
                        {{ __('menu.button.cancel') }}
                    </button>
                </a>
            </div>
        </form>
        {{-- @if ($errors->any())
            <div class="error_alert" role="alert">
                <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
            </div>
        @endif --}}
    @endsection
    @section('js-scripts')
        <script src="/js/vendor_create.js"></script>
        <script>
            $('#vendor_form').validate({
                rules: {

                    branch_id: "required",
                    term_id: "required",
                    term_seq: "required",
                    issuedate: "required",
                    validdate: "required",
                    vendor_name: "required",
                    vendor_food: "required",
                    vendorno: "required",
                    productno: "required",
                    owner_shop: "required",
                    txnno: "required",
                    vendor_batchno: "required",
                    billcount: "required",
                },
                messages: {

                    branch_id: `{{ __('vendor.branch_id_required') }}`,
                    term_id: `{{ __('vendor.term_id_required') }}`,
                    term_seq: `{{ __('vendor.term_seq_required') }}`,
                    issuedate: `{{ __('vendor.issuedate_required') }}`,
                    validdate: `{{ __('vendor.validdate_required') }}`,
                    vendor_name: `{{ __('vendor.vendor_name_required') }}`,
                    vendor_food: `{{ __('vendor.vendor_food_required') }}`,
                    vendorno: `{{ __('vendor.vendorno_required') }}`,
                    productno: `{{ __('vendor.productno_required') }}`,
                    owner_shop: `{{ __('vendor.owner_shop_required') }}`,
                    txnno: `{{ __('vendor.txnno_required') }}`,
                    vendor_batchno: `{{ __('vendor.vendor_batchno_required') }}`,
                    billcount: `{{ __('vendor.vendor_billcount_required') }}`,

                }
            });
        </script>
    @endsection
