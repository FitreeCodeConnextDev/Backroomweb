@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    // $branch_id = session('auth_user.branch_id');
    $vendor_product = DB::table('vendorproduct_info')
        ->join('product_info', 'vendorproduct_info.product_id', '=', 'product_info.product_id')
        ->where('vendor_id', '=', $vendor_id)
        ->where('branch_id', '=', $branch_id)
        ->where('vendorproduct_info.activeflag', '=', 1)
        ->orderBy('product_seq', 'asc')
        ->paginate(10);
    $group_product = DB::table('groupproduct_info')->select('groupproduct_id', 'groupproduct_desc')->get();
    $products = DB::table('product_info')
        ->select('product_id', 'product_desc', 'product_group')
        ->orderBy('product_id', 'desc')
        ->get();
    $vendor_gp = DB::table('vendorgp_info')->where('vendor_id', '=', $vendor_id)->get();

@endphp

<section>
    <div class="grid grid-cols-1 gap-3">
        <div>
            <button type="button" data-modal-target="vedor_product_info" data-modal-toggle="vedor_product_info"
                class="modal_button_add" type="button">
                {{ __('menu.button.add') }}
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="table-data">
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
                            <td> {{ $vendor_p->priceunit }} </td>
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
                        @include('pages.vendors.vendor_product.vendor_product_info.modal_edit')
                    @endforeach
                </tbody>
            </table>
            <div class=" mt-2">
                {{ $vendor_product->links() }}
            </div>
        </div>
    </div>
</section>
<section>
    <div id="vedor_product_info" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-5xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 ">
                        {{ __('vendor_product.vendor_product_promo') }}
                    </h3>
                    <button type="button" class="" data-modal-toggle="vedor_product_info">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" method="post" id="vendor_product_form">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-1 lg:grid-cols-4">
                        <input type="text" class=" sr-only" name="vendor_id" value="{{ $vendor_id }}">
                        <input type="text" class=" sr-only" name="branch_id" value="{{ $branch_id }}">
                        <input type="text" class=" sr-only" name="term_id" value="{{ $term_id }}">
                        <div>
                            <label for="product_id" class="label_input"> {{ __('vendor_product.product_id') }}
                            </label>
                            {{-- <input type="text" id="product_id" name="product_id" class="input_text" > --}}
                            <select class="input_text" name="product_id" id="product_id" autocomplete="off">
                                <option selected disabled> {{ __('vendor_product.select_products') }} </option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->product_id }}">({{ $product->product_id }})
                                        {{ $product->product_desc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="product_barcode" class="label_input">
                                {{ __('vendor_product.product_barcode') }} </label>
                            <input type="number" id="product_barcode" name="product_barcode" class="input_text"
                                required>
                        </div>
                        <div class="py-7">
                            <label class="inline-flex items-center cursor-pointer">
                                <input id="default-checkbox" type="hidden" name="product_free" value="N">
                                <input type="checkbox" name="product_free" value="Y" class="sr-only peer">
                                <div
                                    class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                </div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    {{ __('vendor_product.product_free') }} </span>
                            </label>
                        </div>
                        <div class="lg:py-7">
                            <div class="flex items-center mb-2">
                                <input checked id="default-radio-2" type="radio" value="1" name="groupvate"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="groupvate-2"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    {{ __('vendor_product.product_groupvat_y') }} </label>
                            </div>
                            <div class="flex items-center mb-4">
                                <input id="groupvate-1" type="radio" value="0" name="groupvate"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="groupvate-1"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('vendor_product.product_groupvat_n') }}</label>
                            </div>
                        </div>
                        <div>
                            <label for="product_desc"
                                class="label_input">{{ __('vendor_product.product_desc') }}</label>
                            <input type="text" id="product_desc" name="product_desc" class="input_text" disabled>
                        </div>
                        <div>
                            <label for="product_desc"
                                class="label_input">{{ __('vendor_product.product_sdesc') }}</label>
                            <input type="text" id="product_sdesc" name="product_sdesc" class="input_text"
                                disabled>
                        </div>
                        <div>
                            <label for="product_group" class="label_input">
                                {{ __('vendor_product.product_group') }}</label>
                            <select name="" class="input_text" id="product_group" required>
                                @foreach ($group_product as $group)
                                    <option value="{{ $group->groupproduct_id }}">
                                        {{ $group->groupproduct_desc }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="product_seq" class="label_input">
                                {{ __('vendor_product.product_seq') }}</label>
                            <input type="text" id="product_seq" name="product_seq" class="input_text" required>
                        </div>
                        <div>
                            <label for="use_point" class="label_input">
                                {{ __('vendor_product.product_use_point') }}</label>
                            <select name="use_point" id="use_point" class="input_text">
                                <option value="N"> {{ __('vendor_product.product_use_point_n') }} </option>
                                <option value="Y"> {{ __('vendor_product.product_use_point_y') }} </option>
                            </select>
                        </div>
                        <div>
                            <label for="add_point" class="label_input">
                                {{ __('vendor_product.product_add_point') }}</label>
                            <input type="number" id="add_point" value="0" name="add_point" class="input_text"
                                required>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3 grid-cols-1 gap-2">
                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-2 mt-2 border border-gray-200 rounded-md p-2">
                            <div class="flex space-x-3">
                                <div class=" w-24">
                                    <label for="priceunit" class="label_input">
                                        {{ __('vendor_product.product_priceunit') }}
                                    </label>
                                    <input type="text" id="priceunit" name="priceunit" class="input_text"
                                        required>
                                </div>
                                <div class="py-8">
                                    <button type="button" onclick="CopyValue()"
                                        class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>

                                    </button>
                                </div>
                            </div>
                            <div>
                                <label for="gp_normal" class="label_input">
                                    {{ __('vendor_product.product_gp_normal') }}</label>
                                <select name="gp_normal" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_normal }} ">{{ $gp->gp_normal }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pricediscount" class="label_input">
                                    {{ __('vendor_product.product_pricediscount') }}
                                </label>
                                <input type="text" id="pricediscount" name="pricediscount" class="input_text"
                                    required>
                            </div>
                            <div>
                                <label for="gp_promotion" class="label_input">
                                    {{ __('vendor_product.product_gp_promotion') }}</label>
                                <select name="gp_promotion" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_promotion }} ">{{ $gp->gp_promotion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pricemember" class="label_input">
                                    {{ __('vendor_product.product_price_member') }}
                                </label>
                                <input type="text" id="pricemember" name="pricemember" class="input_text"
                                    required>
                            </div>
                            <div>
                                <label for="gp_member" class="label_input">
                                    {{ __('vendor_product.product_gp_member') }}</label>
                                <select name="gp_member" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_member }} ">{{ $gp->gp_member }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pricestaff" class="label_input">
                                    {{ __('vendor_product.product_price_staff') }}
                                </label>
                                <input type="text" id="pricestaff" name="pricestaff" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_staff" class="label_input">
                                    {{ __('vendor_product.product_gp_staff') }}</label>
                                <select name="gp_staff" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_staff }} ">{{ $gp->gp_staff }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pricerabbit" class="label_input">
                                    {{ __('vendor_product.product_price_rabbit') }}
                                </label>
                                <input type="text" id="pricerabbit" name="pricerabbit" class="input_text"
                                    required>
                            </div>
                            <div>
                                <label for="gp_rabbit" class="label_input">
                                    {{ __('vendor_product.product_gp_rabbit') }}</label>
                                <select name="gp_rabbit" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_rabbit }} ">{{ $gp->gp_rabbit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="priceqr" class="label_input">
                                    {{ __('vendor_product.product_price_qr') }}
                                </label>
                                <input type="text" id="priceqr" name="priceqr" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_qr" class="label_input">
                                    {{ __('vendor_product.product_gp_qr') }}</label>
                                <select name="gp_qr" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_qr }} ">{{ $gp->gp_qr }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pirce_perunit" class="label_input">
                                    {{ __('vendor_product.product_perunit') }}
                                </label>
                                <input type="text" id="pirce_perunit" name="product_perunit" class="input_text"
                                    value="1.00">
                            </div>
                            <div>
                                <label for="vatrate" class="label_input">
                                    {{ __('vendor_product.product_vatrate') }}
                                </label>
                                <input type="text" id="vatrate" name="vatrate" class="input_text"
                                    value="7.00">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-2 mt-2 border border-gray-200 rounded-md p-2">
                            <div>
                                <label for="pricesp1" class="label_input">
                                    {{ __('vendor_product.product_sp1') }}
                                </label>
                                <input type="text" id="pricesp1" name="pricesp1" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp1" class="label_input">
                                    {{ __('vendor_product.product_gp_sp1') }}</label>
                                <select name="gp_sp1" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_sp1 }} ">{{ $gp->gp_sp1 }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pricesp2" class="label_input">
                                    {{ __('vendor_product.product_sp2') }}
                                </label>
                                <input type="text" id="pricesp2" name="pricesp2" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp2" class="label_input">
                                    {{ __('vendor_product.product_gp_sp2') }}</label>
                                <select name="gp_sp2" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_sp2 }} ">{{ $gp->gp_sp2 }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pricesp3" class="label_input">
                                    {{ __('vendor_product.product_sp3') }}
                                </label>
                                <input type="text" id="pricesp3" name="pricesp3" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp3" class="label_input">
                                    {{ __('vendor_product.product_gp_sp3') }}</label>
                                <select name="gp_sp3" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_sp3 }} ">{{ $gp->gp_sp3 }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pricesp4" class="label_input">
                                    {{ __('vendor_product.product_sp4') }}
                                </label>
                                <input type="text" id="pricesp4" name="pricesp4" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp4" class="label_input">
                                    {{ __('vendor_product.product_gp_sp4') }}</label>
                                <select name="gp_sp4" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_sp4 }} ">{{ $gp->gp_sp4 }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="pricesp5" class="label_input">
                                    {{ __('vendor_product.product_sp5') }}
                                </label>
                                <input type="text" id="pricesp5" name="pricesp5" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_sp5" class="label_input">
                                    {{ __('vendor_product.product_gp_sp5') }}
                                </label>
                                <select name="gp_sp5" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_sp5 }} ">{{ $gp->gp_sp5 }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="priceedc" class="label_input">
                                    {{ __('vendor_product.product_price_edc') }}
                                </label>
                                <input type="text" id="priceedc" name="priceedc" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_edc" class="label_input">
                                    {{ __('vendor_product.product_gp_edc') }}
                                </label>
                                <select name="gp_edc" class="input_text" id="">
                                    @foreach ($vendor_gp as $gp)
                                        <option value="{{ $gp->gp_edc }} ">{{ $gp->gp_edc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-2 border border-gray-200 rounded-md p-2">
                            <div>
                                <label for="campaign_code" class="label_input">
                                    {{ __('vendor_product.product_campaing_code') }}
                                </label>
                                <input type="text" id="campaign_code" name="campaing_code" class="input_text">
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mt-2">
                                <div>
                                    <label for="campaign_startdate" class="label_input">
                                        {{ __('vendor_product.product_campaing_startdate') }}
                                    </label>
                                    <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="campaign_startdate" name="campaing_startdate"
                                        class="input_text">
                                </div>
                                <div>
                                    <label for="campaign_enddate" class="label_input">
                                        {{ __('vendor_product.product_campaing_enddate') }}
                                    </label>
                                    <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="campaign_enddate" name="campaing_enddate"
                                        class="input_text">
                                </div>
                                <div>
                                    <label for="campaign_starttime"
                                        class="label_input">{{ __('vendor_product.product_campaing_starttime') }}</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="time" id="campaign_starttime" name="campaing_starttime"
                                            class="input_text" />
                                    </div>
                                </div>
                                <div>
                                    <label for="campaign_endtime"
                                        class="label_input">{{ __('vendor_product.product_campaing_endtime') }}</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <input type="time" id="campaign_endtime" name="campaing_endtime"
                                            class="input_text" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button id="saveButton1" class="submit_btn">
                            {{ __('menu.button.save') }}
                        </button>
                    </div>
                    {{-- @if ($errors->any())
                        <div class="error_alert" role="alert">
                            <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
                        </div>
                    @endif --}}
                </form>
            </div>
        </div>
    </div>
</section>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.4.3/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect("#product_id", {
        create: true,
        sortField: {
            field: "selected",
        }
    });
</script>
<script type="module">
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
                    let errorMessage = `{{ __('menu.is_failed') }}`;

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

    function CopyValue() {
        const valueprice = document.getElementById('priceunit').value;
        document.getElementById('pricediscount').value = valueprice;
        document.getElementById('pricemember').value = valueprice;
        document.getElementById('pricestaff').value = valueprice;
        document.getElementById('pricerabbit').value = valueprice;
        document.getElementById('priceqr').value = valueprice;
        document.getElementById('pricesp1').value = valueprice;
        document.getElementById('pricesp2').value = valueprice;
        document.getElementById('pricesp3').value = valueprice;
        document.getElementById('pricesp4').value = valueprice;
        document.getElementById('pricesp5').value = valueprice;
        document.getElementById('priceedc').value = valueprice;
    }

    function copyPriceToInputs() {
        const valueprice_edit = document.getElementById('priceunit_edit').value;
        document.getElementById('pricediscount_edit').value = valueprice_edit;
        document.getElementById('pricemember_edit').value = valueprice_edit;
        document.getElementById('pricestaff_edit').value = valueprice_edit;
        document.getElementById('pricerabbit_edit').value = valueprice_edit;
        document.getElementById('priceqr_edit').value = valueprice_edit;
        document.getElementById('pricesp1_edit').value = valueprice_edit;
        document.getElementById('pricesp2_edit').value = valueprice_edit;
        document.getElementById('pricesp3_edit').value = valueprice_edit;
        document.getElementById('pricesp4_edit').value = valueprice_edit;
        document.getElementById('pricesp5_edit').value = valueprice_edit;
        document.getElementById('priceedc_edit').value = valueprice_edit;
    }
</script>
