<div class="p-4 md:p-6 mt-2">
    <div class="grid lg:grid-flow-col lg:grid-rows-9 grid-col-1 gap-3">
        {{-- Vendor ทะเบียนข้อมูลร้านค้า --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_1" id="default-checkbox" value="0">
            <input id="back_1" name="back_1" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[0] == 1) checked @endif class="checkbox_input">
            <label for="back_1" class="label_checkbox">
                {{ __('users.back_1') }} </label>
        </div>
        {{-- Vendor ทะเบียนข้อมูลร้านค้า --}}
        {{-- Memmber ทะเบียนข้อมูลสมาชิก --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_2" id="default-checkbox" value="0">
            <input id="back_2" name="back_2" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[1] == 1) checked @endif class="checkbox_input">
            <label for="back_2" class="label_checkbox">
                {{ __('users.back_2') }} </label>
        </div>
        {{-- Memmber ทะเบียนข้อมูลสมาชิก --}}
        {{-- Product Group ทะเบียนข้อมูลกลุ่มสินค้า --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_3" id="default-checkbox" value="0">
            <input id="back_3" name="back_3" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[2] == 1) checked @endif class="checkbox_input">
            <label for="back_3" class="label_checkbox">
                {{ __('users.back_3') }} </label>
        </div>
        {{-- Product Group ทะเบียนข้อมูลกลุ่มสินค้า --}}
        {{-- ทะเบียนข้อมูล Promotion ร้านค้า --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_4" id="default-checkbox" value="0">
            <input id="back_4" name="back_4" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[3] == 1) checked @endif class="checkbox_input">
            <label for="back_4" class="label_checkbox">
                {{ __('users.back_4') }} </label>
        </div>
        {{-- ทะเบียนข้อมูล Promotion ร้านค้า --}}
        {{-- ทะเบียนข้อมูล Promotion บัตร --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_5" id="default-checkbox" value="0">
            <input id="back_5" name="back_5" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[4] == 1) checked @endif class="checkbox_input">
            <label for="back_5" class="label_checkbox">
                {{ __('users.back_5') }} </label>
        </div>
        {{-- ทะเบียนข้อมูล Promotion บัตร --}}
        {{-- User ทะเบียนข้อมูลผู้ใช้ระบบ --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_6" id="default-checkbox" value="0">
            <input id="back_6" name="back_6" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[5] == 1) checked @endif class="checkbox_input">
            <label for="back_6" class="label_checkbox">
                {{ __('users.back_6') }} </label>
        </div>
        {{-- User ทะเบียนข้อมูลผู้ใช้ระบบ --}}
        {{-- Branch ทะเบียนข้อมูลสาขา --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_7" id="default-checkbox" value="0">
            <input id="back_7" name="back_7" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[6] == 1) checked @endif class="checkbox_input">
            <label for="back_7" class="label_checkbox">
                {{ __('users.back_7') }} </label>
        </div>
        {{-- Branch ทะเบียนข้อมูลสาขา --}}
        {{-- <div class="flex items-center mb-6">
            <input type="hidden" name="back_8" id="default-checkbox" value="0">
            <input id="back_8" name="back_8" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[7] == 1) checked @endif class="checkbox_input">
            <label for="back_8" class="label_checkbox">
                {{ __('users.back_8') }} </label>
        </div> --}}
        {{-- CardType ทะเบียนข้อมูลประเภทบัตร --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_9" id="default-checkbox" value="0">
            <input id="back_9" name="back_9" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[8] == 1) checked @endif class="checkbox_input">
            <label for="back_9" class="label_checkbox">
                {{ __('users.back_9') }} </label>
        </div>
        {{-- CardType ทะเบียนข้อมูลประเภทบัตร --}}
        {{-- Product ทะเบียนข้อมูลสินค้า --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_10" id="default-checkbox" value="0">
            <input id="back_10" name="back_10" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[9] == 1) checked @endif class="checkbox_input">
            <label for="back_10" class="label_checkbox">
                {{ __('users.back_10') }} </label>
        </div>
        {{-- Product ทะเบียนข้อมูลสินค้า --}}

        {{-- <div class="flex items-center mb-6">
            <input type="hidden" name="back_11" id="default-checkbox" value="0">
            <input id="back_11" name="back_11" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[10] == 1) checked @endif class="checkbox_input">
            <label for="back_11" class="label_checkbox">
                {{ __('users.back_11') }} </label>

        </div> --}}
        {{-- Staff ทะเบียนข้อมูลพนักงาน --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_12" id="default-checkbox" value="0">
            <input id="back_12" name="back_12" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[11] == 1) checked @endif class="checkbox_input">
            <label for="back_12" class="label_checkbox">
                {{ __('users.back_12') }} </label>
        </div>
        {{-- Staff ทะเบียนข้อมูลพนักงาน --}}
        {{-- ProductUnit ทะเบียนข้อมูลหน่วยนับ --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_13" id="default-checkbox" value="0">
            <input id="back_13" name="back_13" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[12] == 1) checked @endif class="checkbox_input">
            <label for="back_13" class="label_checkbox">
                {{ __('users.back_13') }} </label>
        </div>
        {{-- ProductUnit ทะเบียนข้อมูลหน่วยนับ --}}
        {{-- ProductGroupSap ทะเบียนข้อมูลกลุ่มสินค้า SAP --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_14" id="default-checkbox" value="0">
            <input id="back_14" name="back_14" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[13] == 1) checked @endif class="checkbox_input">
            <label for="back_14" class="label_checkbox">
                {{ __('users.back_14') }} </label>
        </div>
        {{-- ProductGroupSap ทะเบียนข้อมูลกลุ่มสินค้า SAP --}}
        {{-- Coupon ทะเบียนข้อมูล Coupon --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_15" id="default-checkbox" value="0">
            <input id="back_15" name="back_15" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[14] == 1) checked @endif class="checkbox_input">
            <label for="back_15" class="label_checkbox">
                {{ __('users.back_15') }} </label>
        </div>
        {{-- Coupon ทะเบียนข้อมูล Coupon --}}
        {{-- PaymentGroup ทะเบียนข้อมูลกลุ่มประเภทชำระเงิน --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_16" id="default-checkbox" value="0">
            <input id="back_16" name="back_16" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[15] == 1) checked @endif class="checkbox_input">
            <label for="back_16" class="label_checkbox">
                {{ __('users.back_16') }} </label>
        </div>
        {{-- PaymentGroup ทะเบียนข้อมูลกลุ่มประเภทชำระเงิน --}}
        {{-- PaymentType ทะเบียนข้อมูลประเภทชำระเงิน --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_17" id="default-checkbox" value="0">
            <input id="back_17" name="back_17" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[16] == 1) checked @endif class="checkbox_input">
            <label for="back_17" class="label_checkbox">
                {{ __('users.back_17') }} </label>
        </div>
        {{-- PaymentType ทะเบียนข้อมูลประเภทชำระเงิน --}}
        {{-- Report Permissions --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="back_21" id="default-checkbox" value="0">
            <input id="back_21" name="back_21" type="checkbox" value="1"
                @if (isset($back_permiss_edit) && $back_permiss_edit[20] == 1) checked @endif class="checkbox_input">
            <label for="back_21" class="label_checkbox">
                {{ __('users.back_21') }} </label>
        </div>
        {{-- Report Permissions --}}
    </div>
</div>
