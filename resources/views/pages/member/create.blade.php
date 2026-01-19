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
                <input type="text" id="member_id" name="member_id" maxlength="6" placeholder="..." class="input_text"
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
                <input type="date" id="member_expire" name="member_expire" class="input_text" />
                @error('member_expire')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="member_birthdate" class="label_input">{{ __('member.member_birthdate') }}</label>
                <input type="date" id="member_birthdate" name="member_birthdate" class="input_text" />
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
                <label for="member_addr" class="label_input">{{ __('member.member_addr') }}</label>
                <textarea id="member_addr" name="member_addr" rows="4" class="textarea_input" placeholder=" Lorem"></textarea>
                @error('member_addr')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
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

        </div>
        {{-- tab --}}
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
                            @error('card_no')
                                <p class="mt-2 text-sm text-red-600 "><span
                                        class="font-medium">{{ __('menu.is_warning') }}</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        {{-- <div>
                            <label for="card_number" class="label_input"> {{ __('member.balance') }} </label>
                            <input type="text" class="input_text" id="card_number" maxlength="13">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <button type="submit" id="submit_button" class="submit_btn"> {{ __('menu.button.save') }} </button>
        <a href="{{ route('member.index') }}" id="cancel_button">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
@section('js-scripts')
    <script type="module">
        $(document).ready(function() {
            $('#member_form').validate({
                rules: {
                    member_id: {
                        required: true,
                        maxlength: 10
                    },
                    member_name: {
                        required: true
                    },
                },
                messages: {
                    member_id: {
                        required: `{{ __('member.member_id_valid') }}`,
                        maxlength: `{{ __('member.member_id_valid_max') }}`
                    },
                    member_name: `{{ __('member.member_name_valid') }}`,
                }
            })
        });
    </script>
@endsection
