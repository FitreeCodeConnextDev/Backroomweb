@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    // $branch_id = session('auth_user.branch_id');
    $vendor_product = DB::table('vendorproduct_info')
        ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
        ->where('vendor_id', '=', $vendor_id)
        ->where('branch_id', '=', $branch_id)
        ->where('vendorproduct_info.activeflag', '=', 1)
        ->orderBy('product_seq', 'asc')
        // ->get();
        ->when(request()->get('search'), function ($query) {
            $search = request()->get('search');
            $query->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('vendorproduct_info.product_id', 'like', '%' . $search . '%')
                    ->orWhere('product_info.product_desc', 'like', '%' . $search . '%');
            });
        })
        ->paginate(10);
    $group_product = DB::table('groupproduct_info')->select('groupproduct_id', 'groupproduct_desc')->get();
    $products = DB::table('product_info')
        ->select('product_id', 'product_desc', 'product_group')
        ->orderBy('product_id', 'desc')
        ->get();
    $vendor_gp = DB::table('vendorgp_info')->where('vendor_id', '=', $vendor_id)->get();
    $search = request()->get('search', '');

    $vendor_clone_id = DB::table('vendor_info')
        ->where('vendor_id', '!=', $vendor_id)
        ->where('activeflag', '=', 1)
        ->select('vendor_id', 'vendor_name')
        ->orderBy('vendor_id', 'asc')
        ->get();

@endphp

<section>
    <div class="grid grid-cols-1 gap-3">
        <div class="flex justify-end space-x-2">
            <div>
                <button type="button" data-modal-target="vedor_product_info" data-modal-toggle="vedor_product_info"
                    class="modal_button_add" type="button">
                    {{ __('menu.button.add') }}
                </button>
            </div>
            <div>
                <button data-modal-target="clone_product" data-modal-toggle="clone_product" class="modal_button_clone"
                    type="button">
                    Clone
                </button>
            </div>
        </div>
        <div class="overflow-x-auto ">
            <div class="flex justify-start mb-3">
                <form action="{{ route('vendor_product_info_search', [$vendor_id, 'pages_search' => 'edit']) }}"
                    method="GET">
                    <input placeholder="Search..." name="search" value="{{ $search }}"
                        class="input block w-64 px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        name="search" type="search" />
                </form>
            </div>
            <div>
                <table class="table-data" id="vendorproduct-table">
                    <thead>
                        <tr>

                            <th scope="col"> {{ __('vendor_product.product_seq') }} </th>
                            <th scope="col"> {{ __('vendor_product.product_id') }} </th>
                            <th scope="col"> {{ __('vendor_product.product_desc') }} </th>
                            <th scope="col"> {{ __('vendor_product.product_price') }} </th>
                            <th scope="col"> {{ __('vendor_product.product_gp') }} </th>
                            <th scope="col"> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vendor_product as $vendor_p)
                            <tr>

                                <td> {{ $vendor_p->product_seq }} </td>
                                <td> {{ $vendor_p->product_id }} </td>
                                <td> {{ $vendor_p->product_desc }} </td>
                                <td> {{ number_format($vendor_p->priceunit, 2) }} </td>
                                <td> {{ $vendor_p->gp_normal }} </td>
                                <td>
                                    <div class="flex space-x-3">
                                        <div>
                                            <button type="button"
                                                data-modal-target="vendor-edit-{{ $vendor_p->product_seq }}"
                                                data-modal-toggle="vendor-edit-{{ $vendor_p->product_seq }}"
                                                class="edit-button" type="button">
                                                <svg class="w-[16px] h-[16px]" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="1.6"
                                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <div>
                                            <form
                                                action="{{ route('vendor-product.destroy_product', [$vendor_p->product_seq, $vendor_p->vendor_id, $vendor_p->branch_id]) }}"
                                                method="post" id="delete-form-{{ $vendor_p->product_seq }}">
                                                @csrf
                                                @method('PUT')
                                                <button id="del-button" class="del-button"
                                                    data-item-id="{{ $vendor_p->product_seq }}"
                                                    data-name="{{ $vendor_p->product_desc }}">
                                                    <svg class="w-[16px] h-[16px]" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="1.6"
                                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            {{-- @include('pages.vendors.vendor_product.vendor_product_info.modal_edit') --}}
                            <div id="vendor-edit-{{ $vendor_p->product_seq }}" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-5xl max-h-full">
                                    <!-- Modal content -->
                                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                                        <!-- Modal header -->
                                        <div
                                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                {{ __('vendor_product.vendor_product_data_edit') }}
                                            </h3>
                                            <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="vendor-edit-{{ $vendor_p->product_seq }}">
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="p-4 md:p-5">
                                            <form action="{{ route('vendor-product.update', $vendor_p->product_seq) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="grid gap-4 mb-4 grid-cols-1 lg:grid-cols-4">
                                                    <input type="text" class=" sr-only" name="vendor_id"
                                                        value="{{ $vendor_p->vendor_id }}">
                                                    <input type="text" class=" sr-only" name="branch_id"
                                                        value="{{ $vendor_p->branch_id }}">
                                                    <div>
                                                        <label for="product_id" class="label_input">
                                                            {{ __('vendor_product.product_id') }}
                                                        </label>
                                                        {{-- <input type="text" id="product_id" name="product_id" class="input_text" > --}}
                                                        <select class="input_text" id="product_id_modal" disabled>
                                                            <option selected disabled>
                                                                {{ __('vendor_product.select_products') }} </option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->product_id }}"
                                                                    @if ($vendor_p->product_id == $product->product_id) selected @endif>
                                                                    ({{ $product->product_id }})
                                                                    {{ $product->product_desc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="product_barcode" class="label_input">
                                                            {{ __('vendor_product.product_barcode') }} </label>
                                                        <input type="text" id="product_barcode_edit"
                                                            class="input_text"
                                                            value="{{ $vendor_p->product_barcode }}" disabled>
                                                    </div>
                                                    <div class="py-7">
                                                        <label class="inline-flex items-center cursor-pointer">
                                                            <input id="default-checkbox" type="hidden"
                                                                name="product_free" value="N">
                                                            <input type="checkbox" value="Y"
                                                                @if ($vendor_p->product_free == 'Y') checked @endif
                                                                name="product_free" class="sr-only peer">
                                                            <div
                                                                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                                                            </div>
                                                            <span class="ms-3 text-sm font-medium text-gray-900">
                                                                {{ __('vendor_product.product_free') }} </span>
                                                        </label>
                                                    </div>
                                                    <div class="mt-5">
                                                        <div>
                                                            <input id="product_groupvat_y" type="radio"
                                                                value="1" checked name="groupvate"
                                                                class="input_checkbox"
                                                                @if ($vendor_p->groupvat == 1) checked @endif>
                                                            <label for="product_groupvat_y"
                                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('vendor_product.product_groupvat_y') }}</label>
                                                        </div>
                                                        <div>
                                                            <input id="product_groupvat_n" type="radio"
                                                                value="0" name="groupvate"
                                                                class="input_checkbox"
                                                                @if ($vendor_p->groupvat == 0) checked @endif>
                                                            <label for="product_groupvat_n"
                                                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                {{ __('vendor_product.product_groupvat_n') }} </label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="product_desc" class="label_input">
                                                            {{ __('vendor_product.product_desc') }}
                                                        </label>
                                                        <input type="text" id="product_desc_edit"
                                                            value="{{ $vendor_p->product_desc }}" name="product_desc"
                                                            class="input_text" disabled>
                                                    </div>
                                                    <div>
                                                        <label for="product_sdesc" class="label_input">
                                                            {{ __('vendor_product.product_sdesc') }}
                                                        </label>
                                                        <input type="text" id="product_sdesc_edit"
                                                            value="{{ $vendor_p->product_sdesc }}"
                                                            name="product_sdesc" class="input_text" disabled>
                                                    </div>
                                                    <div>
                                                        <label for="product_group" class="label_input">
                                                            {{ __('vendor_product.product_group') }}
                                                        </label>
                                                        <select class="input_text" name=""
                                                            id="product_group_edit" disabled>
                                                            @foreach ($group_product as $group)
                                                                <option value="{{ $group->groupproduct_id }}"
                                                                    @if ($vendor_p->product_group == $group->groupproduct_id) selected @endif>
                                                                    {{ $group->groupproduct_desc }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="product_seq" class="label_input">
                                                            {{ __('vendor_product.product_seq') }}
                                                        </label>
                                                        <input type="number" id="product_seq"
                                                            value="{{ $vendor_p->product_seq }}" name="product_seq"
                                                            class="input_text" required>
                                                    </div>
                                                    <div>
                                                        <label for="use_point" class="label_input">
                                                            {{ __('vendor_product.product_use_point') }}
                                                        </label>
                                                        <select class="input_text" name="use_point" id="use_point">
                                                            <option value="N"
                                                                @if ($vendor_p->use_point == 'N') selected @endif>
                                                                {{ __('vendor_product.product_use_point_n') }}
                                                            </option>
                                                            <option value="Y"
                                                                @if ($vendor_p->use_point == 'Y') selected @endif>
                                                                {{ __('vendor_product.product_use_point_y') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label for="add_point" class="label_input">
                                                            {{ __('vendor_product.product_add_point') }}
                                                        </label>
                                                        <input type="text" id="add_point"
                                                            value="{{ $vendor_p->add_point }}" name="add_point"
                                                            class="input_text" required>
                                                    </div>
                                                </div>
                                                <div class="grid lg:grid-cols-3 grid-cols-1 gap-3">
                                                    <div
                                                        class="grid lg:grid-cols-2 gap-2 border border-gray-200 rounded-lg p-3">
                                                        <div class=" grid grid-cols-2 gap-1">
                                                            <div>
                                                                <label for="priceunit" class="label_input">
                                                                    {{ __('vendor_product.product_priceunit') }}
                                                                </label>
                                                                <input type="number" id="priceunit_edit"
                                                                    value="{{ $vendor_p->priceunit }}"
                                                                    name="priceunit" class="input_text lg:w-20"
                                                                    required>
                                                            </div>
                                                            <div class="mt-7  flex justify-end">
                                                                <button type="button" onclick="copyPriceToInputs()"
                                                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 me-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        class="size-5">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label for="gp_normal" class="label_input">
                                                                {{ __('vendor_product.product_gp_normal') }} </label>
                                                            {{-- <input type="text" id="gp_normal" name="gp_normal" class="input_text" required> --}}
                                                            <select name="gp_normal" id="gp_normal"
                                                                class="input_text">
                                                                @foreach ($vendor_gp as $gp_normal)
                                                                    <option value="{{ $gp_normal->gp_normal }}"
                                                                        @if ($vendor_p->gp_normal == $gp_normal->gp_normal) selected @endif>
                                                                        {{ $gp_normal->gp_normal }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="pricediscount" class="label_input">
                                                                {{ __('vendor_product.product_pricediscount') }}
                                                            </label>
                                                            <input type="number" id="pricediscount_edit"
                                                                value="{{ $vendor_p->pricediscount }}"
                                                                name="pricediscount" class="input_text" required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_promotion" class="label_input">
                                                                {{ __('vendor_product.product_gp_promotion') }}
                                                            </label>
                                                            <select name="gp_promotion" id="gp_promotion"
                                                                class="input_text">
                                                                @foreach ($vendor_gp as $gp_promotion)
                                                                    <option value="{{ $gp_promotion->gp_promotion }}"
                                                                        @if ($vendor_p->gp_promotion == $gp_promotion->gp_promotion) selected @endif>
                                                                        {{ $gp_promotion->gp_promotion }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="pricemember" class="label_input">
                                                                {{ __('vendor_product.product_price_member') }}
                                                            </label>
                                                            <input type="number" id="pricemember_edit"
                                                                value="{{ $vendor_p->pricemember }}"
                                                                name="pricemember" class="input_text" required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_member" class="label_input">
                                                                {{ __('vendor_product.product_gp_member') }} </label>
                                                            <select name="gp_member" id="gp_member"
                                                                class="input_text">
                                                                @foreach ($vendor_gp as $gp_member)
                                                                    <option value="{{ $gp_member->gp_member }}"
                                                                        @if ($vendor_p->gp_member == $gp_member->gp_member)  @endif>
                                                                        {{ $gp_member->gp_member }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="pricestaff" class="label_input">
                                                                {{ __('vendor_product.product_price_staff') }} </label>
                                                            <input type="number" id="pricestaff_edit"
                                                                name="pricestaff" class="input_text"
                                                                value="{{ $vendor_p->pricestaff }}" required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_staff" class="label_input">
                                                                {{ __('vendor_product.product_gp_staff') }} </label>
                                                            <select name="gp_staff" id="gp_staff"
                                                                class="input_text">
                                                                @foreach ($vendor_gp as $gp_staff)
                                                                    <option value="{{ $gp_staff->gp_staff }}"
                                                                        @if ($vendor_p->gp_staff == $gp_staff->gp_staff)  @endif>
                                                                        {{ $gp_staff->gp_staff }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="pricerabbit" class="label_input">
                                                                {{ __('vendor_product.product_price_rabbit') }}
                                                            </label>
                                                            <input type="number" id="pricerabbit_edit"
                                                                name="pricerabbit" class="input_text"
                                                                value="{{ $vendor_p->pricerabbit }}" required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_rabbit" class="label_input">
                                                                {{ __('vendor_product.product_gp_rabbit') }} </label>
                                                            <select name="gp_rabbit" id="gp_rabbit"
                                                                class="input_text">
                                                                @foreach ($vendor_gp as $gp_rabbit)
                                                                    <option value="{{ $gp_rabbit->gp_rabbit }}"
                                                                        @if ($vendor_p->gp_rabbit == $gp_rabbit->gp_rabbit)  @endif>
                                                                        {{ $gp_rabbit->gp_rabbit }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="priceqr" class="label_input">
                                                                {{ __('vendor_product.product_price_qr') }} </label>
                                                            <input type="number" id="priceqr_edit" name="priceqr"
                                                                class="input_text" value="{{ $vendor_p->priceqr }}"
                                                                required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_qr" class="label_input">
                                                                {{ __('vendor_product.product_gp_qr') }} </label>
                                                            <select name="gp_qr" id="gp_qr" class="input_text">
                                                                @foreach ($vendor_gp as $gp_qr)
                                                                    <option value="{{ $gp_qr->gp_qr }}"
                                                                        @if ($vendor_p->gp_qr == $gp_qr->gp_qr)  @endif>
                                                                        {{ $gp_qr->gp_qr }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="product_perunit" class="label_input">
                                                                {{ __('vendor_product.product_perunit') }} </label>
                                                            <input type="number" id="product_perunit"
                                                                value="{{ $vendor_p->product_perunit }}"
                                                                name="product_perunit" class="input_text" required>
                                                        </div>
                                                        <div>
                                                            <label for="vatrate" class="label_input">
                                                                {{ __('vendor_product.product_vatrate') }} </label>
                                                            <input type="number" id="vatrate"
                                                                value="{{ $vendor_p->vatrate }}" name="vatrate"
                                                                class="input_text" required>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="grid lg:grid-cols-2 gap-2 border border-gray-200 rounded-lg p-3">
                                                        <div>
                                                            <label for="pricesp1_edit" class="label_input">
                                                                {{ __('vendor_product.product_sp1') }}
                                                            </label>
                                                            <input type="number" id="pricesp1_edit" name="pricesp1"
                                                                class="input_text" value="{{ $vendor_p->pricesp1 }}"
                                                                required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_normal" class="label_input">
                                                                {{ __('vendor_product.product_gp_sp1') }} </label>
                                                            <select name="gp_sp1" id="gp_sp1" class="input_text">
                                                                @foreach ($vendor_gp as $gp_sp1)
                                                                    <option value="{{ $gp_sp1->gp_sp1 }}"
                                                                        @if ($vendor_p->gp_sp1 == $gp_sp1->gp_sp1)  @endif>
                                                                        {{ $gp_sp1->gp_sp1 }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="pricesp2" class="label_input">
                                                                {{ __('vendor_product.product_sp2') }} </label>
                                                            <input type="number" id="pricesp2_edit" name="pricesp2"
                                                                class="input_text" value="{{ $vendor_p->pricesp2 }}"
                                                                required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_sp2" class="label_input">
                                                                {{ __('vendor_product.product_gp_sp2') }} </label>
                                                            <select name="gp_sp2" id="gp_sp2" class="input_text">
                                                                @foreach ($vendor_gp as $gp_sp2)
                                                                    <option value="{{ $gp_sp2->gp_sp2 }}"
                                                                        @if ($vendor_p->gp_sp2 == $gp_sp2->gp_sp2)  @endif>
                                                                        {{ $gp_sp2->gp_sp2 }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="pricesp3" class="label_input">
                                                                {{ __('vendor_product.product_sp3') }} </label>
                                                            <input type="number" id="pricesp3_edit" name="pricesp3"
                                                                class="input_text" value="{{ $vendor_p->pricesp3 }}"
                                                                required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_sp3" class="label_input">
                                                                {{ __('vendor_product.product_gp_sp3') }} </label>
                                                            <select name="gp_sp3" id="gp_sp3" class="input_text">
                                                                @foreach ($vendor_gp as $gp_sp3)
                                                                    <option value="{{ $gp_sp3->gp_sp3 }}"
                                                                        @if ($vendor_p->gp_sp3 == $gp_sp3->gp_sp3)  @endif>
                                                                        {{ $gp_sp3->gp_sp3 }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="pricesp4" class="label_input">
                                                                {{ __('vendor_product.product_sp4') }} </label>
                                                            <input type="number" id="pricesp4_edit" name="pricesp4"
                                                                class="input_text" value="{{ $vendor_p->pricesp4 }}"
                                                                required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_sp4" class="label_input">
                                                                {{ __('vendor_product.product_gp_sp4') }} </label>
                                                            <select name="gp_sp4" id="gp_sp4" class="input_text">
                                                                @foreach ($vendor_gp as $gp_sp4)
                                                                    <option value="{{ $gp_sp4->gp_sp4 }}"
                                                                        @if ($vendor_p->gp_sp4 == $gp_sp4->gp_sp4)  @endif>
                                                                        {{ $gp_sp4->gp_sp4 }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="pricesp5" class="label_input">
                                                                {{ __('vendor_product.product_sp5') }} </label>
                                                            <input type="number" id="pricesp5_edit" name="pricesp5"
                                                                class="input_text" value="{{ $vendor_p->pricesp5 }}"
                                                                required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_sp5" class="label_input">
                                                                {{ __('vendor_product.product_gp_sp5') }} </label>
                                                            <select name="gp_sp5" id="gp_sp5" class="input_text">
                                                                @foreach ($vendor_gp as $gp_sp5)
                                                                    <option value="{{ $gp_sp5->gp_sp5 }}"
                                                                        @if ($vendor_p->gp_sp5 == $gp_sp5->gp_sp5)  @endif>
                                                                        {{ $gp_sp5->gp_sp5 }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="priceedc" class="label_input">
                                                                {{ __('vendor_product.product_price_edc') }} </label>
                                                            <input type="number" id="priceedc_edit" name="priceedc"
                                                                class="input_text" value="{{ $vendor_p->priceedc }}"
                                                                required>
                                                        </div>
                                                        <div>
                                                            <label for="gp_edc" class="label_input">
                                                                {{ __('vendor_product.product_gp_edc') }} </label>
                                                            <select name="gp_edc" id="gp_edc" class="input_text">
                                                                @foreach ($vendor_gp as $gp_edc)
                                                                    <option value="{{ $gp_edc->gp_edc }}"
                                                                        @if ($vendor_p->gp_edc == $gp_edc->gp_edc)  @endif>
                                                                        {{ $gp_edc->gp_edc }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="border border-gray-200 rounded-lg p-3">
                                                        <div>
                                                            <label for="campaing_code" class="label_input">
                                                                {{ __('vendor_product.product_campaing_code') }}
                                                            </label>
                                                            <input type="text" id="campaing_code"
                                                                name="campaing_code"
                                                                value="{{ $vendor_p->campaign_code }}"
                                                                class="input_text">
                                                        </div>
                                                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-1 mt-2">
                                                            <div>
                                                                <label for="campaing_startdate" class=" label_input">
                                                                    {{ __('vendor_product.product_campaing_startdate') }}
                                                                </label>
                                                                <input type="date" id="campaing_startdate"
                                                                    name="campaing_startdate" class="input_text"
                                                                    value="{{ date('Y-m-d', strtotime($vendor_p->campaign_startdate)) }}" />
                                                            </div>
                                                            <div>
                                                                <label for="campaing_starttime"
                                                                    class=" label_input">{{ __('vendor_product.product_campaing_starttime') }}</label>
                                                                <div class="relative">
                                                                    <div
                                                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                                            aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            fill="currentColor" viewBox="0 0 24 24">
                                                                            <path fill-rule="evenodd"
                                                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </div>
                                                                    <input type="time" id="campaing_starttime"
                                                                        name="campaing_starttime" class="input_text"
                                                                        value="{{ date('H:i', strtotime($vendor_p->campaign_startdate)) }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-1 mt-2">
                                                            <div>
                                                                <label for="campaing_enddate" class=" label_input">
                                                                    {{ __('vendor_product.product_campaing_enddate') }}
                                                                </label>
                                                                <input type="date" id="campaing_enddate"
                                                                    name="campaing_enddate" class="input_text"
                                                                    value="{{ date('Y-m-d', strtotime($vendor_p->campaign_enddate)) }}" />
                                                            </div>
                                                            <div>
                                                                <label for="campaing_endtime"
                                                                    class=" label_input">{{ __('vendor_product.product_campaing_endtime') }}</label>
                                                                <div class="relative">
                                                                    <div
                                                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                                            aria-hidden="true"
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            fill="currentColor" viewBox="0 0 24 24">
                                                                            <path fill-rule="evenodd"
                                                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                                                clip-rule="evenodd" />
                                                                        </svg>
                                                                    </div>
                                                                    <input type="time" id="campaing_endtime"
                                                                        name="campaing_endtime" class="input_text"
                                                                        value="{{ date('H:i', strtotime($vendor_p->campaign_enddate)) }}" />
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <button id="vendor_product_submit" class="submit_btn">
                                                        {{ __('menu.button.save') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Clone Modal --}}
            <div id="clone_product" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <!-- Modal header -->
                        <div
                            class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ __('vendor_product.clone_product') }}
                            </h3>
                            <button type="button"
                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="clone_product">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <div class="p-4 md:p-5">
                            <form class="space-y-4" action="{{ route('vendor_product_clone_product') }}"
                                method="POST">
                                @csrf
                                <div>
                                    <input type="hidden" name="product_vendor_id" id="product_vendor_id"
                                        value="{{ $vendor_id }}">
                                    <label for="clone_vendor_id" class="label_input">
                                        {{ __('vendor_product.clone_vendor') }}</label>
                                    <select name="clone_vendor_id" id="clone_vendor_id" class="input_text">
                                        <option value=" ">{{ __('vendor_product.choose_vendor') }}</option>
                                        @foreach ($vendor_clone_id as $vendorclone)
                                            <option value="{{ $vendorclone->vendor_id }}">
                                                {{ $vendorclone->vendor_name }} ({{ $vendorclone->vendor_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="submit_btn">{{ __('menu.button.confirm') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class=" mt-2">
                {{ $vendor_product->links() }}
            </div>
        </div>
    </div>
</section>
@include('pages.vendors.vendor_product.vendor_product_info.modal_create')
<script type="module">
    new TomSelect('#product_id', {
        plugins: ['dropdown_input'],
    });
    $(document).ready(function() {
        // เมื่อคลิกปุ่มที่มี id="saveButton"
        $('#saveButton1').on('click', function(e) {
            e.preventDefault(); // หยุดการทำงานของ submit แบบปกติ

            // ใช้ FormData เพื่อจับข้อมูลจากฟอร์ม
            var formData = new FormData($('#vendor_product_form')[0]);

            // ส่งข้อมูลไปยัง Route ที่กำหนดโดยใช้ Ajax
            $.ajax({
                url: '{{ route('vendor-product.store') }}', // URL ที่จะส่งข้อมูลไป
                type: 'POST', // ใช้ Method POST
                data: formData, // ข้อมูลที่ส่งไป
                processData: false, // บอกว่าไม่ต้องแปลงข้อมูล
                contentType: false, // บอกว่าไม่ต้องตั้ง Content-Type
                success: function(response) {
                    // เมื่อส่งข้อมูลสำเร็จ
                    Swal.fire({
                        text: `{{ __('menu.save_is_success') }}`,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 3000,
                    });

                    // ปิด Modal
                    $('#vedor_product_info').addClass('hidden');

                    // หากต้องการรีเฟรชข้อมูล หรือทำอะไรก่อนปิดฟอร์ม
                    window.location.reload(); // รีโหลดหน้า (ถ้าต้องการ)
                },
                error: function(xhr, status, error) {
                    let errorMessage = `{{ __('vendor_product.save_failure_unique') }}`;

                    // Check if the error is a validation error
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Gather all validation errors and display them
                        let errorList = '';
                        for (let field in xhr.responseJSON.errors) {
                            errorList +=
                                `<li>${xhr.responseJSON.errors[field].join(', ')}</li>`;
                        }
                        errorMessage = `<ul>${errorList}</ul>`;
                    }

                    // Show error message with the validation errors
                    Swal.fire({
                        title: `{{ __('menu.save_is_failed') }}`, // Failure title
                        html: errorMessage, // Show validation error list
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                    // เมื่อเกิดข้อผิดพลาด
                    // alert('เกิดข้อผิดพลาด: ' + error);
                    // console.log(xhr.responseText); // แสดงข้อผิดพลาดใน console
                }
            });
        });

        // ปิด Modal เมื่อคลิกปุ่มปิด
        $('[data-modal-hide="vedor_product_info"]').on('click', function() {
            $('#vedor_product_info').addClass('hidden');
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        // ดักจับ Error จาก Validation ($request->validate)
        @if ($errors->any())
            Swal.fire({
                icon: 'warning',
                title: "{{ __('menu.is_warning') }}",
                html: '{!! implode('<br>', $errors->all()) !!}',
            });
        @endif

        // ดักจับ Success จากที่เรา with('swal_success', ...)
        @if (session('clone_success'))
            Swal.fire({
                icon: 'success',
                title: "{{ __('menu.is_success') }}",
                text: "{{ session('clone_success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        // ดักจับ Error จากที่เรา with('swal_error', ...)
        @if (session('clone_error'))
            Swal.fire({
                icon: 'error',
                title: "{{ __('menu.is_failed') }}",
                text: "{{ session('clone_error') }}",
            });
        @endif
    });
</script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');

        productSelect.addEventListener('change', function(event) {
            const productId = event.target.value;

            if (productId) {
                // ส่งคำขอไปยัง Laravel Route
                fetch(`/get-product-details/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            // ถ้าข้อผิดพลาดเกิดขึ้น เช่น Product ไม่เจอ
                            console.error(data.error);
                            return;
                        }

                        // เติมค่าให้กับ input fields ตามที่ได้รับจาก Controller
                        document.getElementById('product_barcode').value = data.product_barcode;
                        document.getElementById('product_desc').value = data.product_desc;
                        document.getElementById('product_sdesc').value = data.product_sdesc;
                        document.getElementById('product_group').value = data.product_group;
                    })
                    .catch(error => {
                        console.error('Error fetching product details:', error);
                    });
            }
        });
    });

    function copyPriceToFields(sourceId, suffixList) {
        const value = document.getElementById(sourceId).value;
        suffixList.forEach(fieldId => {
            const element = document.getElementById(fieldId);
            if (element) {
                element.value = value;
            }
        });
    }

    function CopyValue() {
        const fieldIds = ['pricediscount', 'pricemember', 'pricestaff', 'pricerabbit', 'priceqr', 'pricesp1',
            'pricesp2', 'pricesp3', 'pricesp4', 'pricesp5', 'priceedc'
        ];
        copyPriceToFields('priceunit', fieldIds);
    }

    function copyPriceToInputs() {
        const fieldIds = ['pricediscount_edit', 'pricemember_edit', 'pricestaff_edit', 'pricerabbit_edit',
            'priceqr_edit', 'pricesp1_edit', 'pricesp2_edit', 'pricesp3_edit', 'pricesp4_edit', 'pricesp5_edit',
            'priceedc_edit'
        ];
        copyPriceToFields('priceunit_edit', fieldIds);
    }
</script>
