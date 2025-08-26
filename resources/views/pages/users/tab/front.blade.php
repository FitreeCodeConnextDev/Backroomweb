<div class="bg-white  p-4 md:p-6 mt-2">
    <div class="grid lg:grid-flow-col lg:grid-rows-5 grid-col-1 gap-3 ">
        {{-- 1 ทำรายการประจำวัน --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_1" id="default-checkbox" value="0">
            <input id="front_1" name="front_1" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[0] == 1) checked @endif class="checkbox_input">
            <label for="front_1" class="label_checkbox">
                {{ __('users.front_1') }} </label>
        </div>
        {{-- 2 ตรวจสอบการทำรายการ --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_2" id="default-checkbox" value="0">
            <input id="front_2" name="front_2" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[1] == 1) checked @endif class="checkbox_input">
            <label for="checkbox-2" class="label_checkbox">
                {{ __('users.front_2') }} </label>
        </div>
        {{-- 3 ตรวจสอบเงิน --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_3" id="default-checkbox" value="0">
            <input id="front_3" name="front_3" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[2] == 1) checked @endif class="checkbox_input">
            <label for="checkbox-3" class="label_checkbox">{{ __('users.front_3') }}</label>
        </div>
        {{-- 4 ทำรายการเปลี่ยนบัตร --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_4" id="default-checkbox" value="0">
            <input id="front_4" name="front_4" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[3] == 1) checked @endif class="checkbox_input">
            <label for="front_4" class="label_checkbox">{{ __('users.front_4') }}</label>
        </div>
        {{-- 5 ทำรายการแลก --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_5" id="default-checkbox" value="0">
            <input id="front_5" name="front_5" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[4] == 1) checked @endif class="checkbox_input">
            <label for="front_5" class="label_checkbox">{{ __('users.front_5') }}</label>
        </div>
        {{-- 6 ตรวจสอบข้อมูลบัตร --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_6" id="default-checkbox" value="0">
            <input id="front_6" name="front_6" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[5] == 1) checked @endif class="checkbox_input">
            <label for="front_6" class="label_checkbox">{{ __('users.front_6') }}</label>
        </div>
        {{-- 7 ปิดการขาย --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_7" id="default-checkbox" value="0">
            <input id="front_7" name="front_7" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[6] == 1) checked @endif class="checkbox_input">
            <label for="front_7" class="label_checkbox">{{ __('users.front_7') }}</label>
        </div>
        {{-- 8 เปลี่ยนผู้ใช้งาน --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_8" id="default-checkbox" value="0">
            <input id="front_8" name="front_8" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[7] == 1) checked @endif class="checkbox_input">
            <label for="front_8" class="label_checkbox">{{ __('users.front_8') }}</label>
        </div>
        {{-- 9 พิมพ์ใบกำกับภาษี --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_9" id="default-checkbox" value="0">
            <input id="front_9" name="front_9" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[8] == 1) checked @endif class="checkbox_input">
            <label for="front_9" class="label_checkbox">{{ __('users.front_9') }}</label>
        </div>
        {{-- 10 พิมพ์ยอดขายร้านค้า --}}
        <div class="flex items-center mb-6">
            <input type="hidden" name="front_10" id="default-checkbox" value="0">
            <input id="front_10" name="front_10" type="checkbox" value="1"
                @if (isset($front_permiss_edit) && $front_permiss_edit[9] == 1) checked @endif class="checkbox_input">
            <label for="front_10" class="label_checkbox">{{ __('users.front_10') }}</label>
        </div>
    </div>
</div>
