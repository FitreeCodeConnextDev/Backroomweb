@extends('layouts.indexpage')

@section('title_page')
    {{ __('menu.stock_title') }}
@endsection
@section('index-title')
    {{ __('menu.stock_title') }}
@endsection
@section('add-button')
    <div>
        <a href="{{ route('stock-info.create') }}" class="add-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>
    </div>
@endsection
@section('table-section')
    <table class="table-data" id="stock_table">
        <thead>
            <tr>
                <th scope="col"> {{ __('stock.txnno') }} </th>
                <th scope="col"> {{ __('stock.txndate') }} </th>
                <th scope="col"> {{ __('stock.vendor_id') }} </th>
                <th scope="col"> Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stock_info as $stock)
                <tr>
                    <td>{{ $stock->txnno }}</td>
                    <td>{{ date('d-m-Y', strtotime($stock->txndate)) }}</td>
                    <td>{{ $stock->vendor_name }}</td>
                    <td>
                        <div class="flex space-x-3">
                            <div>
                                <form action="{{ route('cancel_adjuststock', $stock->txnno) }}" method="post"
                                    id="delete-form-{{ $stock->txnno }}">
                                    @csrf
                                    @method('PUT')
                                    <button id="del-button" class="del-button" data-item-id="{{ $stock->txnno }}"
                                        data-name="{{ $stock->vendor_name }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-[16px] h-[16px]">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
@section('js-scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = document.querySelector("#stock_table");
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
                        title: `{{ __('stock.cancel_title') }}`,
                        html: `{{ __('stock.cancel_text') }} <b>${itemName}</b>`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: `{{ __('stock.cancel_yes') }}`,
                        cancelButtonText: `{{ __('stock.cancel_no') }}`,
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
        localStorage.removeItem('data_product');
    </script>
@endsection
