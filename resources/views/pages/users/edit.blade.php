@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.users_edit') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('users.index') }}" class="first_bc_a" id="cancel_button">
        {{ __('menu.users') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.users_edit') }}
    </a>
@endsection

@section('page_title')
    {{ __('menu.users_edit') }}
@endsection
@section('form-section')
    <form action="{{ route('users.update', $user_data->user_id) }}" method="post" id="users_form"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-6 mb-4">
            <div>
                <label for="user_id" class="label_input">{{ __('users.user_id') }}</label>
                <input type="text" id="user_id" name="user_id" class="input_text"
                    placeholder="{{ __('users.user_id') }}" value="{{ $user_data->user_id }}" readonly />
                @error('user_id')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            @if (session('auth_user.branch_id') == 000000)
                @php
                    $branches = DB::table('branch_info')->where('activeflag', 1)->orderBy('branch_id', 'asc')->get();
                @endphp
                <div>
                    <label for="branch_id" class="label_input">{{ __('users.branch_id') }}</label>
                    <select name="branch_id" id="branch_id" class="input_text">
                        @if ($user_data->user_id == session('auth_user.user_id') && $user_data->branch_id == 000000)
                            <option value="000000" selected>
                                000000</option>
                        @endif
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->branch_id }}" @if ($user_data->branch_id == $branch->branch_id) selected @endif>
                                {{ $branch->branch_id }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <div>
                    <label for="branch_id" class="label_input">{{ __('users.branch_id') }}</label>
                    <input type="text" id="branch_id" name="branch_id" class="input_text"
                        placeholder="{{ __('users.branch_id') }}" readonly value="{{ $user_data->branch_id }}" required />
                    @error('branch_id')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            @endif
            <div>
                <label for="user_name" class="label_input">{{ __('users.user_name') }}</label>
                <input type="text" id="user_name" name="user_name" class="input_text"
                    placeholder="{{ __('users.user_name') }}" value="{{ $user_data->user_name }}" required />
                @error('user_name')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="city_license" class="label_input">{{ __('users.city_license') }}</label>
                <input type="text" id="city_license" name="city_license" class="input_text"
                    placeholder="{{ __('users.city_license') }}" value="{{ $user_data->city_license }}" />
            </div>
            <div>
                <label for="user_pass" class="label_input">{{ __('users.user_pass') }}</label>
                <input type="password" id="user_pass" name="user_pass" value="{{ $user_data->user_pass }}"
                    class="input_text" placeholder="{{ __('users.user_pass') }}" />
                @error('user_pass')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="card_no" class="label_input">{{ __('users.card_no') }}</label>
                <input type="text" id="card_no" name="card_no" class="input_text"
                    placeholder="{{ __('users.card_no') }}" value="{{ $user_data->card_no }}" />
            </div>

            <div class="grid lg:grid-cols-2 grid-cols-1 gap-2">
                <div class="mt-5">
                    <input id="default-checkbox" type="hidden" name="needresetpass" value="0">
                    <input id="needresetpass" type="checkbox" name="needresetpass" value="1"
                        @if ($user_data->needresetpass == 1) checked @endif class="checkbox_input">
                    <label for="needresetpass" class="label_checkbox">{{ __('users.needresetpass') }}</label>
                </div>
                <section class="mt-2">
                    <input type="number" id="resetpass_day" name="resetpass_day" class="input_text"
                        value="{{ $user_data->resetpass_day }}" placeholder="{{ __('users.resetpass_day') }}  " />
                </section>
            </div>

        </div>
        <div class="mb-4 border-b border-gray-200 ">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="front-tab" data-tabs-target="#front"
                        type="button" role="tab" aria-controls="front" aria-selected="false">
                        {{ __('users.front') }}
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="back-tab" data-tabs-target="#back" type="button" role="tab" aria-controls="back"
                        aria-selected="false">{{ __('users.back') }}</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="vendor-tab" data-tabs-target="#vendor" type="button" role="tab" aria-controls="vendor"
                        aria-selected="false">{{ __('users.vendor') }}</button>
                </li>
                <li role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="permission-tab" data-tabs-target="#permission" type="button" role="tab"
                        aria-controls="permission" aria-selected="false">{{ __('users.permiss') }}</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
            <div class="hidden p-4 rounded-lg" id="front" role="tabpanel" aria-labelledby="front-tab">
                @include('pages.users.tab.front')
            </div>
            <div class="hidden p-4 rounded-lg" id="back" role="tabpanel" aria-labelledby="back-tab">
                @include('pages.users.tab.back')
            </div>
            <div class="hidden p-4 rounded-lg" id="vendor" role="tabpanel" aria-labelledby="vendor-tab">
                @include('pages.users.tab.term')
            </div>
            <div class="hidden p-4 rounded-lg" id="permission" role="tabpanel" aria-labelledby="permission-tab">
                @include('pages.users.tab.permiss')
            </div>
        </div>

        <button type="submit" id="submit_button" class="submit_btn"> {{ __('menu.button.save') }} </button>
        <a href="{{ route('users.index') }}" id="cancel_button">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
@section('js-scripts')
    <script type="module">
        $('#users_form').validate({
            rules: {
                user_id: {
                    required: true,
                    maxlength: 6
                },
                branch_id: {
                    required: true,
                },
                user_name: {
                    required: true,
                    maxlength: 50
                },
            },
            messages: {
                user_id: {
                    required: `{{ __('users.user_id_required') }}`,
                    maxlength: `{{ __('users.user_id_max') }}`
                },
                branch_id: {
                    required: `{{ __('users.branch_id_required') }}`,
                },
                user_name: {
                    required: `{{ __('users.user_name_required') }}`
                },
            }
        })
    </script>
@endsection
