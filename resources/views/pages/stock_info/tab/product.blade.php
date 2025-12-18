@vite(['resources/css/app.css', 'resources/js/app.js'])


@php
    $products = DB::table('product_info')
        ->select('product_id', 'product_desc', 'product_group')
        ->orderBy('product_id', 'desc')
        ->get();
@endphp
<div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
    <div class=" mt-3 border border-gray-200 rounded-lg p-5">
        <h1 class=" text-xl font-semibold"> {{ __('stock.product_info') }} </h1>
        <form class="tabs_form" id="adjuststock" action="" method="post">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 m-4">

                <div>
                    <label for="product_id" class="label_input"> {{ __('stock.product_id') }} </label>
                    <select name="product_id" id="product_id" autocomplete="off" required>
                        <option value="" selected disabled>{{ __('stock.select_product') }}</option>
                        @foreach ($products as $item)
                            <option value="{{ $item->product_id }}">
                                {{ $item->product_id }} - {{ $item->product_desc }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                            </span>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="product_desc" class="label_input"> {{ __('stock.product_name') }} </label>
                    <input type="text" name="product_desc" id="product_desc" class="input_text" readonly />
                    @error('product_desc')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                            </span>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="qty" class="label_input"> {{ __('stock.qty') }} </label>
                    <input type="number" name="qty" id="qty" class="input_text" required />
                    @error('qty')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                            </span>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="priceunit" class="label_input"> {{ __('stock.priceunit') }} </label>
                    <input type="number" name="priceunit" id="priceunit" value="0.00" class="input_text" />
                    @error('record')
                        <p class="mt-2 text-sm text-red-600"><span class="font-medium"> {{ __('menu.is_warning') }}
                            </span>{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="unit_name" class="label_input"> {{ __('stock.unit_id') }} </label>
                    <input type="text" name="unit_name" id="unit_name" class="input_text" readonly />
                </div>
            </div>
            <div class="mx-4">
                <button type="button" id="add_product" class="submit_btn">{{ __('menu.button.add') }}</button>
            </div>
        </form>
    </div>

    <div class="mt-3 border border-gray-200 rounded-lg p-5 relative overflow-x-auto">
        <table class="table-data" id="stock_data_list">
            <thead>
                <tr>
                    <th scope="col">{{ __('stock.product_id') }}</th>
                    <th scope="col">{{ __('stock.product_name') }}</th>
                    <th scope="col">{{ __('stock.qty') }}</th>
                    <th scope="col">{{ __('stock.priceunit') }}</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script type="module">
    new TomSelect('#product_id', {
        plugins: ['dropdown_input'],
    });
</script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const productSelect = document.getElementById('product_id');

        productSelect.addEventListener('change', function(event) {
            const productId = event.target.value;

            if (productId) {
                // ส่งคำขอไปยัง Laravel Route
                fetch(`/get-product-details-stock/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            // ถ้าข้อผิดพลาดเกิดขึ้น เช่น Product ไม่เจอ
                            console.error(data.error);
                            return;
                        }

                        // เติมค่าให้กับ input fields ตามที่ได้รับจาก Controller
                        document.getElementById('product_desc').value = data.product_desc;
                        document.getElementById('unit_name').value = data.unit_name;
                    })
                    .catch(error => {
                        console.error('Error fetching product details:', error);
                    });
            }
        });

        const form = document.getElementById('adjuststock');
        const tableBody = document.querySelector('#stock_data_list tbody');
        const txnnoInput = document.getElementById('txnno'); // Assuming the input ID is 'txnno'

        // Make deleteProduct available globally or handle via delegation
        window.deleteProduct = function(index) {
            let dataProduct = JSON.parse(localStorage.getItem('data_product')) || [];
            const currentTxnno = txnnoInput ? txnnoInput.value : '';
            const filteredItems = dataProduct.filter(item => item.txnno === currentTxnno);

            if (filteredItems[index]) {
                const itemToDelete = filteredItems[index];
                dataProduct = dataProduct.filter(item =>
                    !(item.txnno === itemToDelete.txnno && item.product_id === itemToDelete.product_id)
                );
                localStorage.setItem('data_product', JSON.stringify(dataProduct));
                renderTable();
            }
        };


        function renderTable() {
            const dataProduct = JSON.parse(localStorage.getItem('data_product')) || [];
            const currentTxnno = txnnoInput ? txnnoInput.value : '';

            // Filter data by current txnno
            const filteredData = dataProduct.filter(item => item.txnno === currentTxnno);

            tableBody.innerHTML = '';

            if (filteredData.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center p-4">{{ __('stock.no_data_product') }}</td>
                    </tr>
                `;
                return;
            }

            filteredData.forEach((item, index) => {
                const row = `
                    <tr>
                        <td>${item.product_id}</td>
                        <td>${item.product_desc}</td>
                        <td>${item.qty}</td>
                        <td>${item.priceunit}</td>
                        <td class="text-center">
                            <button type="button" class="text-red-600 hover:text-red-800" onclick="deleteProduct(${index})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        // Initial render
        renderTable();

        // Re-render when txnno changes
        if (txnnoInput) {
            txnnoInput.addEventListener('input', renderTable);
        }

        const addProductButton = document.getElementById('add_product');

        addProductButton.addEventListener('click', function(event) {
            event.preventDefault();

            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                if (key !== '_token') {
                    data[key] = value;
                }
            });

            if (txnnoInput) {
                data['txnno'] = txnnoInput.value;
            }

            let dataProduct = JSON.parse(localStorage.getItem('data_product')) || [];

            const isDuplicate = dataProduct.some(item => item.product_id === data.product_id && item
                .txnno === data.txnno);

            if (isDuplicate) {
                Swal.fire({
                    icon: 'warning',
                    title: '{{ __('menu.is_warning') }}',
                    text: '{{ __('stock.duplicate_product') }}',
                    confirmButtonText: '{{ __('menu.button.confirm') }}',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            dataProduct.push(data);

            localStorage.setItem('data_product', JSON.stringify(dataProduct));

            renderTable();

            form.reset();
            if (productSelect.tomselect) {
                productSelect.tomselect.clear();
            }
        });

    });
</script>
