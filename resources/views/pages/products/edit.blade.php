@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.product_edit') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('products.index') }}" class="first_bc_a">
        {{ __('menu.product') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.product_edit') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.product_edit') }}
@endsection
@section('form-section')
    <form id="product_form" action="{{ route('products.update', $product->product_id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="grid_page">
            <div>
                <label for="product_id" class="label_input"> {{ __('product.product_id') }} </label>
                <input type="text" id="product_id" name="product_id" maxlength="6" class="input_text" readonly
                    value="{{ $product->product_id }}" />
                @error('product_id')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_group" class=" label_input">{{ __('product.product_group') }}</label>
                <select name="product_group" class="input_text" id="product_group">
                    @foreach ($product_group as $item_group)
                        <option value=" {{ $item_group->groupproduct_id }} "
                            @if ($product->product_group == $item_group->groupproduct_id) selected @endif> {{ $item_group->groupproduct_desc }}
                        </option>
                    @endforeach
                </select>
                @error('product_group')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_desc" class=" label_input">{{ __('product.product_desc') }}</label>
                <input type="text" id="product_desc" name="product_desc" placeholder=" ..." class="input_text"
                    value="{{ $product->product_desc }}" required />
                @error('product_desc')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_sdesc" class=" label_input">{{ __('product.product_sdesc') }}</label>
                <input type="text" id="product_sdesc" name="product_sdesc" placeholder=" ..." class="input_text"
                    value="{{ $product->product_sdesc }}" />
                @error('product_sdesc')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_edesc" class=" label_input">{{ __('product.product_edesc') }}</label>
                <input type="text" id="product_edesc" name="product_edesc" placeholder=" ..." class="input_text"
                    value="{{ $product->product_edesc }}" />
                @error('product_edesc')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_barcode" class=" label_input">{{ __('product.product_barcode') }}</label>
                <input type="text" id="product_barcode" name="product_barcode" placeholder=" ..." class="input_text"
                    value="{{ $product->product_barcode }}" required />
                @error('product_barcode')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="catproduct_group" class=" label_input">{{ __('product.catproduct_group') }}</label>
                <select name="catproduct_group" class="input_text" id="catproduct_group">
                    <option value="  "> {{ __('product.non_select') }} </option>
                    @foreach ($product_category as $item_cat)
                        <option value=" {{ $item_cat->catproduct_group }} "
                            @if ($product->catproduct_group == $item_cat->catproduct_group) selected @endif> {{ $item_cat->description }} </option>
                    @endforeach
                </select>
                @error('catproduct_group')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="subno" class=" label_input">{{ __('product.subno') }}</label>
                <select name="subno" class="input_text" id="subno">
                    @foreach ($card_type as $item_card)
                        <option value=" {{ $item_card->subno }} " @if ($product->subno == $item_card->subno) selected @endif>
                            {{ $item_card->subdesc }} </option>
                    @endforeach

                </select>
                @error('subno')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="unit_id" class=" label_input">{{ __('product.unit_id') }}</label>
                <select name="unit_id" class="input_text" id="unit_id">
                    <option value="  "> {{ __('product.non_select') }} </option>
                    @foreach ($product_unit as $item_unit)
                        <option value=" {{ $item_unit->unit_id }}" @if ($product->unit_id == $item_unit->unit_id) selected @endif>
                            {{ $item_unit->unit_name }} </option>
                    @endforeach
                </select>
                @error('unit_id')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="show_color" class=" label_input">{{ __('product.show_color') }}</label>
                <input type="text" id="show_color" name="show_color" placeholder=" ..." class="input_text"
                    value="{{ $product->show_color }}" />
            </div>
            <div>
                <label for="rabbit_discount" class=" label_input">{{ __('product.rabbit_discount') }}</label>
                <select name="rabbit_discount" id="rabbit_discount" class="input_text">
                    <option value="N" @if ($product->rabbit_discount == 'N') selected @endif>
                        {{ __('product.rabbit_discount_N') }} </option>
                    <option value="Y" @if ($product->rabbit_discount == 'Y') selected @endif>
                        {{ __('product.rabbit_discount_Y') }} </option>
                </select>

            </div>
            <div>
                <label for="show_kiosk" class=" label_input">{{ __('product.show_kiosk') }}</label>
                <select name="show_kiosk" id="show_kiosk" class="input_text">
                    <option value="N" @if ($product->show_kiosk == 'N') selected @endif>
                        {{ __('product.show_kiosk_N') }}</option>
                    <option value="Y" @if ($product->show_kiosk == 'Y') selected @endif>
                        {{ __('product.show_kiosk_Y') }}</option>
                </select>

            </div>

        </div>
        <button type="submit" class="submit_btn"> {{ __('menu.button.save') }} </button>
        <button type="button" onclick="history.back()" class="cancel_btn">{{ __('menu.button.cancel') }}</button>
    </form>
@endsection
@section('js-scripts')
    <script>
        $('#product_form').validate({
            rules: {
                product_id: "required",
                product_desc: "required",
                product_sdesc: "required",
                product_barcode: "required",
                product_group: "required",
                subno: "required",
            },
            messages: {
                product_id: `{{ __('product.product_id_valid') }}`,
                product_desc: `{{ __('product.product_desc_valid') }}`,
                product_sdesc: `{{ __('product.product_sdesc_valid') }}`,
                product_barcode: `{{ __('product.product_barcode_valid') }}`,
                product_group: `{{ __('product.product_group_valid') }}`,
                subno: `{{ __('product.subno_valid') }}`,
            }
        });
    </script>
@endsection
