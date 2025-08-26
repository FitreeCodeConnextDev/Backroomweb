@extends('layouts.master')
@section('title')
    Terminal
@endsection

@section('content')

    @if (isset($error))
        <div class="text-center px-4 py-80 rounded relative" role="alert">
            <h1
                class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-red-700 md:text-5xl lg:text-6xl dark:text-white">
                <strong class="font-bold items-center">Error </strong>
            </h1>
            <span class="block text-4xl text-red-700">{{ $error }}</span>
        </div>
    @else
        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <h1
                    class="mb-4 text-4xl font-extrabold text-center leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white mt-6">
                    {{ $errors->first() }}
                </h1>
            </div>
        @endif
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">Success alert!</span> {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
            <div class="w-full md:w-1/2">
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                            viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Search" required="">
                </div>
            </div>
            <div class="w-full md:w-auto flex flex-row">
                <a href="{{ route('terminal.create') }}">
                    <button type="button"
                        class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                        </svg>
                        Add Terminal
                    </button>
                </a>
                {{-- <a href="{{ route('export.csv') }}" type="button"
                    class="flex items-center justify-center text-white bg-mints-900 hover:bg-mints-400 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">Export
                    CSV</a> --}}
                    
            </div>
        </div>
        <div class="relative  sm:rounded-lg">
            {{-- Paginate --}}
            <div class="flex flex-row justify-between items-center p-4">
                <div id="showingEntries" class="text-sm text-gray-600"></div>
                <span id="table-info" class="text-sm text-gray-700 dark:text-gray-400"></span>
                <div class="flex items-center space-x-2">
                    <button id="prevPage"
                        class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Previous</button>
                    <span id="pageInfo" class="text-sm text-gray-600"></span>
                    <button id="nextPage"
                        class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Next</button>
                </div>
            </div>
            {{-- Paginate --}}
            <table id="table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            #
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Terminal ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Terminal Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Branch ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                @php
                    $i = 1;
                @endphp
                <tbody id="tableBody">
                    @foreach ($terminal_info as $item)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $i++ }}
                            </td>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item['term_id'] }}
                            </td>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item['term_name'] }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $item['branch_id'] }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="">
                                    <button type="button" data-popover-target="popover-description"
                                        data-popover-placement="bottom-end" type="button"
                                        class="mt-1 px-2 py-2 text-xs font-medium text-center text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300  rounded-lg me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">

                                        <svg class="w-[16px] h-[16px] " aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                            viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="1.6"
                                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                        </svg>

                                    </button>
                                </a>
                                <button type="button" data-modal-target="popup-modal" data-id="{{ $item['term_id'] }}"
                                    data-modal-toggle="popup-modal"
                                    class="mt-1 px-2 py-2 text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg class="w-[16px] h-[16px]" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.6"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Delete Modal --}}
            <div id="popup-modal" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                คุณแน่ใจหรือไม่ว่าต้องการลบ Terminal ID <span id="modal-term-id"></span> นี้</h3>
                            <form id="delete-form" method="POST">
                                @csrf
                                @method('DELETE')
                                <button data-modal-hide="popup-modal" type="submit"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    ใช่ ฉันแน่ใจ
                                </button>
                                <button data-modal-hide="popup-modal" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    ไม่, ยกเลิก</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            {{-- Delete Modal --}}
        </div>
    @endif
@endsection
@section('scripts')
    <script>
        // เมื่อเอกสารโหลดเสร็จแล้ว
        document.addEventListener('DOMContentLoaded', function() {
            // เลือกปุ่มที่มี attribute data-modal-target="popup-modal"
            const modalButtons = document.querySelectorAll('button[data-modal-target="popup-modal"]');

            // วนลูปเพื่อให้ทุกปุ่มสามารถทำงานได้
            modalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // ดึงค่า data-id จากปุ่มที่ถูกคลิก
                    const termId = this.dataset.id;

                    // อ้างอิงไปยัง element ที่จะแสดงค่า termId
                    const modalTermId = document.getElementById('modal-term-id');

                    // แสดงค่า termId ในโมดัล
                    modalTermId.textContent = termId;

                    // อัปเดต action attribute ของ form ด้วย route ที่มีค่า term_id เป็น parameter
                    const deleteForm = document.getElementById('delete-form');
                    deleteForm.action =
                        `{{ route('terminal.destroy', ['terminal' => ':term_id']) }}`.replace(
                            ':term_id', termId);

                    // เปิดโมดัล
                    const modalElement = document.getElementById('popup-modal');
                    modalElement.classList.remove('hidden');
                });
            });

            // ปิดโมดัลเมื่อคลิกปุ่มปิด
            const closeModalButtons = document.querySelectorAll('[data-modal-hide="popup-modal"]');
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const modalElement = document.getElementById('popup-modal');
                    modalElement.classList.add('hidden');
                });
            });
        });
    </script>
@endsection
