@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.product_group') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('card-promotion.index') }}" class="first_bc_a" id="index_page">
        {{ __('menu.product_group') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.product_group_add') }}
    </a>
@endsection

@section('page_title')
    {{ __('menu.product_group_add') }}
@endsection
@section('form-section')
    <form id="product_group" action="{{ route('products-groups.store') }}" method="post">
        @csrf
        <div class="grid_page">
            <div>
                <label for="text" class="label_input"> {{ __('product_group.groupproduct_id') }} </label>
                <input type="text" id="text" maxlength="3" name="groupproduct_id" placeholder="001, 002 ..." class="input_text"
                    value="" required />
                @error('groupproduct_id')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="text" class=" label_input">{{ __('product_group.groupproduct_desc') }}</label>
                <input type="text" id="groupproduct_desc" name="groupproduct_desc" placeholder="ของหวาน, ของคาว ..."
                    class="input_text" maxlength="128" value="" required />
                @error('groupproduct_desc')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="text" class=" label_input">{{ __('product_group.vatrate') }}</label>
                <input type="number" id="vatrate" name="vatrate" value="7.00" placeholder="0.00" class="input_text"
                    required />
                @error('vatrate')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <label for="text" class=" label_input">{{ __('product_group.discountrate') }}</label>
                <input type="number" id="discountrate" name="discountrate" value="0.00" placeholder="0.00"
                    class="input_text" required />
                @error('discountrate')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                    </p>
                @enderror
            </div>
            <div>
                <div>
                    <label for="text" class=" label_input">{{ __('product_group.use_point') }}</label>
                    <select id="use_point" name="use_point" class="input_text">
                        <option selected disabled>เลือก</option>
                        <option value="N">ไม่ใช้</option>
                        <option value="Y">ใช้</option>
                    </select>
                    @error('use_point')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <div>
                <label for="text"
                    class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('product_group.add_point') }}</label>
                <input type="number" id="add_point" name="add_point" placeholder="0.00" class="input_text" value="0.00"
                    required />
                @error('add_point')
                    <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('products-groups.index') }}">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
    </form>
@endsection
@section('js-scripts')
    <script type="module">
        $('#product_group').validate({
            rules: {
                groupproduct_id : "required",
                groupproduct_desc : "required",
                vatrate : "required",
                discountrate : "required",
                use_point : "required",
                add_point : "required",
            },
            messages: {
                groupproduct_id: `{{ __('product_group.groupproduct_id_valid')}}`,
                groupproduct_desc : `{{ __('product_group.groupproduct_desc_valid')}}`,
                vatrate : `{{ __('product_group.vatrate_valid')}}`,
                discountrate : `{{ __('product_group.discountrate_valid')}}`,
                use_point : `{{ __('product_group.use_point_valid')}}`,
                add_point : `{{ __('product_group.add_point_valid')}}`
            }
        });
    </script>
@endsection
