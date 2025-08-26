<div class="p-4 md:p-6 mt-2">
    <div class="grid lg:grid-flow-col lg:grid-rows-3 grid-col-1 gap-3">
        <div class=" flex items-center mb-6">
            <input type="hidden" name="vendor_1" id="default-checkbox" value="0">
            <input id="vendor_1" name="vendor_1" type="checkbox" value="1"
                @if (isset($term_permiss_edit) && $term_permiss_edit[0] == 1) checked @endif class="checkbox_input">
            <label for="vendor_1" class="label_checkbox">
                {{ __('users.vendor_1') }} </label>

        </div>
        <div class=" flex items-center mb-6">
            <input type="hidden" name="vendor_2" id="default-checkbox" value="0">
            <input id="vendor_2" name="vendor_2" type="checkbox" value="1"
                @if (isset($term_permiss_edit) && $term_permiss_edit[1] == 1) checked @endif class="checkbox_input">
            <label for="vendor_2" class="label_checkbox">
                {{ __('users.vendor_2') }} </label>
        </div>
    </div>
</div>
