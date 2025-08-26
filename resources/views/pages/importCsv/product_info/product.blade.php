@extends('layouts.indexpage')
@section('title_page')
    {{ __('import.import_product_desc') }}
@endsection
@section('index-title')
    {{ __('import.import_product_desc') }}
@endsection
@section('table-section')
    <form action="{{ route('import.preview') }}" enctype="multipart/form-data" method="post">
        @csrf
        {{-- <input type="file" name="csv_file" required> --}}

        {{-- <section class="px-52">
            <div class="flex justify-center mt-4 mb-5">
                <div class="flex space-x-">
                    <input name="select-all" id="select-all" type="checkbox" class="checkbox_input">
                    <label for="" class="label_checkbox">
                        เลือกทั้งหมด
                    </label>
                </div>
            </div>
            <div class="grid lg:grid-flow-col lg:grid-rows-5
                    grid-col-1 gap-4">
                @foreach ($product_col as $column_name)
                    <div class="flex items-center mb-4">

                        <input id="{{ $column_name }}" name="{{ $column_name }}" type="checkbox"
                            value="{{ $column_name }}" class="checkbox_input">
                        <label for="{{ $column_name }}" class="label_checkbox">
                            {{ ucfirst(str_replace('_', ' ', $column_name)) }}
                        </label>
                    </div>
                @endforeach
            </div>

        </section> --}}

        <div class="flex gap-4 p-4">
            <!-- Left side select -->
            <div class="w-1/2">
                <select name="from[]" size="8" id="mySideToSideSelect" class="w-full p-2 border rounded" multiple>
                    @foreach ($product_col as $column_name)
                        <option value="{{ $column_name }}"> {{ $column_name }} </option>
                    @endforeach
                </select>
            </div>

            <!-- Action buttons -->
            <div class="flex flex-col justify-center gap-2">
                <button type="button" id="mySideToSideSelect_rightAll"
                    class="px-2 py-1 bg-gray-300 rounded hover:bg-gray-400">
                    &raquo;
                </button>
                <button type="button" id="mySideToSideSelect_rightSelected"
                    class="px-2 py-1 bg-gray-300 rounded hover:bg-gray-400">
                    &rsaquo;
                </button>
                <button type="button" id="mySideToSideSelect_leftSelected"
                    class="px-2 py-1 bg-gray-300 rounded hover:bg-gray-400">
                    &lsaquo;
                </button>
                <button type="button" id="mySideToSideSelect_leftAll"
                    class="px-2 py-1 bg-gray-300 rounded hover:bg-gray-400">
                    &laquo;
                </button>
            </div>

            <!-- Right side select -->
            <div class="w-1/2">
                <select name="selected[]" size="8" id="mySideToSideSelect_to" class="w-full p-2 border rounded"
                    multiple>
                    <!-- Moved items will show up here -->
                </select>
            </div>
        </div>

        <div class="flex items-center justify-center w-full">
            <label for="dropzone-file"
                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                            class="font-semibold">กดคลิกเพื่อเลือกไฟล์</span></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">CSV,TXT,XLS,XLSX,ODS,TSV</p>
                </div>
                <input id="dropzone-file" type="file" name="csv_file" class="hidden" />
            </label>
        </div>
        @if ($errors->any())
            <div class="error_alert mt-5" role="alert">
                <span class="font-medium text-xl">!คำเตือน</span> {{ $errors->first() }}
            </div>
        @endif
        <div class="flex justify-center mt-4 mb-5">
            <button class="submit_btn" type="submit">Preview</button>
        </div>
    </form>
@endsection
@section('js-scripts')
    <script src="https://cdn.rawgit.com/crlcu/multiselect/master/dist/js/multiselect.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mySideToSideSelect').multiselect({
                keepRenderingSort: true
            });
        });
    </script>
    <script>
        function saveSelectedToLocalStorage() {
            const select = document.getElementById('mySideToSideSelect_to');
            const selectedValues = Array.from(select.options).map(option => option.value);
            localStorage.setItem('selectedProductColumns', JSON.stringify(selectedValues));
        }

        // Save on change
        document.getElementById('mySideToSideSelect_to').addEventListener('change', saveSelectedToLocalStorage);

        // Also save after moving options between selects
        ['mySideToSideSelect_rightAll', 'mySideToSideSelect_rightSelected', 'mySideToSideSelect_leftSelected', 'mySideToSideSelect_leftAll'].forEach(function(btnId) {
            const btn = document.getElementById(btnId);
            if (btn) {
                btn.addEventListener('click', function() {
                    // Delay to ensure options are moved before saving
                    setTimeout(saveSelectedToLocalStorage, 100);
                });
            }
        });

        // Restore on page load
        document.addEventListener('DOMContentLoaded', function() {
            const saved = localStorage.getItem('selectedProductColumns');
            if (saved) {
                const values = JSON.parse(saved);
                const select = document.getElementById('mySideToSideSelect_to');
                // Remove all current options
                while (select.options.length > 0) {
                    select.remove(0);
                }
                // Add saved options back
                values.forEach(function(val) {
                    const option = document.createElement('option');
                    option.value = val;
                    option.text = val;
                    select.add(option);
                });
            }
        });
    </script>
@endsection
