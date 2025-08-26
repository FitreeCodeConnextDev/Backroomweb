@extends('layouts.master')
@php
    include '../resources/config/menu.php';
@endphp
@section('title')
    {{ $con_menu['users_add'] }}
@endsection
@section('content')
    <div class="pb-4 mb-4 rounded-t">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        {{ $con_menu['users'] }}
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
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
                            {{ $con_menu['users_add'] }}
                        </a>
                    </div>
                </li>

            </ol>
        </nav>
    </div>
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ $con_menu['users_add'] }}
        </h3>
    </div>
    <div class="grid gap-4 mb-4 sm:grid-cols-1">
        <form action="">
            <div class="grid gap-6 mb-4 md:grid-cols-2">
                <div>
                    <label for="text"
                        class="mb-2 text-sm font-medium text-gray-900 dark:text-white">รหัสผู้ใช้ระบบ</label>
                    <input type="text" id="text" name="" placeholder="0001, 0002 ..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
                <div>
                    <label for="text" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">รหัสสาขา</label>
                    <input type="text" id="text" name="" placeholder=" ..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
                <div>
                    <label for="text"
                        class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">ชื่อผู้ใช้ระบบ</label>
                    <input type="text" id="text" name="" placeholder=" ..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
                <div>
                    <label for="text"
                        class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">หมายเลขบัตรประชาชน</label>
                    <input type="text" id="text" name="" placeholder=" ..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
                <div>
                    <label for="text" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">รหัสผ่าน</label>
                    <input type="password" id="password" name="" placeholder=" ••••••••"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
                <div>
                    <label for="text" class=" mb-2 text-sm font-medium text-gray-900 dark:text-white">Card
                        Password</label>
                    <input type="text" id="text" name="" placeholder="..."
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="" required />
                </div>
            </div>

            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab"
                            data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">Front</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                            aria-controls="dashboard" aria-selected="false">Back</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="settings-tab" data-tabs-target="#settings" type="button" role="tab"
                            aria-controls="settings" aria-selected="false">Vendor</button>
                    </li>
                    <li role="presentation">
                        <button
                            class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                            id="contacts-tab" data-tabs-target="#contacts" type="button" role="tab"
                            aria-controls="contacts" aria-selected="false">Permission</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                {{-- Front --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
                    aria-labelledby="profile-tab">
                    <div class="bg-white  p-4 md:p-6 mt-2">
                        <div class="grid gap-6 mb-6 md:grid-cols-5 mt-2">
                            {{-- 1 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-1" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-1"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทำรายการประจำวัน</label>
                            </div>
                            {{-- 2 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-2" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-2"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ตรวจสอบการทำรายการ</label>
                            </div>
                            {{-- 3 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-3" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-3"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ตรวจเช็คเงิน</label>
                            </div>
                            {{-- 4 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-4" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-4"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทำรายการเปลี่ยนบัตร</label>
                            </div>
                            {{-- 5 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-6" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-6"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทำรายการแลก
                                    Point</label>
                            </div>
                            {{-- 6 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-7" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-7"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ตรวจสอบข้อมูลบัตร</label>
                            </div>
                            {{-- 7 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-8" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-8"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ปิดการขาย</label>
                            </div>
                            {{-- 8 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-9" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-9"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เปลี่ยนผู้ใช้ระบบ</label>
                            </div>
                            {{-- 9 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-10" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-10"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">พิมพ์ใบกำกับภาษี</label>
                            </div>
                            {{-- 10 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-11" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-11"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">พิมพ์รายการขายร้านค้า</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Back --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel"
                    aria-labelledby="dashboard-tab">
                    <div class="bg-white  p-4 md:p-6 mt-2">

                        <div class="grid gap-6 mb-6 md:grid-cols-4 mt-2">
                            {{-- 1 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-1" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-1"
                                    class=" ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลร้านค้า</label>
                            </div>
                            {{-- 2 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-2" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-2"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลสมาชิก</label>
                            </div>
                            {{-- 3 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-3" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-3"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลกลุ่มสินค้า</label>
                            </div>
                            {{-- 4 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-4" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-4"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูล Promotion ร้านค้า</label>
                            </div>
                            {{-- 5 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-5" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-5"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูล
                                    Promotion
                                    บัตร</label>
                            </div>
                            {{-- 6 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-6" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-6"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลผู้ใช้ระบบ</label>
                            </div>
                            {{-- 7 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-7" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-7"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลสาขา</label>
                            </div>
                            {{-- 8 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-8" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-8"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลบัตร</label>
                            </div>
                            {{-- 9 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-9" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-9"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลประเภทบัตร</label>
                            </div>
                            {{-- 10 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-10" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-10"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลสินค้า Product</label>
                            </div>
                            {{-- 11 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-11" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-11"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลของรางวัล</label>
                            </div>
                            {{-- 12 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-12" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-12"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลพนักงาน</label>
                            </div>
                            {{-- 13 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-13" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-13"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลหน่วยนับ</label>
                            </div>
                            {{-- 14 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-14" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-14"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลกลุ่มสินค้า SAP</label>
                            </div>
                            {{-- 15 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-15" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-15"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูล Coupon</label>
                            </div>
                            {{-- 16 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-16" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-16"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลกลุ่มประเภทชำระเงิน</label>
                            </div>
                            {{-- 17 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-17" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-17"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลประเภทชำระเงิน</label>
                            </div>
                            {{-- 18 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-18" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-18"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทะเบียนข้อมูลไกด์</label>
                            </div>
                            {{-- 19 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-19" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-19"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ควบคุม
                                    Cashier</label>
                            </div>
                            {{-- 20 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-20" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-20"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">รายงานประจำวัน</label>
                            </div>
                            {{-- 21 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-21" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-21"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">รายงานเกี่ยวกับร้านค้า</label>
                            </div>
                            {{-- 22 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-22" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-22"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">รายงานเกี่ยวกับสมาชิก</label>
                            </div>
                            {{-- 23 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-23" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-23"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">รายงานเกี่ยวกับ Item สินค้า</label>
                            </div>
                            {{-- 24 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-24" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-24"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">รายงานประจำเดือน</label>
                            </div>
                            {{-- 25 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-25" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-25"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">รายงานสำหรับฝ่ายแคชเชียร์</label>
                            </div>
                            {{-- 26 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-26" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-26"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">รายงานสำหรับฝ่ายบัญชี/การเงิน</label>
                            </div>
                            {{-- 27 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-27" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-27"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">รายงานสำหรับฝ่ายร้านค้า</label>
                            </div>
                            {{-- 28 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-28" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-28"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ปิดระบบประจำวัน</label>
                            </div>
                            {{-- 29 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-29" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-29"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ปิดระบบประจำเดือน</label>
                            </div>
                            {{-- 30 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-30" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-30"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">สำรองข้อมูล</label>
                            </div>
                            {{-- 31 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-31" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-31"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ปรับปรุงข้อมูล</label>
                            </div>
                            {{-- 32 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-32" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-32"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ข้อมูล LOG File</label>
                            </div>
                            {{-- 33 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-33" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-33"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ข้อมูลระบบ</label>
                            </div>
                            {{-- 34 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-34" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-34"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Import ข้อมูล</label>
                            </div>
                            {{-- 35 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-35" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-35"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Export ข้อมูล</label>
                            </div>
                            {{-- 36 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-36" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-36"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Monitor ฝ่ายบริหาร</label>
                            </div>
                            {{-- 37 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-37" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-37"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Monitor
                                    ฝ่ายแคชเชียร์</label>
                            </div>
                            {{-- 38 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-38" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-38"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Monitor
                                    ฝ่ายร้านค้า</label>
                            </div>
                            {{-- 39 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-39" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-39"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">สินค้าใน Stock
                                </label>
                            </div>
                            {{-- 40 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-40" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-40"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">จัดทำบัตร Prepaid</label>
                            </div>
                            {{-- 41 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-41" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-41"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ล้างบัตร
                                    Prepaid</label>
                            </div>
                            {{-- 42 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-42" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-42"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">จัดทำใบกำกับภาษีเต็มรูป</label>
                            </div>
                            {{-- 43 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-43" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-43"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ล้างบัตรเพื่อนำกลับมาใช้</label>
                            </div>
                            {{-- 44 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-44" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-44"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ขัดทำ Invoice ร้านค้า</label>
                            </div>
                            {{-- 45 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-45" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-45"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">นำข้อมูลส่ง ERP</label>
                            </div>
                            {{-- 46 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-46" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-46"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ข้อมูลระบบ</label>
                            </div>
                            {{-- 47 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-47" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-47"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ข้อมูลเครื่องรูดบัตร</label>
                            </div>
                            {{-- 48 --}}
                            <div class="flex items-center mb-6">
                                <input id="checkbox-back-48" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-back-48"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ข้อมูลเครื่องแคชเชียร์</label>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- Vendor --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel"
                    aria-labelledby="settings-tab">
                    <div class="bg-white  p-4 md:p-6 mt-2">
                        <div class="grid gap-6 mb-6 grid-cols-2 mt-2">
                            <div class="flex items-center mb-6">
                                <input id="checkbox-vendor-1" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-vendor-1"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ทำรายการขาย</label>
                            </div>
                            <div class="flex items-center mb-6">
                                <input id="checkbox-vendor-2" type="checkbox" value=""
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-vendor-2"
                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไขราคาได้</label>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Permission --}}
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel"
                    aria-labelledby="contacts-tab">
                    <div class="bg-white  p-4 md:p-6 mt-2">
                        <div class="grid gap-6 mb-6 md:grid-cols-3 mt-2">
                            {{-- 1 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนร้านค้า</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-1" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-1"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-1" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-1"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-1" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-1"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 2 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนสมาชิก</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-2" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-2"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-2" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-2"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-2" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-2"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 3 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนกลุ่มสินค้า</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-3" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-3"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-3" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-3"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-3" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-3"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 4 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียน Promotion ร้านค้า</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-4" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-4"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-4" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-4"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-4" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-4"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 5 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียน Promotion บัตร</label>
                                <div class="flex items-center mb-4 mt-4">
                                    <div class="pl-2">
                                        <input id="per-add-5" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-5"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-5" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-4"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-5" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-5"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 6 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนผู้ใช้ระบบ</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-6" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-6"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-6" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-6"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-6" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-6"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 7 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนสาขา</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-7" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-7"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-7" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-7"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-7" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-7"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 8 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนบัตร</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-8" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-8"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-8" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-8"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-8" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-8"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 9 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนประเภทบัตร</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-9" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-9"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-9" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-9"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-9" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-9"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 10 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนสินค้า</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-10" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-10"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-10" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-10"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-10" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-10"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 11 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียน ของรางวัล</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-11" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-11"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-11" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-11"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-11" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-11"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 12 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนพนักงาน</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-12" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-12"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-12" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-12"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-12" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-12"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 13 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนหน่วยนับ</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-13" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-13"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-13" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-13"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-13" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-13"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 14 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนกลุ่มสินค้า SAP</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-14" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-14"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-14" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-14"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-14" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-14"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 15 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียน Coupon</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-15" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-15"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-15" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-15"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-15" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-15"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 16 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนกลุ่มประเภทชำระเงิน</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-16" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-16"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-16" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-16"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-16" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-16"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 17 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียนประเภทชำระเงิน</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-17" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-17"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-17" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-17"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-17" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-17"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 18 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">ทะเบียน ไกด์</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-18" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-18"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-18" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-18"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-18" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-18"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                            {{-- 19 --}}
                            <div>
                                <label for="" class="text-lg font-semibold">สินค้าใน Stock</label>
                                <div class="flex items-center mb-4 mt-4">

                                    <div class="pl-2">
                                        <input id="per-add-19" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-add-19"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">เพิ่ม</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-edit-19" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-edit-19"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">แก้ไข</label>
                                    </div>
                                    <div class="pl-2">
                                        <input id="per-del-19" type="checkbox" value=""
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="per-del-19"
                                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">ลบ</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            <a href="{{ route('users.index') }}">
                <button type="button"
                    class="text-white focus:outline-non bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 mt-2 ">
                    Cancel
                </button>
            </a>
        </form>
    </div>
@endsection
@section('scripts')
@endsection
