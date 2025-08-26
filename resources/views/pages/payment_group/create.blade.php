@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.payment_groups') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('payment-group.index') }}" class="first_bc_a">
        {{ __('menu.payment_groups') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.payment_groups_add') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.payment_groups_add') }}
@endsection
@section('form-section')
    <form id="payment_groups" action="{{ route('payment-group.store') }}" method="POST">
        @csrf
        <div class="grid_page">
            <div>
                <label for="payment_group" class="label_input">{{ __('payment_group.payment_group') }}</label>
                <input type="text" id="payment_group" name="payment_group" maxlength="2" placeholder="01, 02 ..." class="input_text"
                    value="{{ old('payment_group') }}" required />
                @error('payment_group')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="description" class=" label_input">{{ __('payment_group.description') }}</label>
                <input type="text" id="description" name="description" class="input_text"
                    value="{{ old('description') }}" required />
                @error('description')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="show_tender" class=" label_input">{{ __('payment_group.show_tender') }}</label>
                <select name="show_tender" id="show_tender" class="input_text">
                    <option selected disabled>เลือก</option>
                    <option value="N">{{ __('payment_group.show_tender_N') }}</option>
                    <option value="Y">{{ __('payment_group.show_tender_Y') }}</option>
                </select>
                @error('show_tender')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror

            </div>
        </div>

        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('payment-group.index') }}">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
@section('js-scripts')
    <script>
        $('#payment_groups').validate({
            rules: {
                payment_group: "required",
                description: "required",
                show_tender: "required",
            },
            messages: {
                payment_group: `{{ __('payment_group.payment_group_valid') }}`,
                description: `{{ __('payment_group.description_valid') }}`,
                show_tender: `{{ __('payment_group.show_tender_valid') }}`,
            }
        });
    </script>
@endsection
