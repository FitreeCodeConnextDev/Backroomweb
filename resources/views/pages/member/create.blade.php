@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.member_add') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('member.index') }}" class="first_bc_a" id="cancel_button">
        {{ __('menu.member') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.member_add') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.member_add') }}
@endsection
@section('form-section')
    <form id="member_form" action="{{ route('member.store') }}" method="post">
        @csrf
        <div class="mb-4 grid lg:grid-cols-2 grid-cols-1 gap-6 ">
            <div>
                <label for="member_id" class="label_input"> {{ __('member.member_id') }} </label>
                <input type="text" id="member_id" name="member_id" maxlength="10" placeholder="..." class="input_text"
                    value="" required />
                @error('member_id')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="member_name" class="label_input">{{ __('member.member_name') }}</label>
                <input type="text" id="member_name" name="member_name" placeholder=" Kevin, David" class="input_text "
                    value="" required />
                @error('member_name')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="member_license" class="label_input">{{ __('member.member_license') }}</label>
                <input type="text" id="member_license" maxlength="13" name="member_license"
                    placeholder="0-0000-00000-00-0" class="input_text " value="" />
                @error('member_license')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="member_expire" class="label_input">{{ __('member.member_expire') }}</label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="member_expire" name="member_expire"
                    class="input_text" />
                @error('member_expire')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="member_birthdate" class="label_input">{{ __('member.member_birthdate') }}</label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="member_birthdate" name="member_birthdate"
                    class="input_text" />
                @error('member_birthdate')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
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
                <label for="member_phone" class="label_input">{{ __('member.member_phone') }}</label>
                <input type="text" id="member_phone" maxlength="10" name="member_phone" placeholder="000-000-0000"
                    class="input_text " value="" />
                @error('member_phone')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="member_addr" class="label_input">{{ __('member.member_addr') }}</label>
                <textarea id="member_addr" name="member_addr" rows="4" class="textarea_input" placeholder=" Lorem"></textarea>
                @error('member_addr')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <button type="submit" id="submit_button" class="submit_btn"> {{ __('menu.button.save') }} </button>
        <a href="{{ route('member.index') }}" id="cancel_button">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
    {{-- @if ($errors->any())
        <div class="error_alert" role="alert">
            <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
        </div>
    @endif --}}
@endsection
@section('js-scripts')
    <script>
        $('#member_form').validate({
            rules: {
                member_id: {
                    required: true,
                    maxlength: 10
                },
                member_name: {
                    required: true
                },
                // member_license: {
                //     required: true,
                //     minlength: 13,
                //     maxlength: 13,
                //     number: true
                // },
                // member_expire: {
                //     required: true,
                //     date: true,
                // },
                // member_birthdate: {
                //     required: true
                // },
                // member_phone: {
                //     required: true,
                //     minlength: 10,
                //     maxlength: 10,
                //     number: true
                // },
                // member_addr: {
                //     required: true
                // }
            },
            messages: {
                member_id: {
                    required: `{{ __('member.member_id_valid') }}`,
                    maxlength: `{{ __('member.member_id_valid_max') }}`
                },
                member_name: `{{ __('member.member_name_valid') }}`,
                // member_license: {
                //     required: `{{ __('member.member_license_valid') }}`,
                //     minlength: `{{ __('member.member_license_valid_min') }}`,
                //     maxlength: `{{ __('member.member_license_valid_max') }}`,
                //     number: `{{ __('member.member_license_valid_num') }}`
                // },
                // member_expire: {
                //     required: `{{ __('member.member_expire_valid') }}`,
                //     date: `{{ __('member.member_expire_valid_date') }}`
                // },
                // member_birthdate: `{{ __('member.member_birthdate_valid') }}`,
                // member_phone: {
                //     required: `{{ __('member.member_phone_valid') }}`,
                //     minlength: `{{ __('member.member_phone_valid_min') }}`,
                //     maxlength: `{{ __('member.member_phone_valid_max') }}`,
                //     number: `{{ __('member.member_phone_valid_num') }}`
                // },
                // member_addr: `{{ __('member.member_addr_valid') }}`
            }
        })
    </script>
@endsection
