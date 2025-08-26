@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.card_type') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('card-type.index') }}" class="first_bc_a">
        {{ __('menu.card_type_edit') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="{{ route('card-type.index') }}" class="second_bc_a">
        {{ __('menu.card_type_edit') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.card_type_edit') }}
@endsection
@section('form-section')
    <form id="card_type" action="{{ route('card-type.update', $card_type->subno) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid_page">
            <div>
                <label for="subno" class="label_input"> {{ __('card_type.subno') }} </label>
                <input type="text" id="subno" maxlength="3" name="subno" placeholder="..." class="input_text"
                    value="{{ $card_type->subno }}" required />
                @error('subno')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="subdesc" class=" label_input">{{ __('card_type.subdesc') }}</label>
                <input type="text" id="subdesc" name="subdesc" class="input_text" value="{{ $card_type->subdesc }}"
                    required />
                @error('subdesc')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="expire_day" class=" label_input">{{ __('card_type.expire_day') }}</label>
                <input type="text" id="expire_day" name="expire_day" class="input_text"
                    value="{{ $card_type->expire_day }}" required />
                @error('expire_day')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="deposit" class=" label_input">{{ __('card_type.deposit') }}</label>
                <input type="text" id="deposit" name="deposit" class="input_text" value="{{ $card_type->deposit }}" />
                @error('deposit')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('card-type.index') }}">
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
        $('#card_type').validate({
            rules: {
                subno: "required",
                subdesc: "required",
                expire_day: {
                    required: true,
                    number: true
                },
                deposit: "required",
            },
            messages: {
                subno: `{{ __('card_type.subno_valid') }}`,
                subdesc: `{{ __('card_type.subdesc_valid') }}`,
                expire_day: {
                    required: `{{ __('card_type.expire_day_valid') }}`,
                    number: `{{ __('card_type.expire_num_valid') }}`
                },
                deposit: `{{ __('card_type.deposit_valid') }}`,
            }
        });
    </script>
@endsection
