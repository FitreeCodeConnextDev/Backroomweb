@vite(['resources/css/app.css', 'resources/js/app.js'])
@php
    $garantee = DB::table('vendor_info')
        ->select('min_garantee1', 'min_garantee2', 'min_garantee3', 'dis_garantee')
        ->where('vendor_id', $vendor_id)
        ->first();
        // dd($garantee);
@endphp
<div class="grid grid-cols-1 lg:grid-cols-4 gap-3">
    <section class="mt-3 border border-gray-200 rounded-lg p-5">
        <h1 class=" text-xl font-semibold"> {{ __('vendor.vendor_garantee') }} </h1>
        <form action="">
            <div class="mt-3">
                <div class="w-full h-auto">
                    <section class="mt-2">
                        <label for="min_grantee1" class="label_input"> {{ __('vendor.min_garantee1') }} </label>
                        <input type="text" name="min_grantee1" value="{{ $garantee->min_garantee1 }}" id="min_grantee1" class="input_text" disabled>
                    </section>
                    <section class="mt-2">
                        <label for="min_grantee2" class="label_input"> {{ __('vendor.min_garantee2') }} </label>
                        <input type="text" name="min_grantee2" value="{{ $garantee->min_garantee2}}"  id="min_grantee2" class="input_text" disabled>
                    </section>
                    <section class="mt-2">
                        <label for="min_grantee3" class="label_input"> {{ __('vendor.min_garantee3') }} </label>
                        <input type="text" name="min_grantee3" value="{{ $garantee->min_garantee3 }}" id="min_grantee3" class="input_text" disabled>
                    </section>
                    <section class="mt-2">
                        <label for="diss_garantee" class="label_input"> {{ __('vendor.dis_garantee') }} </label>
                        <input type="text" name="dis_garantee" value="{{ $garantee->dis_garantee }}" id="diss_garantee" class="input_text" disabled>
                    </section>
                </div>
            </div>
        </form>
    </section>
</div>
