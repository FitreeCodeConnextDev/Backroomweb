@extends('layouts.indexpage')

@section('title_page')
    {{ __('menu.product_unit') }}
@endsection
@section('index-title')
    {{ __('menu.product_unit') }}
@endsection
@section('add-button')
    <div>
        <a href="{{ route('product-units.create') }}" class="add-button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </a>
    </div>
@endsection
@section('table-section')
    <table id="product_unit_table" class="table-data">
        <thead>
            <tr>
                <th scope="col">
                    {{ __('menu.product_unit_unit_id') }}
                </th>
                <th scope="col">
                    {{ __('menu.product_unit_unit_name') }}
                </th>
                <th scope="col">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($unit_info as $units)
                <tr>
                    <td>
                        {{ $units->unit_id }}
                    </td>
                    <td>
                        {{ $units->unit_name }}
                    </td>
                    <td>
                        <div class="flex space-x-3">
                            <div>
                                <a href="{{ route('product-units.edit', $units->unit_id) }}">
                                    <button type="button" data-popover-target="popover-description"
                                        data-popover-placement="bottom-end" type="button" class="edit-button">
                                        <svg class="w-[16px] h-[16px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.6"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>
                                    </button>
                                </a>
                            </div>
                            <div>
                                <form action="{{ route('product-units.destroy', $units->unit_id) }}" method="post"
                                    id="delete-form-{{ $units->unit_id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button id="del-button" class="del-button" data-item-id="{{ $units->unit_id }}"
                                        data-name="{{ $units->unit_name }}">
                                        <svg class="w-[16px] h-[16px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.6"
                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
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
            const table = document.querySelector("#product_unit_table");
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
                        title: "คุณแน่ใจเหรอ?",
                        html: `ว่าจะลบ <b>${itemName}</b>`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "ใช่ ลบเลย",
                        cancelButtonText: "ไม่ ยกเลิก!",
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
@endsection
