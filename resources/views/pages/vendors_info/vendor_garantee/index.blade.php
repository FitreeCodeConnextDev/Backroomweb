@php
    $garantee = DB::table('vendor_info')
        ->select('min_garantee1', 'min_garantee2', 'min_garantee3', 'dis_garantee')
        ->where('vendor_id', $vendor_id)
        ->first();
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
    <section class="mt-3 border border-gray-200 rounded-lg p-5">
        <h1 class=" text-xl font-semibold"> {{ __('vendor.vendor_garantee') }} </h1>
        <form action="{{ route('vendor_product_update_garantee', ['vendor_id' => $vendor_id]) }}" class="tabs_form"
            method="post">
            @csrf
            @method('PUT')
            <div class="mt-3">
                <div class="w-full h-auto">
                    <section class="mt-2">
                        <label for="min_garantee1" class="label_input"> {{ __('vendor.min_garantee1') }} </label>
                        <input type="number" name="min_garantee1" step="any"
                            @if (Route::is('vendor-page.show')) disabled @endif
                            value="{{ $garantee->min_garantee1 ?? '0.00' }}" id="min_garantee1" class="input_text">
                    </section>
                    <section class="mt-2">
                        <label for="min_garantee2" class="label_input"> {{ __('vendor.min_garantee2') }} </label>
                        <input type="number" name="min_garantee2" step="any"
                            @if (Route::is('vendor-page.show')) disabled @endif
                            value="{{ $garantee->min_garantee2 ?? '0.00' }}" id="min_garantee2" class="input_text">
                    </section>
                    <section class="mt-2">
                        <label for="min_garantee3" class="label_input"> {{ __('vendor.min_garantee3') }} </label>
                        <input type="number" name="min_garantee3" step="any"
                            @if (Route::is('vendor-page.show')) disabled @endif
                            value="{{ $garantee->min_garantee3 ?? '0.00' }}" id="min_garantee3" class="input_text">
                    </section>
                    <section class="mt-2">
                        <label for="diss_garantee" class="label_input"> {{ __('vendor.dis_garantee') }} </label>
                        <input type="number" name="dis_garantee" step="any"
                            @if (Route::is('vendor-page.show')) disabled @endif
                            value="{{ $garantee->dis_garantee ?? '0.00' }}" id="diss_garantee" class="input_text">
                    </section>
                </div>
            </div>
            @if (!Route::is('vendor-page.show'))
                <div class="mt-3">
                    <button type="submit" class="submit_btn saveButton">{{ __('menu.button.save') }}</button>
                </div>
            @endif
        </form>
    </section>
</div>
