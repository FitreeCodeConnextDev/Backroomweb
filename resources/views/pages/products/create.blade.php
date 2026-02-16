@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.product_add') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('products.index') }}" class="first_bc_a">
        {{ __('menu.product') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.product_add') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.product_add') }}
@endsection
@section('form-section')
    <form id="product_form" action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="grid_page">
            <div>
                <label for="product_id" class="label_input"> {{ __('product.product_id') }} </label>
                <input type="text" id="product_id" name="product_id" maxlength="6" class="input_text"
                    value="{{ old('product_id') }}" />
                @error('product_id')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_group" class=" label_input">{{ __('product.product_group') }}</label>
                <select name="product_group" class="input_text" id="product_group">
                    @foreach ($product_group as $item_group)
                        <option value=" {{ $item_group->groupproduct_id }} "> {{ $item_group->groupproduct_desc }}
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
                    value="" required />
                @error('product_desc')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_sdesc" class=" label_input">{{ __('product.product_sdesc') }}</label>
                <input type="text" id="product_sdesc" name="product_sdesc" placeholder=" ..." class="input_text"
                    value="" />
                @error('product_sdesc')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_edesc" class=" label_input">{{ __('product.product_edesc') }}</label>
                <input type="text" id="product_edesc" name="product_edesc" placeholder=" ..." class="input_text"
                    value="" />
                @error('product_edesc')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="product_barcode" class=" label_input">{{ __('product.product_barcode') }}</label>
                <input type="text" id="product_barcode" name="product_barcode" placeholder=" ..." class="input_text"
                    required />
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
                        <option value=" {{ $item_cat->catproduct_group }} "> {{ $item_cat->description }} </option>
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
                        <option value=" {{ $item_card->subno }} "> {{ $item_card->subdesc }} </option>
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
                        <option value=" {{ $item_unit->unit_id }} "> {{ $item_unit->unit_name }} </option>
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
                    value="" />
            </div>
            <div>
                <label for="rabbit_discount" class=" label_input">{{ __('product.rabbit_discount') }}</label>
                <select name="rabbit_discount" id="rabbit_discount" class="input_text">
                    <option value="N"> {{ __('product.rabbit_discount_N') }} </option>
                    <option value="Y"> {{ __('product.rabbit_discount_Y') }} </option>
                </select>

            </div>
            <div>
                <label for="show_kiosk" class=" label_input">{{ __('product.show_kiosk') }}</label>
                <select name="show_kiosk" id="show_kiosk" class="input_text">
                    <option value="N">{{ __('product.show_kiosk_N') }}</option>
                    <option value="Y">{{ __('product.show_kiosk_Y') }}</option>
                </select>
            </div>
            <div>
                <label for="type_group" class=" label_input">{{ __('product.type_group') }}</label>
                <select name="type_group" class="input_text" id="type_group">
                    <option value="  " selected disabled> {{ __('product.non_select') }} </option>
                    @foreach ($group_type as $item_type)
                        <option value=" {{ $item_type->type_group }} "> {{ $item_type->description }} </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="gtype_group" class=" label_input">{{ __('product.gtype_group') }}</label>
                <select name="gtype_group" class="input_text" id="gtype_group">
                    <option value="  " selected disabled> {{ __('product.non_select') }} </option>
                    @foreach ($gtype_group as $item_gtype)
                        <option value=" {{ $item_gtype->gtype_group }} "> {{ $item_gtype->description }} </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="product_img" class=" label_input">{{ __('product.product_img') }}</label>
                <input type="file" accept=".jpg,.jpeg,.png" aria-describedby="file_input_help" id="file_input"
                    id="product_img" name="product_img" class="input_text" />
                @error('product_img')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
        </div>
        <button type="submit" class="submit_btn"> {{ __('menu.button.save') }} </button>
        <button type="button" onclick="history.back()" class="cancel_btn">{{ __('menu.button.cancel') }}</button>
    </form>
@endsection
@section('js-scripts')
    <script type="module">
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
