@vite(['resources/css/app.css', 'resources/js/app.js'])

@php
    $vendor_invoice = DB::table('vendor_info')
        ->select(
            'invoicename',
            'invoiceaddr1',
            'invoiceaddr2',
            'invoiceduedate',
            'invoicepaydate',
            'invoiceprint',
            'vendor_paymenttype',
        )
        ->where('vendor_id', $vendor_id)
        ->first();
    // $daysInMonth = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
    $daysInMonth = 31;
@endphp
{{-- @dd($vendor_invoice) --}}
<div class="grid grid-cols-1 lg:grid-cols-4 gap-3">
    <section>
        <form action="" method="post">
            <div class=" flex justify-between items-center border border-gray-200 rounded-lg p-3 ">
                <div class="w-full h-auto">
                    <section class="mt-2">
                        <label for="invoicename" class="label_input"> {{ __('vendor.invoicename') }} </label>
                        <input type="text" id="invoicename" class="input_text" name="invoicename" disabled
                            value="{{ $vendor_invoice->invoicename }}">
                    </section>
                    <section class="mt-2">
                        <label for="invoice_addr" class="label_input"> {{ __('vendor.invoice_addr') }} </label>
                        <textarea name="invoiceaddr2" class="input_text" disabled>{{ $vendor_invoice->invoiceaddr1 }} {{ $vendor_invoice->invoiceaddr2 }}</textarea>
                    </section>
                    <section class="mt-2">
                        <label for="invoiceaddr2" class="label_input"> {{ __('vendor.invoice_addr') }} </label>
                        <textarea name="invoiceaddr2" class="input_text" disabled>{{ $vendor_invoice->invoiceaddr2 }}</textarea>
                    </section>
                    <section class=" mt-2">
                        <label for="invoiceduedate" class="label_input"> {{ __('vendor.invoice_duedate') }} /
                            {{ __('vendor.per_month') }}</label>
                        <select name="invoiceduedate" id="invoiceduedate" class="input_text" disabled>
                            <option value="0"@if ($vendor_invoice->invoiceduedate == 0) selected @endif>0</option>
                            @for ($i = 1; $i <= $daysInMonth; $i++)
                                <option value="{{ $i }}" @if ($vendor_invoice->invoiceduedate == $i) selected @endif>
                                    {{ $i }}
                                </option>
                            @endfor

                        </select>
                    </section>
                    <section class=" mt-2">
                        <label for="invoicepaydate" class="label_input"> {{ __('vendor.invoice_paydate') }} /
                            {{ __('vendor.per_month') }}</label>
                        <select name="invoicepaydate" id="invoicepaydate" class="input_text" disabled>
                            <option value="0"@if ($vendor_invoice->invoicepaydate == 0) selected @endif>0</option>
                            @for ($i = 1; $i <= $daysInMonth; $i++)
                                <option value="{{ $i }}" @if ($vendor_invoice->invoicepaydate == $i) selected @endif>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </section>
                    <section class="mt-2">
                        <label for="invoiceprint" class="label_input"> {{ __('vendor.invoice_print') }} </label>
                        <select name="invoiceprint" id="invoiceprint" class="input_text" disabled>
                            <option value="" @if ($vendor_invoice->invoiceprint == null) selected @endif> </option>
                            <option value="1" @if ($vendor_invoice->invoiceprint == 1) selected @endif>
                                {{ __('vendor.print_y') }} </option>
                            <option value="2" @if ($vendor_invoice->invoiceprint == 2) selected @endif>
                                {{ __('vendor.print_n') }} </option>
                        </select>
                    </section>
                    <section class="mt-2">
                        <label for="vendor_paymenttype" class="label_input"> {{ __('vendor.vendor_paymenttype') }}
                        </label>
                        <select name="vendor_paymenttype" id="vendor_paymenttype" class="input_text" disabled>
                            <option value="" @if ($vendor_invoice->vendor_paymenttype == null) selected @endif> </option>
                            <option value="1" @if ($vendor_invoice->vendor_paymenttype == 1) selected @endif>
                                {{ __('vendor.tranfer_cash') }} </option>
                            <option value="2" @if ($vendor_invoice->vendor_paymenttype == 2) selected @endif>
                                {{ __('vendor.cheque') }} </option>
                        </select>
                    </section>
                </div>
            </div>
        </form>
    </section>
</div>
