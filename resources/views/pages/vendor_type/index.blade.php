@extends('layouts.master')
@php
    include '../resources/config/menu.php';
@endphp
@section('title')
    {{ $con_menu['vendor_type'] }}
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
        <div class="relative overflow-x-auto ">
            <div class="p-5 text-lg mb-4 font-semibold text-left rtl:text-right text-gray-900 bg-white border-b">
                <div class="flex justify-between ">
                    {{-- title --}}
                    <caption class="text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white ">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl ">
                            {{ $con_menu['vendor_type'] }}
                        </h1>
                    </caption>
                    {{-- title --}}
                    {{-- add button --}}
                    <div>
                        <a href="{{ route('vendor-type.create') }}"
                            class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 me-2 mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </a>
                    </div>
                    {{-- add button --}}
                </div>
            </div>
            {{-- Table --}}
            <table id="vendor-type-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            รหัสประเภทร้าน
                        </th>
                        <th scope="col" class="px-6 py-3">
                            รายละเอียด
                        </th>
                        <th scope="col" class="px-6 py-3">
                            รหัส SAP
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-6 py-4 text-gray-900"></td>
                        <td class="px-6 py-4 text-gray-900"></td>
                        <td class="px-6 py-4 text-gray-900"></td>
                        <td class="px-6 py-4 text-gray-900"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
@endsection
@section('scripts')
    <script>
        if (document.getElementById("vendor-type-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#vendor-type-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endsection
