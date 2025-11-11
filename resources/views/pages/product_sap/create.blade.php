@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.product_sap') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('payment-group.index') }}" class="first_bc_a">
        {{ __('menu.product_sap') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.product_sap_add') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.product_sap_add') }}
@endsection
@section('form-section')
    <form action="{{ route('product-sap.store') }}" id="product_sap" method="post">
        @csrf
        <div class="grid_page">
            <div>
                <label for="catproduct_group" class="label_input">{{ __('product_sap.catproduct_group') }}</label>
                <input type="text" id="catproduct_group" maxlength="10" name="catproduct_group" placeholder="..." class="input_text"
                    value="" required />
                @error('catproduct_group')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="description" class=" label_input">{{ __('product_sap.description') }}</label>
                <input type="text" id="description" name="description" placeholder="" class="input_text" value=""
                    required />
                @error('description')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="ar_sap" class=" label_input">{{ __('product_sap.ar_sap') }}</label>
                <input type="text" id="ar_sap" name="ar_sap" placeholder="..." class="input_text" value="" />
                @error('ar_sap')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="ar_description" class=" label_input">{{ __('product_sap.ar_description') }}</label>
                <input type="text" id="ar_description" name="ar_description" placeholder="..." class="input_text"
                    value="" />
                @error('ar_description')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium"> {{ __('menu.is_warning') }} </span>
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('product-sap.index') }}">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
@section('js-scripts')
    <script type="module">
        $('#product_sap').validate({
            rules: {
                catproduct_group: {
                    required: true
                },
                description: {
                    required: true
                },

            },
            messages: {
                catproduct_group: `{{ __('product_sap.catproduct_group_valid') }}`,
                description: `{{ __('product_sap.description_valid') }}`,
            }
        });
    </script>
@endsection
