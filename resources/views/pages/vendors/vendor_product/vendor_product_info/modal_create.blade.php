<section>
    <div id="vedor_product_info" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-5xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 ">
                        {{ __('vendor_product.vendor_product_data_add') }}
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
                            <input type="text" id="product_barcode" name="product_barcode" class="input_text"
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
                            <input type="text" id="product_sdesc" name="product_sdesc" class="input_text" disabled>
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
                            <input type="number" id="product_seq" name="product_seq" class="input_text" required>
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
                                    <input type="number" id="priceunit" name="priceunit" class="input_text"
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
                                <input type="number" id="pricediscount" name="pricediscount" class="input_text"
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
                                <input type="number" id="pricemember" name="pricemember" class="input_text"
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
                                <input type="number" id="pricestaff" name="pricestaff" class="input_text" required>
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
                                <input type="number" id="pricerabbit" name="pricerabbit" class="input_text"
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
                                <input type="number" id="priceqr" name="priceqr" class="input_text" required>
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
                                <input type="number" id="pirce_perunit" name="product_perunit" class="input_text"
                                    value="1.00">
                            </div>
                            <div>
                                <label for="vatrate" class="label_input">
                                    {{ __('vendor_product.product_vatrate') }}
                                </label>
                                <input type="number" id="vatrate" name="vatrate" class="input_text"
                                    value="7.00">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-2 mt-2 border border-gray-200 rounded-md p-2">
                            <div>
                                <label for="pricesp1" class="label_input">
                                    {{ __('vendor_product.product_sp1') }}
                                </label>
                                <input type="number" id="pricesp1" name="pricesp1" class="input_text" required>
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
                                <input type="number" id="pricesp2" name="pricesp2" class="input_text" required>
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
                                <input type="number" id="pricesp3" name="pricesp3" class="input_text" required>
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
                                <input type="number" id="pricesp4" name="pricesp4" class="input_text" required>
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
                                <input type="number" id="pricesp5" name="pricesp5" class="input_text" required>
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
                                <input type="number" id="priceedc" name="priceedc" class="input_text" required>
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
                                    <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="campaign_startdate"
                                        name="campaing_startdate" class="input_text">
                                </div>
                                <div>
                                    <label for="campaign_enddate" class="label_input">
                                        {{ __('vendor_product.product_campaing_enddate') }}
                                    </label>
                                    <input type="date" pattern="\d{2}/\d{2}/\d{4}" id="campaign_enddate"
                                        name="campaing_enddate" class="input_text">
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
