@php
    $promo_dis = DB::table('vendor_info')
        ->select(
            'vendor_id',
            'typediscount',
            'discountamt',
            'cur_discount',
            'def_discount',
            'use_discount',
            'discount_bdate',
            'discount_btime',
            'discount_edate',
            'discount_etime',
        )
        ->where('vendor_id', $vendor_id)
        ->first();
@endphp
<section>
    <div class="grid grid-cols-1 xl:grid-cols-3 lg:grid-cols-2 gap-3">
        <section>
            <form action="{{ route('vendor_promo_dis', ['id' => $vendor_id]) }}" class="tabs_form" method="post">
                @csrf
                @method('PUT')
                <div class="mt-3 border border-gray-200 rounded-lg p-5">
                    <div class="w-full h-auto">
                        <section class="mt-4">
                            <label for="typediscount" class="label_input"> {{ __('vendor.typediscount') }} </label>
                            {{-- <input type="text" id="typediscount" name="typediscount" class="input_text" value="{{ $promo_dis->typediscount }}"> --}}
                            <select name="typediscount" id="typediscount" class="input_text"
                                @if (Route::is('vendor-page.show')) disabled @endif>
                                <option value="0" @if ($promo_dis->typediscount == 0) selected @endif>
                                    {{ __('vendor.typediscount_0') }} </option>
                                <option value="1" @if ($promo_dis->typediscount == 1) selected @endif>
                                    {{ __('vendor.typediscount_1') }} </option>
                                <option value="2" @if ($promo_dis->typediscount == 2) selected @endif>
                                    {{ __('vendor.typediscount_2') }} </option>
                            </select>
                        </section>
                        <section class="mt-4">
                            <label for="discountamt" class="label_input"> {{ __('vendor.discountamt') }} </label>
                            <input type="number" id="discountamt" name="discountamt" class="input_text"
                                value="{{ $promo_dis->discountamt }}" @if (Route::is('vendor-page.show')) disabled @endif>
                        </section>
                        <section class="mt-4">
                            <label for="cur_discount" class="label_input"> {{ __('vendor.cur_discount') }} </label>
                            <input type="number" id="cur_discount" name="cur_discount" class="input_text"
                                value="{{ $promo_dis->cur_discount }}"
                                @if (Route::is('vendor-page.show')) disabled @endif>
                        </section>
                        <section class="mt-4">
                            <label for="def_discount" class="label_input"> {{ __('vendor.def_discount') }} </label>
                            <input type="number" id="def_discount" name="def_discount" class="input_text"
                                value="{{ $promo_dis->def_discount }}"
                                @if (Route::is('vendor-page.show')) disabled @endif>
                        </section>
                        <section class="mt-4">
                            <label for="use_discount" class="label_input"> {{ __('vendor.use_discount') }} </label>
                            <input type="number" id="use_discount" name="use_discount" class="input_text"
                                value="{{ $promo_dis->use_discount }}"
                                @if (Route::is('vendor-page.show')) disabled @endif>
                        </section>
                        <section class="mt-4 grid grid-col grid-cols-2 gap-10">
                            <section>
                                <label for="discount_bdate" class="label_input"> {{ __('vendor.discount_bdate') }}
                                </label>
                                <input type="date" id="discount_bdate" name="discount_bdate" class="input_text"
                                    value="{{ !empty($promo_dis->discount_bdate) ? date('Y-m-d', strtotime($promo_dis->discount_bdate)) : '-' }}"
                                    @if (Route::is('vendor-page.show')) disabled @endif>
                            </section>
                            <section>
                                <label for="discount_btime" class="label_input"> {{ __('vendor.discount_btime') }}
                                </label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="time" id="discount_btime" name="discount_btime" class="input_text"
                                        value="{{ !empty($promo_dis->discount_btime) ? date('H:i', strtotime($promo_dis->discount_btime)) : '' }}"
                                        @if (Route::is('vendor-page.show')) disabled @endif>
                                </div>
                            </section>
                            <section>
                                <label for="discount_edate" class="label_input"> {{ __('vendor.discount_edate') }}
                                </label>
                                <input type="date" id="discount_edate" name="discount_edate" class="input_text"
                                    value="{{ !empty($promo_dis->discount_edate) ? date('Y-m-d', strtotime($promo_dis->discount_edate)) : '' }}"
                                    @if (Route::is('vendor-page.show')) disabled @endif>
                            </section>
                            <section>
                                <label for="discount_etime" class="label_input"> {{ __('vendor.discount_etime') }}
                                </label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="time" id="discount_etime" name="discount_etime" class="input_text"
                                        value="{{ !empty($promo_dis->discount_etime) ? date('H:i', strtotime($promo_dis->discount_etime)) : '' }}"
                                        @if (Route::is('vendor-page.show')) disabled @endif>
                                </div>
                            </section>
                        </section>
                    </div>
                    @if (Route::is('vendor-page.edit'))
                        <div class="mt-3">
                            <button class="submit_btn saveButton">{{ __('menu.button.save') }}</button>
                        </div>
                    @endif
                </div>
            </form>
        </section>
    </div>

</section>
