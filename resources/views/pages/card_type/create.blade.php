@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.card_type') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('card-type.index') }}" class="first_bc_a">
        {{ __('menu.card_type') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="{{ route('card-type.index') }}" class="second_bc_a">
        {{ __('menu.card_type') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.card_type_add') }}
@endsection
@section('form-section')
    <form id="card_type" action="{{ route('card-type.store') }}" method="POST">
        @csrf
        <div class="grid_page">
            <div>
                <label for="subno" class="label_input"> {{ __('card_type.subno') }} </label>
                <input type="text" id="subno" maxlength="3" name="subno" placeholder="..." class="input_text" value=""
                    required />
                @error('subno')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="subdesc" class=" label_input">{{ __('card_type.subdesc') }}</label>
                <input type="text" id="subdesc" name="subdesc" class="input_text" value="" required />
                @error('subdesc')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="expire_day" class=" label_input">{{ __('card_type.expire_day') }}</label>
                <input type="text" id="expire_day" name="expire_day" class="input_text" value="0" required />
                @error('expire_day')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="deposit" class=" label_input">{{ __('card_type.deposit') }}</label>
                <input type="text" id="deposit" name="deposit" class="input_text" value="0.00" />
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
@endsection
@section('js-scripts')
    <script>
        $('#card_type').validate({
            rules: {
                subno: {
                    required: true,
                },
                subdesc: {
                    required: true,
                },
                expire_day: {
                    required: true,
                    number: true
                },
                deposit: {
                    required: true,
                },
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
