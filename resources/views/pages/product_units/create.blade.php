@extends('layouts.createpage')
@section('breadcrumb-index')
    <a href="{{ route('card-type.index') }}" class="first_bc_a">
        {{ __('menu.product_unit') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="{{ route('card-type.index') }}" class="first_bc_a">
        {{ __('menu.product_unit_add') }}
    </a>
@endsection
@section('title_page')
    {{ __('menu.product_unit_add') }}
@endsection
@section('form-section')
    <form id="product_unit" action="{{ route('product-units.store') }}" method="POST">
        @csrf
        <div class="grid_page">
            <div>
                <label for="text" class="label_input"> {{ __('menu.product_unit_unit_id') }} </label>
                <input type="text" id="unit_id" maxlength="2" name="unit_id" placeholder="01, 02 ..." class="input_text"
                    value="" required />
                @error('unit_id')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="text" class=" label_input">{{ __('menu.product_unit_unit_name') }}</label>
                <input type="text" id="unit_name" name="unit_name" placeholder=" จาน/ชาม/ถ้วย" class="input_text"
                    value="" required />
                @error('unit_name')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            {{-- <div>
            <div class="flex items-center mb-4">
                <input id="default-checkbox" type="hidden" name="unitcheck" value="0">
                <input id="checkbox-input" type="checkbox" name="unitcheck" value="1"
                    {{ old('unitcheck') == '1' ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="checkbox-input"
                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Default checkbox</label>

            </div>
        </div> --}}
        </div>

        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('product-units.index') }}">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
@section('js-scripts')
    <script type="module">
        $('#product_unit').validate({
            rules: {
                unit_id: {
                    required: true,
                },
                unit_name: {
                    required: true,
                },
                // unitcheck: "required",
            },
            messages: {
                unit_id: `{{ __('menu.unit_id_valid') }}`,
                unit_name: `{{ __('menu.unit_name_valid') }}`,
            }
        });
    </script>
@endsection
