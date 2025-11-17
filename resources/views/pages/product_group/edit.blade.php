@extends('layouts.createpage')

@section('title_page')
    {{ __('menu.payment_types') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('payment_type.index') }}" class="first_bc_a" id="cancel_button">
        {{ __('menu.payment_types') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.product_group_edit') }}
    </a>
@endsection

@section('page_title')
    {{ __('menu.product_group_edit') }}
@endsection
@section('form-section')
    <form action="{{ route('products-groups.update', $groupproduct_info->groupproduct_id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="grid_page">
                <div>
                    <label for="text" class="label_input"> {{ __('product_group.groupproduct_id') }} </label>
                    <input type="text" id="text" name="groupproduct_id" 
                        class="input_text" value="{{ $groupproduct_info->groupproduct_id }}" disabled />
                    @error('groupproduct_id')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="text" class=" label_input">{{ __('product_group.groupproduct_desc') }}</label>
                    <input type="text" id="text" name="groupproduct_desc" placeholder="ของหวาน, ของคาว ..."
                        class="input_text" value="{{ $groupproduct_info->groupproduct_desc }}" required />
                    @error('groupproduct_desc')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="text" class=" label_input">{{ __('product_group.vatrate') }}</label>
                    <input type="number" id="text" name="vatrate" placeholder="0.00" class="input_text"
                        value="{{ $groupproduct_info->vatrate }}" required />
                    @error('vatrate')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="text" class=" label_input">{{ __('product_group.discountrate') }}</label>
                    <input type="number" id="text" name="discountrate" value="{{ $groupproduct_info->discountrate }}"
                        placeholder="0.00" class="input_text" required />
                    @error('discountrate')
                        <p class="mt-2 text-sm text-red-600 "><span class="font-medium">คำเตือน</span> {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <div>
                        <label for="text" class=" label_input">{{ __('product_group.use_point') }}</label>
                        <select name="use_point" class="input_text">
                            <option selected disabled>เลือก</option>
                            <option value="N" @if ($groupproduct_info->use_point == 'N') selected @endif>ไม่ใช้</option>
                            <option value="Y" @if ($groupproduct_info->use_point == 'Y') selected @endif>ใช้</option>
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
                    <input type="number" id="text" name="add_point" class="input_text"
                        value="{{ $groupproduct_info->add_point }}" required />
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
@endsection
