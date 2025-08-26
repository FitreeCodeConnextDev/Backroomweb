@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.staff_edit') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('staff.index') }}" class="first_bc_a" id="cancel_button">
        {{ __('menu.staff') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="" class="second_bc_a">
        {{ __('menu.staff_edit') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.staff_edit') }}
@endsection
@section('form-section')
    <form id="staff_form" action="{{ route('staff.update', $staff_data->staff_id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-4 grid lg:grid-cols-2 grid-cols-1 gap-6 ">
            <div>
                <label for="staff_id" class="label_input"> {{ __('staff.staff_id') }} </label>
                <input type="text" id="staff_id" maxlength="10" name="staff_id" class="input_text" readonly disabled
                    value="{{ $staff_data->staff_id }}">
                @error('staff_id')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_name" class="label_input"> {{ __('staff.staff_name') }} </label>
                <input type="text" id="staff_name" name="staff_name" class="input_text"
                    value="{{ $staff_data->staff_name }}" required>
                @error('staff_name')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_type" class="label_input"> {{ __('staff.staff_type') }} </label>
                <select name="staff_type" id="staff_type" class="input_text">
                    <option value="1" @if ($staff_data->staff_type == 1) selected @endif>
                        {{ __('staff.staff_nomaly') }} </option>
                    <option value="2" @if ($staff_data->staff_type == 2) selected @endif>
                        {{ __('staff.staff_vip') }}
                    </option>
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
                    class="input_text " value="{{ $staff_data->staff_license }}" required />
                @error('staff_license')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_expiredate" class="label_input"> {{ __('staff.staff_expiredate') }} </label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="staff_expiredate" name="staff_expiredate"
                    class="input_text" value="{{ date('Y-m-d', strtotime($staff_data->staff_expiredate)) }}" />
                @error('staff_expiredate')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="staff_birthdate" class="label_input"> {{ __('staff.staff_birthdate') }} </label>
                <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="staff_birthdate" name="staff_birthdate"
                    class="input_text" value="{{ date('Y-m-d', strtotime($staff_data->staff_birthdate)) }}" />
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
                <textarea id="staff_addr" name="staff_addr" rows="4" class="textarea_input" placeholder="..."> {{ $staff_data->staff_addr }} </textarea>
                @error('staff_addr')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_phone" class="label_input"> {{ __('staff.staff_phone') }} </label>
                <input type="text" id="staff_phone" maxlength="10" name="staff_phone" placeholder="000-000-0000"
                    class="input_text " required value="{{ $staff_data->staff_phone }}" />
                @error('staff_phone')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="staff_limit" class="label_input"> {{ __('staff.staff_limit') }} </label>
                <input type="number" id="staff_limit" value="{{ $staff_data->credit_limit }}" name="staff_limit"
                    class="input_text" va required />
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
                                value="{{ $staff_data->card_no ?? '' }}" readonly>
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
        {{-- @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                role="alert">
                <h1
                    class="mb-4 text-4xl font-extrabold text-center leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white mt-6">
                    {{ $errors->first() }}
                </h1>
            </div>
        @endif --}}
        <button type="submit" id="submit_button" class="submit_btn"> {{ __('menu.button.save') }} </button>
        <a href="{{ route('staff.index') }}" id="cancel_button">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
