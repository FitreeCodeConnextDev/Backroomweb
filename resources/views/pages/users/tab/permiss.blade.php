<div class="p-4 md:p-6 mt-2">
    <div class="grid lg:grid-flow-col lg:grid-rows-9 grid-col-1 gap-3 mb-6 mt-2">
        {{-- Vendor ทะเบียนข้อมูลร้านค้า --}}
        <div>
            <label for="permiss_1" class="text-lg font-semibold"> {{ __('users.permiss_1') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_1_1" id="default-checkbox" value="0">
                    <input id="permiss_1_1" name="permiss_1_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[0] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_1_1" class="label_checkbox">{{ __('users.user_create') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_1_2" id="default-checkbox" value="0">
                    <input id="permiss_1_2" name="permiss_1_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[1] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_1_2" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_1_3" id="default-checkbox" value="0">
                    <input id="permiss_1_3" name="permiss_1_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[2] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_1_3" class="label_checkbox">{{ __('users.user_delete') }}</label>
                </div>
            </div>
        </div>
        {{-- Vendor ทะเบียนข้อมูลร้านค้า --}}
        {{-- Memmber ทะเบียนข้อมูลสมาชิก --}}
        <div>
            <label for="permiss_2" class="text-lg font-semibold"> {{ __('users.permiss_2') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_2_1" id="default-checkbox" value="0">
                    <input id="permiss_2_1" name="permiss_2_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[3] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_2_1" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_2_2" id="default-checkbox" value="0">
                    <input id="permiss_2_2" name="permiss_2_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[4] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_2_2" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_2_3" id="default-checkbox" value="0">
                    <input id="permiss_2_3" name="permiss_2_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[5] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_2_3" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- Memmber ทะเบียนข้อมูลสมาชิก --}}
        {{-- Product Group ทะเบียนข้อมูลกลุ่มสินค้า --}}
        <div>
            <label for="permiss_3" class="text-lg font-semibold"> {{ __('users.permiss_3') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_3_1" id="default-checkbox" value="0">
                    <input id="permiss_3_1" name="permiss_3_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[6] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_3_1" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_3_2" id="default-checkbox" value="0">
                    <input id="permiss_3_2" name="permiss_3_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[7] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_3_3" id="default-checkbox" value="0">
                    <input id="permiss_3_3" name="permiss_3_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[8] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_3_3" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- Product Group ทะเบียนข้อมูลกลุ่มสินค้า --}}
        {{-- ทะเบียนข้อมูล Promotion ร้านค้า --}}
        <div>
            <label for="permiss_4" class="text-lg font-semibold"> {{ __('users.permiss_4') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_4_1" id="default-checkbox" value="0">
                    <input id="permiss_4_1" name="permiss_4_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[9] == 1) checked @endif class="checkbox_input">
                    <label for="permiss_4_1" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_4_2" id="default-checkbox" value="0">
                    <input id="permiss_4_2" name="permiss_4_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[10] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_4_3" id="default-checkbox" value="0">
                    <input id="permiss_4_3" name="permiss_4_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[11] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- ทะเบียนข้อมูล Promotion ร้านค้า --}}
        {{-- ทะเบียนข้อมูล Promotion บัตร --}}
        <div>
            <label for="permiss_5" class="text-lg font-semibold"> {{ __('users.permiss_5') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_5_1" id="default-checkbox" value="0">
                    <input id="permiss_5_1" name="permiss_5_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[12] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_5_2" id="default-checkbox" value="0">
                    <input id="permiss_5_2" name="permiss_5_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[13] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_5_3" id="default-checkbox" value="0">
                    <input id="permiss_5_3" name="permiss_5_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[14] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- ทะเบียนข้อมูล Promotion บัตร --}}
        {{-- User ทะเบียนข้อมูลผู้ใช้ระบบ --}}
        <div>
            <label for="permiss_6" class="text-lg font-semibold"> {{ __('users.permiss_6') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_6_1" id="default-checkbox" value="0">
                    <input id="permiss_6_1" name="permiss_6_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[15] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_6_2" id="default-checkbox" value="0">
                    <input id="permiss_6_2" name="permiss_6_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[16] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_6_3" id="default-checkbox" value="0">
                    <input id="permiss_6_3" name="permiss_6_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[17] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- User ทะเบียนข้อมูลผู้ใช้ระบบ --}}
        {{-- Branch ทะเบียนข้อมูลสาขา --}}
        <div>
            <label for="permiss_7" class="text-lg font-semibold"> {{ __('users.permiss_7') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_7_1" id="default-checkbox" value="0">
                    <input id="permiss_7_1" name="permiss_7_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[18] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_7_2" id="default-checkbox" value="0">
                    <input id="permiss_7_2" name="permiss_7_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[19] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_7_3" id="default-checkbox" value="0">
                    <input id="permiss_7_3" name="permiss_7_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[20] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- Branch ทะเบียนข้อมูลสาขา --}}

        {{-- <div>
            <label for="permiss_8" class="text-lg font-semibold"> {{ __('users.permiss_8') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_8_1" id="default-checkbox" value="0">
                    <input id="permiss_8_1" name="permiss_8_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[21] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_8_2" id="default-checkbox" value="0">
                    <input id="permiss_8_2" name="permiss_8_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[22] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_8_3" id="default-checkbox" value="0">
                    <input id="permiss_8_3" name="permiss_8_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[23] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div> --}}
        {{-- CardType ทะเบียนข้อมูลประเภทบัตร --}}
        <div>
            <label for="permiss_9" class="text-lg font-semibold"> {{ __('users.permiss_9') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_9_1" id="default-checkbox" value="0">
                    <input id="permiss_9_1" name="permiss_9_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[24] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_9_2" id="default-checkbox" value="0">
                    <input id="permiss_9_2" name="permiss_9_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[25] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_9_3" id="default-checkbox" value="0">
                    <input id="permiss_9_3" name="permiss_9_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[26] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- CardType ทะเบียนข้อมูลประเภทบัตร --}}
        {{-- Product ทะเบียนข้อมูลสินค้า --}}
        <div>
            <label for="permiss_10" class="text-lg font-semibold"> {{ __('users.permiss_10') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_10_1" id="default-checkbox" value="0">
                    <input id="permiss_10_1" name="permiss_10_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[27] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_10_2" id="default-checkbox" value="0">
                    <input id="permiss_10_2" name="permiss_10_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[28] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_10_3" id="default-checkbox" value="0">
                    <input id="permiss_10_3" name="permiss_10_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[29] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- Product ทะเบียนข้อมูลสินค้า --}}

        {{-- <div>
            <label for="permiss_11" class="text-lg font-semibold"> {{ __('users.permiss_11') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_11_1" id="default-checkbox" value="0">
                    <input id="permiss_11_1" name="permiss_11_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[30] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_11_2" id="default-checkbox" value="0">
                    <input id="permiss_11_2" name="permiss_11_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[31] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_11_3" id="default-checkbox" value="0">
                    <input id="permiss_11_3" name="permiss_11_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[32] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div> --}}
        {{-- Staff ทะเบียนข้อมูลพนักงาน --}}
        <div>
            <label for="permiss_12" class="text-lg font-semibold"> {{ __('users.permiss_12') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_12_1" id="default-checkbox" value="0">
                    <input id="permiss_12_1" name="permiss_12_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[33] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_12_2" id="default-checkbox" value="0">
                    <input id="permiss_12_2" name="permiss_12_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[34] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_12_3" id="default-checkbox" value="0">
                    <input id="permiss_12_3" name="permiss_12_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[35] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>

        </div>
        {{-- Staff ทะเบียนข้อมูลพนักงาน --}}
        {{-- ProductUnit ทะเบียนข้อมูลหน่วยนับ --}}
        <div>
            <label for="permiss_13" class="text-lg font-semibold"> {{ __('users.permiss_13') }}</label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_13_1" id="default-checkbox" value="0">
                    <input id="permiss_13_1" name="permiss_13_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[36] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_13_2" id="default-checkbox" value="0">
                    <input id="permiss_13_2" name="permiss_13_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[37] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_13_3" id="default-checkbox" value="0">
                    <input id="permiss_13_3" name="permiss_13_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[38] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- ProductUnit ทะเบียนข้อมูลหน่วยนับ --}}
        {{-- ProductGroupSap ทะเบียนข้อมูลกลุ่มสินค้า SAP --}}
        <div>
            <label for="permiss_14" class="text-lg font-semibold"> {{ __('users.permiss_14') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_14_1" id="default-checkbox" value="0">
                    <input id="permiss_14_1" name="permiss_14_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[39] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_14_2" id="default-checkbox" value="0">
                    <input id="permiss_14_2" name="permiss_14_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[40] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_14_3" id="default-checkbox" value="0">
                    <input id="permiss_14_3" name="permiss_14_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[41] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- ProductGroupSap ทะเบียนข้อมูลกลุ่มสินค้า SAP --}}
        {{-- Coupon ทะเบียนข้อมูล Coupon --}}
        <div>
            <label for="permiss_15" class="text-lg font-semibold"> {{ __('users.permiss_15') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_15_1" id="default-checkbox" value="0">
                    <input id="permiss_15_1" name="permiss_15_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[42] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_15_2" id="default-checkbox" value="0">
                    <input id="permiss_15_2" name="permiss_15_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[43] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_15_3" id="default-checkbox" value="0">
                    <input id="permiss_15_3" name="permiss_15_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[44] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- Coupon ทะเบียนข้อมูล Coupon --}}
        {{-- PaymentGroup ทะเบียนข้อมูลกลุ่มประเภทชำระเงิน --}}
        <div>
            <label for="permiss_16" class="text-lg font-semibold"> {{ __('users.permiss_16') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_16_1" id="default-checkbox" value="0">
                    <input id="permiss_16_1" name="permiss_16_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[45] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_16_2" id="default-checkbox" value="0">
                    <input id="permiss_16_2" name="permiss_16_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[46] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_16_3" id="default-checkbox" value="0">
                    <input id="permiss_16_3" name="permiss_16_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[47] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- PaymentGroup ทะเบียนข้อมูลกลุ่มประเภทชำระเงิน --}}
        {{-- PaymentType ทะเบียนข้อมูลประเภทชำระเงิน --}}
        <div>
            <label for="permiss_17" class="text-lg font-semibold"> {{ __('users.permiss_17') }} </label>
            <div class="flex items-center mb-4 mt-4">

                <div class="pl-2">
                    <input type="hidden" name="permiss_17_1" id="default-checkbox" value="0">
                    <input id="permiss_17_1" name="permiss_17_1" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[48] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_create') }} </label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_17_2" id="default-checkbox" value="0">
                    <input id="permiss_17_2" name="permiss_17_2" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[49] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox">{{ __('users.user_edit') }}</label>
                </div>
                <div class="pl-2">
                    <input type="hidden" name="permiss_17_3" id="default-checkbox" value="0">
                    <input id="permiss_17_3" name="permiss_17_3" type="checkbox" value="1"
                        @if (isset($function_permiss_edit) && $function_permiss_edit[50] == 1) checked @endif class="checkbox_input">
                    <label for="" class="label_checkbox"> {{ __('users.user_delete') }} </label>
                </div>
            </div>
        </div>
        {{-- PaymentType ทะเบียนข้อมูลประเภทชำระเงิน --}}


    </div>
</div>
