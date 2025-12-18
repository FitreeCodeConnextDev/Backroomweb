@vite(['resources/css/app.css', 'resources/js/app.js'])

@php
    $expensevendor_other = DB::table('sum_expense_rpt')
        ->select(
            'txnyear',
            'txnmonth',
            'vendor_id',
            'vendor_name',
            'exp_code',
            'start_no',
            'end_no',
            'price_rate',
            'total',
            'txndate',
            'duedate',
            'invoiceno',
        )
        ->orderBy('invoiceno', 'asc')
        ->get();

    $expensevendor_info_map = DB::table('expensevendor_info')
        ->select('exp_code', 'description')
        ->get()
        ->keyBy('exp_code');
@endphp
<div class="mt-3 border border-gray-200 rounded-lg p-5 relative overflow-x-auto">
    <table class="table-data" id="expensevendor_other_data_list">
        <thead>
            <tr>
                <th scope="col">{{ __('expense_vendor.vendor_id_desc') }}</th>
                <th scope="col">{{ __('expense_vendor.vendor_name_desc') }}</th>
                <th scope="col">{{ __('expense_vendor.exp_code_desc') }}</th>
                <th scope="col">{{ __('expense_vendor.start_no_desc') }}</th>
                <th scope="col">{{ __('expense_vendor.end_no_desc') }}</th>
                <th scope="col">{{ __('expense_vendor.price_rate_desc') }}</th>
                <th scope="col">{{ __('expense_vendor.total') }}</th>
                <th scope="col">{{ __('expense_vendor.txndate_desc') }}</th>
                <th scope="col">{{ __('expense_vendor.duedate_desc') }}</th>
                <th scope="col">{{ __('expense_vendor.invoice_no_desc') }}</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expensevendor_other as $item)
                <tr>
                    <td>{{ $item->vendor_id }}</td>
                    <td>{{ $item->vendor_name }}</td>
                    <td>{{ $expensevendor_info_map[$item->exp_code]->description ?? 'N/A' }}</td>
                    <td>{{ $item->start_no }}</td>
                    <td>{{ $item->end_no }}</td>
                    <td>{{ $item->price_rate }}</td>
                    <td>{{ $item->total }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->txndate)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->duedate)) }}</td>
                    <td>{{ $item->invoiceno }}</td>
                    <td>
                        <div>
                            <form
                                action="{{ route('expensevendor_other_destroy', ['txnyear' => $item->txnyear, 'txnmonth' => $item->txnmonth, 'vendor_id' => $item->vendor_id, 'exp_code' => $item->exp_code]) }}"
                                method="post" id="delete-form-{{ $item->invoiceno }}">
                                @csrf
                                @method('DELETE')
                                <button id="del-button" class="del-button" data-item-id="{{ $item->invoiceno }}"
                                    data-name="{{ $expensevendor_info_map[$item->exp_code]->description ?? 'N/A' }}">
                                    <svg class="w-[16px] h-[16px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.6"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.querySelector("#expensevendor_other_data_list");
        if (table) {
            new DataTable(table, {
                searchable: true,
                sortable: true,
                perPage: 5,
                perPageSelect: [5, 10, 20]
            });
        }

        // ✅ ใช้ event delegation แทน
        document.addEventListener('click', function(e) {
            const button = e.target.closest('.del-button');
            if (button) {
                e.preventDefault();
                const itemId = button.getAttribute('data-item-id');
                const itemName = button.getAttribute('data-name');
                const form = document.getElementById(`delete-form-${itemId}`);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "alert_confirm_btn",
                        cancelButton: "alert_cancel_btn"
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: `{{ __('menu.deleted_title') }}`,
                    html: `{{ __('menu.deleted_text') }} <b>${itemName}</b> <br> ${itemId} `,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: `{{ __('menu.deleted_yes') }}`,
                    cancelButtonText: `{{ __('menu.deleted_no') }}`,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>
