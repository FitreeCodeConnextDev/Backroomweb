@extends('layouts.createpage')
@section('title_page')
    {{ __('expense_vendor.expense_vendor_title') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('expense_vendor.index') }}" class="first_bc_a">
        {{ __('expense_vendor.expense_vendor_title') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('expense_vendor.expense_vendor_edit') }}
    </a>
@endsection
@section('page_title')
    {{ __('expense_vendor.expense_vendor_edit') }}
@endsection
@section('form-section')
    <form action="{{ route('expense_vendor.update', $expense_vendor->exp_code) }}" id="expense_vendor" method="post">
        @csrf
        @method('PUT')
        <div class="grid_page">
            <div>
                <label for="exp_code" class="label_input">{{ __('expense_vendor.exp_code') }}</label>
                <input type="text" id="exp_code" maxlength="10" name="exp_code" placeholder="..." class="input_text"
                    value="{{ $expense_vendor->exp_code }}" readonly />
                @error('exp_code')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="description" class="label_input">{{ __('expense_vendor.description') }}</label>
                <input type="text" id="description" name="description" placeholder="..." class="input_text"
                    value="{{ $expense_vendor->description }}" required />
                @error('description')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="price_rate" class="label_input">{{ __('expense_vendor.price_rate') }}</label>
                <input type="text" id="price_rate" name="price_rate" placeholder="..." class="input_text"
                    value="{{ $expense_vendor->price_rate }}" required />
                @error('price_rate')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('expense_vendor.index') }}">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
