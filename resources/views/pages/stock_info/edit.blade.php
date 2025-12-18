@extends('layouts.createpage')
@section('title_page')
    {{ __('menu.stock_title') }}
@endsection
@section('breadcrumb-index')
    <a href="{{ route('stock-info.index') }}" class="first_bc_a" id="cancel_button">
        {{ __('menu.staff') }}
    </a>
@endsection
@section('breadcrumb-create-page')
    <a href="#" class="second_bc_a">
        {{ __('menu.stock_title') }}
    </a>
@endsection
@section('page_title')
    {{ __('menu.stock_title') }}
@endsection
@section('form-section')
    <form id="stock_info" action="{{ route('stock-info.store') }}" method="post">
        @csrf
        <div class="grid_page">
            <div>
                <label for="text" class="label_input"> {{ __('stock.txnno') }} </label>
                <input type="text" id="txnno" maxlength="2" name="txnno" class="input_text"
                    value="{{ $stock_info->txnno }}" disabled required />
                @error('txnno')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="txndate" class=" label_input">{{ __('stock.txndate') }}</label>
                <input type="date" id="txndate" name="txndate" class="input_text"
                    value="{{ date('Y-m-d', strtotime($stock_info->txndate)) }}" required />
                @error('txndate')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="remark" class=" label_input">{{ __('stock.remark') }}</label>
                <input type="text" id="remark" name="remark" class="input_text" value="{{ $stock_info->remark }}"
                    required />
                @error('remark')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="refdate" class="label_input">{{ __('stock.refdate') }}</label>
                <input type="date" class="input_text" id="refdate" name="refdate"
                    value="{{ date('Y-m-d', strtotime($stock_info->refdate)) }}" required>
                @error('refdate')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="vendor_id" class="label_input">{{ __(key: 'stock.vendor_id') }}</label>
                <select class="input_text" name="vendor_id" id="vendor_id" autocomplete="off">
                    <option value=" " selected disabled>{{ __('stock.select_vendor') }}</option>
                    @foreach ($vendor_name as $item)
                        <option value="{{ $item->vendor_id }}" @if ($stock_info->vendor_id == $item->vendor_id) selected @endif>
                            {{ $item->vendor_name }}</option>
                    @endforeach

                </select>
                @error('vendor_id')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="txn_type" class="label_input">{{ __('stock.txn_type') }}</label>
                <select name="txn_type" id="txn_type" class="input_text" required>
                    <option value="00" @if ($stock_info->txntype == '00') selected @endif>{{ __('stock.txn_type_00') }}
                    </option>
                    <option value="01" @if ($stock_info->txntype == '01') selected @endif>{{ __('stock.txn_type_01') }}
                    </option>
                </select>
                @error('txn_type')
                    <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                        </span>{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="submit_btn">{{ __('menu.button.save') }}</button>
        <a href="{{ route('stock-info.index') }}">
            <button type="button" class="cancel_btn">
                {{ __('menu.button.cancel') }}
            </button>
        </a>
        {{-- @if ($errors->any())
            <div class="error_alert" role="alert">
                <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
            </div>
        @endif --}}
    </form>

    <section class="border-gray-400 border-t py-3">
        <div class="tab_div">
            <ul class="tab_ul-2" id="default-tab" data-tabs-toggle="#stock_product_tab" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-base" id="product_stock_tabs"
                        data-tabs-target="#product" type="button" role="tab" aria-controls="product"
                        aria-selected="false">{{ __('stock.stock_tab1') }}</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-base hover:text-fg-brand hover:border-brand"
                        id="stock_in_tabs" data-tabs-target="#stock_in" type="button" role="tab"
                        aria-controls="stock_in" aria-selected="false">{{ __('stock.stock_tab2') }}</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-base hover:text-fg-brand hover:border-brand"
                        id="history_stock_tabs" data-tabs-target="#history_stock" type="button" role="tab"
                        aria-controls="history_stock" aria-selected="false">{{ __('stock.stock_tab3') }}</button>
                </li>
            </ul>
        </div>
        <div id="stock_product_tab">
            <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="product" role="tabpanel"
                aria-labelledby="product_stock_tabs">
                @include('pages.stock_info.tab.product', [
                    'txnno' => $stock_info->txnno,
                    'vendor_id' => $stock_info->vendor_id,
                ])
            </div>
            <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="stock_in" role="tabpanel"
                aria-labelledby="stock_in_tabs">

            </div>
            <div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="history_stock" role="tabpanel"
                aria-labelledby="history_stock_tabs">

            </div>
        </div>
    </section>
@endsection
@section('js-scripts')
    <script type="module">
        $('#stock_info').validate({
            rules: {
                txnno: {
                    required: true,
                },
                txndate: {
                    required: true,
                },
                vendor_id: {
                    required: true,
                },
                remark: {
                    required: true,
                },
                refdate: {
                    required: true,
                },
            },
            messages: {
                txnno: {
                    required: "{{ __('stock.txnno_required') }}",
                },
                txndate: {
                    required: "{{ __('stock.txndate_required') }}",
                },
                vendor_id: {
                    required: "{{ __('stock.vendor_id_required') }}",
                },
                remark: {
                    required: "{{ __('stock.remark_required') }}",
                },
                refdate: {
                    required: "{{ __('stock.refdate_required') }}",
                },
            },

        });
    </script>
@endsection
