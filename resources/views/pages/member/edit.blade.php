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
        {{ __('menu.member_edit') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.member_edit') }}
@endsection
@section('form-section')
    <form action="{{ route('member.update', $member_data->member_id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="grid gap-6 mb-4 md:grid-cols-2">
            <div>
                <label for="member_id" class="label_input"> {{ __('member.member_id') }} </label>
                <input type="text" id="member_id" name="member_id" placeholder="..." class="input_text"
                    value="{{ $member_data->member_id }}" readonly />
                @error('member_id')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="member_name" class="label_input">{{ __('member.member_name') }}</label>
                <input type="text" id="member_name" name="member_name" placeholder=" Kevin, David" class="input_text "
                    value="{{ $member_data->member_name }}" required />
                @error('member_name')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="member_license" class="label_input">{{ __('member.member_license') }}</label>
                <input type="text" id="member_license" name="member_license" maxlength="13"
                    placeholder="0-0000-00000-00-0" class="input_text " value="{{ $member_data->member_license }}"
                     />
                @error('member_license')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="member_expire" class="label_input">{{ __('member.member_expire') }}</label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="member_expire" name="member_expire"
                    value="{{ date('Y-m-d', strtotime($member_data->member_expiredate)) }}" class="input_text" />
                @error('member_expire')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="member_birthdate" class="label_input">{{ __('member.member_birthdate') }}</label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="member_birthdate" name="member_birthdate"
                    class="input_text" value="{{ date('Y-m-d', strtotime($member_data->member_birthdate)) }}" />
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
                <textarea id="member_addr" name="member_addr" rows="4" class="textarea_input">{{ $member_data->member_addr }}</textarea>
                @error('member_addr')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">{{ __('menu.is_warning') }}</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="member_phone" class="label_input">{{ __('member.member_phone') }}</label>
                <input type="text" id="member_phone" name="member_phone" maxlength="10" class="input_text "
                    value="{{ $member_data->member_phone }}" />
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
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 border-gray-200 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="member_card-tab" data-tabs-target="#member_card" type="button" role="tab"
                            aria-controls="member_card" aria-selected="false">{{ __('member.card_desc') }} </button>
                    </li>
                </ul>
            </div>
            <div id="member_tab_content">
                <div class="hidden p-4 rounded-lg " id="use_card" role="tabpanel" aria-labelledby="use_card_tab">
                    <div class="my-5 flex space-x-3">
                        <div>
                            <label for="card_number" class="label_input"> {{ __('member.card_no') }} </label>
                            <input type="text" class="input_text" id="card_number" maxlength="13"
                                value="{{ $member_data->card_no ?? '' }}" readonly>
                        </div>
                        <div>
                            <label for="card_number" class="label_input"> {{ __('member.balance') }} </label>
                            <input type="text" class="input_text" id="card_number" maxlength="13"
                                value="{{ $card_sub->net ?? '' }}" readonly>
                        </div>
                    </div>
                    <table class="table-data">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>ร้านค้า</th>
                                <th>จำนวนเงิน</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($use_card->isEmpty())
                                <tr>
                                    <td>ว่าง</td>
                                    <td>ว่าง</td>
                                    <td>ว่าง</td>
                                </tr>
                            @else
                                @foreach ($use_card as $item)
                                    <tr>
                                        <td>{{ $item->txndate }}</td>
                                        <td>{{ $item->vendor_name }}</td>
                                        <td>{{ $item->amount }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="hidden p-4 rounded-lg " id="member_card" role="tabpanel" aria-labelledby="member_card-tab">
                    <table class="table-data">
                        <thead>
                            <tr>
                                <th>วันที่</th>
                                <th>ร้านค้า</th>
                                <th>จำนวนเงิน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
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
    {{-- @if ($errors->any())
        <div class="error_alert" role="alert">
            <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
        </div>
    @endif --}}
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
        });
    </script>
@endsection
