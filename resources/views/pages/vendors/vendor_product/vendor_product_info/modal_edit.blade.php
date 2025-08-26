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
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form action="{{ route('vendor-product.update', $vendor_p->product_seq) }}" method="post">
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
                                <option selected disabled> {{ __('vendor_product.select_products') }} </option>
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
                            <input type="text" id="product_barcode_edit" class="input_text"
                                value="{{ $vendor_p->product_barcode }}" disabled>
                        </div>
                        <div class="py-7">
                            <label class="inline-flex items-center cursor-pointer">
                                <input id="default-checkbox" type="hidden" name="product_free" value="N">
                                <input type="checkbox" value="Y" @if ($vendor_p->product_free == 'Y') checked @endif
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
                                <input id="product_groupvat_y" type="radio" value="1" checked name="groupvate"
                                    class="input_checkbox" @if ($vendor_p->groupvat == 1) checked @endif>
                                <label for="product_groupvat_y"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('vendor_product.product_groupvat_y') }}</label>
                            </div>
                            <div>
                                <input id="product_groupvat_n" type="radio" value="0" name="groupvate"
                                    class="input_checkbox" @if ($vendor_p->groupvat == 0) checked @endif>
                                <label for="product_groupvat_n"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                    {{ __('vendor_product.product_groupvat_n') }} </label>
                            </div>
                        </div>
                        <div>
                            <label for="product_desc" class="label_input">
                                {{ __('vendor_product.product_desc') }}
                            </label>
                            <input type="text" id="product_desc_edit" value="{{ $vendor_p->product_desc }}"
                                name="product_desc" class="input_text" disabled>
                        </div>
                        <div>
                            <label for="product_sdesc" class="label_input">
                                {{ __('vendor_product.product_sdesc') }}
                            </label>
                            <input type="text" id="product_sdesc_edit" value="{{ $vendor_p->product_sdesc }}"
                                name="product_sdesc" class="input_text" disabled>
                        </div>
                        <div>
                            <label for="product_group" class="label_input">
                                {{ __('vendor_product.product_group') }}
                            </label>
                            <select class="input_text" name="" id="product_group_edit" disabled>
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
                            <input type="text" id="product_seq" value="{{ $vendor_p->product_seq }}"
                                name="product_seq" class="input_text" required>
                        </div>
                        <div>
                            <label for="use_point" class="label_input">
                                {{ __('vendor_product.product_use_point') }}
                            </label>
                            <select class="input_text" name="use_point" id="use_point">
                                <option value="N" @if ($vendor_p->use_point == 'N') selected @endif>
                                    {{ __('vendor_product.product_use_point_n') }}
                                </option>
                                <option value="Y" @if ($vendor_p->use_point == 'Y') selected @endif>
                                    {{ __('vendor_product.product_use_point_y') }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="add_point" class="label_input">
                                {{ __('vendor_product.product_add_point') }}
                            </label>
                            <input type="text" id="add_point" value="{{ $vendor_p->add_point }}"
                                name="add_point" class="input_text" required>
                        </div>
                    </div>
                    <div class="grid lg:grid-cols-3 grid-cols-1 gap-3">
                        <div class="grid lg:grid-cols-2 gap-2 border border-gray-200 rounded-lg p-3">
                            <div class=" grid grid-cols-2 gap-1">
                                <div>
                                    <label for="priceunit" class="label_input">
                                        {{ __('vendor_product.product_priceunit') }}
                                    </label>
                                    <input type="text" id="priceunit_edit" value="{{ $vendor_p->priceunit }}"
                                        name="priceunit" class="input_text lg:w-20" required>
                                </div>
                                <div class="mt-7  flex justify-end">
                                    <button type="button" onclick="copyPriceToInputs()"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label for="gp_normal" class="label_input">
                                    {{ __('vendor_product.product_gp_normal') }} </label>
                                {{-- <input type="text" id="gp_normal" name="gp_normal" class="input_text" required> --}}
                                <select name="gp_normal" id="gp_normal" class="input_text">
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
                                    {{ __('vendor_product.product_pricediscount') }} </label>
                                <input type="text" id="pricediscount_edit"
                                    value="{{ $vendor_p->pricediscount }}" name="pricediscount"
                                    class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_promotion" class="label_input">
                                    {{ __('vendor_product.product_gp_promotion') }} </label>
                                <select name="gp_promotion" id="gp_promotion" class="input_text">
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
                                    {{ __('vendor_product.product_price_member') }} </label>
                                <input type="text" id="pricemember_edit" value="{{ $vendor_p->pricemember }}"
                                    name="pricemember" class="input_text" required>
                            </div>
                            <div>
                                <label for="gp_member" class="label_input">
                                    {{ __('vendor_product.product_gp_member') }} </label>
                                <select name="gp_member" id="gp_member" class="input_text">
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
                                <input type="text" id="pricestaff_edit" name="pricestaff" class="input_text"
                                    value="{{ $vendor_p->pricestaff }}" required>
                            </div>
                            <div>
                                <label for="gp_staff" class="label_input">
                                    {{ __('vendor_product.product_gp_staff') }} </label>
                                <select name="gp_staff" id="gp_staff" class="input_text">
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
                                    {{ __('vendor_product.product_price_rabbit') }} </label>
                                <input type="text" id="pricerabbit_edit" name="pricerabbit" class="input_text"
                                    value="{{ $vendor_p->pricerabbit }}" required>
                            </div>
                            <div>
                                <label for="gp_rabbit" class="label_input">
                                    {{ __('vendor_product.product_gp_rabbit') }} </label>
                                <select name="gp_rabbit" id="gp_rabbit" class="input_text">
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
                                <input type="text" id="priceqr_edit" name="priceqr" class="input_text"
                                    value="{{ $vendor_p->priceqr }}" required>
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
                                <input type="text" id="product_perunit"
                                    value="{{ $vendor_p->product_perunit }}" name="product_perunit"
                                    class="input_text" required>
                            </div>
                            <div>
                                <label for="vatrate" class="label_input">
                                    {{ __('vendor_product.product_vatrate') }} </label>
                                <input type="text" id="vatrate" value="{{ $vendor_p->vatrate }}"
                                    name="vatrate" class="input_text" required>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-2 border border-gray-200 rounded-lg p-3">
                            <div>
                                <label for="pricesp1_edit" class="label_input">
                                    {{ __('vendor_product.product_sp1') }}
                                </label>
                                <input type="text" id="pricesp1_edit" name="pricesp1" class="input_text"
                                    value="{{ $vendor_p->pricesp1 }}" required>
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
                                <input type="text" id="pricesp2_edit" name="pricesp2" class="input_text"
                                    value="{{ $vendor_p->pricesp2 }}" required>
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
                                <input type="text" id="pricesp3_edit" name="pricesp3" class="input_text"
                                    value="{{ $vendor_p->pricesp3 }}" required>
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
                                <input type="text" id="pricesp4_edit" name="pricesp4" class="input_text"
                                    value="{{ $vendor_p->pricesp4 }}" required>
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
                                <input type="text" id="pricesp5_edit" name="pricesp5" class="input_text"
                                    value="{{ $vendor_p->pricesp5 }}" required>
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
                                <input type="text" id="priceedc_edit" name="priceedc" class="input_text"
                                    value="{{ $vendor_p->priceedc }}" required>
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
                                    {{ __('vendor_product.product_campaing_code') }} </label>
                                <input type="text" id="campaing_code" name="campaing_code"
                                    value="{{ $vendor_p->campaign_code }}" class="input_text">
                            </div>
                            <div class="grid lg:grid-cols-2 grid-cols-1 gap-1 mt-2">
                                <div>
                                    <label for="campaing_startdate" class=" label_input">
                                        {{ __('vendor_product.product_campaing_startdate') }}
                                    </label>
                                    <input type="date" id="campaing_startdate" name="campaing_startdate"
                                        class="input_text"
                                        value="{{ date('Y-m-d', strtotime($vendor_p->campaign_startdate)) }}" />
                                </div>
                                <div>
                                    <label for="campaing_starttime"
                                        class=" label_input">{{ __('vendor_product.product_campaing_starttime') }}</label>
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
                                        <input type="time" id="campaing_starttime" name="campaing_starttime"
                                            class="input_text"
                                            value="{{ date('H:i', strtotime($vendor_p->campaign_startdate)) }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="grid lg:grid-cols-2 grid-cols-1 gap-1 mt-2">
                                <div>
                                    <label for="campaing_enddate" class=" label_input">
                                        {{ __('vendor_product.product_campaing_enddate') }}
                                    </label>
                                    <input type="date" id="campaing_enddate" name="campaing_enddate"
                                        class="input_text"
                                        value="{{ date('Y-m-d', strtotime($vendor_p->campaign_enddate)) }}" />
                                </div>
                                <div>
                                    <label for="campaing_endtime"
                                        class=" label_input">{{ __('vendor_product.product_campaing_endtime') }}</label>
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
                                        <input type="time" id="campaing_endtime" name="campaing_endtime"
                                            class="input_text"
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
