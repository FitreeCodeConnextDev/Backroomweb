@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.staff_add') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('staff.index') }}" class="first_bc_a" id="cancel_button">
        {{ __('menu.staff') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.staff_add') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.staff_add') }}
@endsection

@section('form-section')
    <form id="staff_form" action="{{ route('staff.store') }}" method="post">
        @csrf
        <div class="mb-4 grid lg:grid-cols-2 grid-cols-1 gap-6 ">
            <div>
                <label for="staff_id" class="label_input"> {{ __('staff.staff_id') }} </label>
                <input type="text" id="staff_id" maxlength="10" name="staff_id" class="input_text" required>
                @error('staff_id')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_name" class="label_input"> {{ __('staff.staff_name') }} </label>
                <input type="text" id="staff_name" name="staff_name" class="input_text" required>
                @error('staff_name')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_type" class="label_input"> {{ __('staff.staff_type') }} </label>
                <select name="staff_type" id="staff_type" class="input_text">
                    <option value="1"> {{ __('staff.staff_nomaly') }} </option>
                    <option value="2"> {{ __('staff.staff_vip') }} </option>
                </select>
                @error('staff_type')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_license" class="label_input"> {{ __('staff.staff_license') }} </label>
                <input type="text" id="staff_license" maxlength="13" name="staff_license" placeholder="0-0000-00000-00-0"
                    class="input_text " value="" />
                @error('staff_license')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_expiredate" class="label_input"> {{ __('staff.staff_expiredate') }} </label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="staff_expiredate" name="staff_expiredate"
                    class="input_text" />
                @error('staff_expiredate')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="staff_birthdate" class="label_input"> {{ __('staff.staff_birthdate') }} </label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="staff_birthdate" name="staff_birthdate"
                    class="input_text" />
                @error('staff_birthdate')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- <div>
                <label for="member_picture" class="label_input">รูปภาพ</label>
                <input class="file_input" aria-describedby="file_input_help" id="member_picture" name="member_picture"
                    type="file">
            </div> --}}
            <div>
                <label for="staff_addr" class="label_input"> {{ __('staff.staff_addr') }} </label>
                <textarea id="staff_addr" name="staff_addr" rows="4" class="textarea_input" placeholder="..."></textarea>
                @error('staff_addr')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_phone" class="label_input"> {{ __('staff.staff_phone') }} </label>
                <input type="text" id="staff_phone" maxlength="10" name="staff_phone" placeholder="000-000-0000"
                    class="input_text " />
                @error('staff_phone')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_limit" class="label_input"> {{ __('staff.staff_limit') }} </label>
                <input type="number" id="staff_limit" value="0" name="staff_limit" class="input_text" />
                @error('staff_limit')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <div class="p-2  border border-gray-200 rounded-md">
            <div class="mb-4 border-b border-gray-200">
                <ul class="tab_ul" id="member_tab" data-tabs-toggle="#member_tab_content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="tab_button" id="use_card-tab" data-tabs-target="#use_card" type="button"
                            role="tab" aria-controls="use_card" aria-selected="false"> {{ __('member.use_card') }}
                        </button>
                    </li>
                </ul>
            </div>
            <div id="member_tab_content">
                <div class="hidden p-4 rounded-lg " id="use_card" role="tabpanel" aria-labelledby="use_card_tab">
                    <div class="my-5 flex space-x-3">
                        <div>
                            <label for="card_number" class="label_input"> {{ __('member.card_no') }} </label>
                            <input type="text" name="card_no" class="input_text" id="card_number" maxlength="13">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <button type="submit" id="submit_button" class="submit_btn"> {{ __('menu.button.save') }} </button>
        <a href="{{ route('staff.index') }}" id="cancel_button">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
@section('js-scripts')
    <script>
        $('#staff_form').validate({
            rules: {
                staff_id: {
                    required: true,
                    maxlength: 10
                },
                staff_name: {
                    required: true
                },
                // staff_license: {
                //     required: true,
                //     minlength: 13,
                //     maxlength: 13,
                //     number: true
                // },
                // staff_expiredate: {
                //     required: true,
                //     date: true,
                // },
                // staff_birthdate: {
                //     required: true
                // },
                // staff_phone: {
                //     required: true,
                //     minlength: 10,
                //     maxlength: 10,
                //     number: true
                // },
                // staff_addr: {
                //     required: true
                // }
            },
            messages: {
                staff_id: {
                    required: `{{ __('staff.staff_id_required') }}`,
                    maxlength: `{{ __('staff.staff_id_valid_max') }}`
                },
                staff_name: `{{ __('staff.staff_name_required') }}`,
                // staff_license: {
                //     required: `{{ __('staff.staff_license_required') }}`,
                //     minlength: `{{ __('staff.staff_license_min') }}`,
                //     maxlength: `{{ __('staff.staff_license_max') }}`,
                //     number: `{{ __('staff.staff_license_num') }}`
                // },
                // staff_expiredate: {
                //     required: `{{ __('staff.staff_expiredate_required') }}`,
                // },
                // staff_birthdate: `{{ __('staff.staff_birthdate_required') }}`,
                // staff_phone: {
                //     required: `{{ __('staff.staff_phone_required') }}`,
                //     minlength: `{{ __('staff.staff_phone_min') }}`,
                //     maxlength: `{{ __('staff.staff_phone_max') }}`,
                //     number: `{{ __('staff.staff_phone_num') }}`
                // },
                // staff_addr: `{{ __('staff.staff_addr_required') }}`
            }
        })
    </script>
@endsection
