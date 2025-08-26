@extends('layouts.master')
@php
    include '../resources/config/menu.php';
@endphp

@section('title')
    
@endsection

@section('content')
    <div class="pb-4 mb-4 rounded-t">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('vendor-type.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 ">
                        {{ $con_menu['vendor_type'] }}
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 ">
                            
                        </a>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 ">
        <h3 class="text-lg font-semibold text-gray-900 ">
            
        </h3>
    </div>
    <form action="#" method="POST">
        @csrf
        <div class="grid gap-6 mb-4 md:grid-cols-2">
            <div>
                <label for="text" class="mb-2 text-sm font-medium text-gray-900 ">รหัสประเภทร้าน</label>
                <input type="text" id="text" name="unitid" placeholder="0001, 0002 ..."
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full"
                    value="" required />
            </div>
            <div>
                <label for="text" class=" mb-2 text-sm font-medium text-gray-900 ">รายละเอียด</label>
                <input type="text" id="text" name="unitname" placeholder="อาหารตามสั่ง, เครื่องดื่ม"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full "
                    value="" required />
            </div>
            <div>
                <label for="text" class=" mb-2 text-sm font-medium text-gray-900 ">รหัส SAP</label>
                <input type="text" id="text" name="unitname" placeholder=" 1111111"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full "
                    value="" required />
            </div>
        </div>
        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            {{ $con_menu['menu.save'] }}
        </button>
        <a href="{{ route('vendor-type.index') }}">
            <button type="button"
                class="text-white focus:outline-non bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center mt-2 ">
                {{ $con_menu['menu.cancel'] }}
            </button>
        </a>
    </form>
@endsection
@section('scripts')
@endsection
