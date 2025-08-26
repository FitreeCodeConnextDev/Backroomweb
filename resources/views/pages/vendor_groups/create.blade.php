@extends('layouts.master')
@section('title')
    Add Group Product
@endsection
@section('content')
    <div class="pb-4 mb-4 rounded-t">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('vendor-group.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Vendor Group 
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="#"
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Add
                            Vendor Group  
                        </a>
                    </div>
                </li>

            </ol>
        </nav>
    </div>
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add
            Vendor Group 
        </h3>
    </div>
    <div class="grid gap-4 mb-4 sm:grid-cols-1">
        <form action="">
            <div class="grid gap-6 mb-4 md:grid-cols-2">
                <div>
                    <label for="text"
                        class="mb-2 text-sm font-medium text-gray-900 dark:text-white">รหัสประเภทร้าน</label>
                    <input type="text" id="text" name="" placeholder="01, 02 ..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
                <div>
                    <label for="text"
                        class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">รายละเอียด</label>
                    <input type="text" id="text" name="" placeholder="ของหวาน, ของคาว, เครื่องดื่ม ..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
                <div>
                    <label for="text"
                        class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">รหัส SAP</label>
                    <input type="text" id="text" name="" placeholder="1111111"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
                
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            <button type="button"
                class="text-white focus:outline-non bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 mt-2 ">
                <a href="{{ route('vendor-group.index') }}">
                    Cancel
                </a>
            </button>
        </form>

    </div>
@endsection
@section('scripts')
@endsection
