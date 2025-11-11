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
        {{ __('menu.product_sap_edit') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.product_sap_edit') }}
@endsection
@section('form-section')
    <form action="{{ route('product-sap.update', $catproduct_info->catproduct_group) }}" id="product_sap" method="post">
        @csrf
        @method('PUT')
        <div class="grid_page">
            <div>
                <label for="catproduct_group" class="label_input">{{ __('product_sap.catproduct_group') }}</label>
                <input type="text" id="catproduct_group" name="catproduct_group" placeholder="001, 002 ..."
                    class="input_text" value="{{ $catproduct_info->catproduct_group }}" required readonly />
            </div>
            <div>
                <label for="description" class=" label_input">{{ __('product_sap.description') }}</label>
                <input type="text" id="description" name="description" placeholder="" class="input_text"
                    value=" {{ $catproduct_info->description }}" required />
                @error('description')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="ar_sap" class=" label_input">{{ __('product_sap.ar_sap') }}</label>
                <input type="text" id="ar_sap" name="ar_sap" placeholder="..." class="input_text"
                    value="{{ $catproduct_info->ar_sap }}" />
                @error('ar_sap')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="ar_sap" class=" label_input">{{ __('product_sap.ar_description') }}</label>
                <input type="text" id="ar_description" name="ar_description" placeholder="..." class="input_text"
                    value="{{ $catproduct_info->ar_description }}" />
                @error('ar_sap')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
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
@section('scripts')
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
