{{-- Permiss --}}
@php
    $user_id = session('auth_user.user_id');
    $user_info = DB::table('user_info')
        ->select('back_permiss')
        ->where('user_id', $user_id)
        ->where('activeflag', 1)
        ->first();
    $user_back = str_split($user_info->back_permiss);
    $branch_name = DB::table('branch_info')
        ->select('branch_name')
        ->where('branch_id', session('auth_user.branch_id'))
        ->first();
@endphp
{{-- Permiss --}}
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 ">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar"
                    type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 ">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>
                <a href="#" class="flex ms-2 md:me-24">
                    <img src="{{ asset('logo/CodeConnextLogo.png') }}" class="h-8 me-3" alt="Backroom Logo" />
                    <span class="max-w-lg lg:text-2xl text-[1.5vh] font-semibold leading-normal">
                        {{ __('menu.title_web') }} : @if (isset($branch_name))
                            {{ $branch_name->branch_name }}
                        @else
                            Center
                        @endif </span>
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 "
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">Open user menu</span>
                            <img class="w-8 h-8 rounded-full"
                                src="https://ui-avatars.com/api/?background=random&name={{ session('auth_user.user_name') }}"
                                alt="user photo">
                        </button>
                    </div>
                    <div class="z-30 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow "
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class=" text-gray-500 text-[12px] text-center">{{ __('menu.version_web') }} </p>
                        </div>
                        <div class="px-4 py-3 text-sm text-gray-900">
                            <div class="font-medium truncate"> User: {{ session('auth_user.user_name') }}</div>
                            <div class="font-medium truncate"> Branch: {{ session('auth_user.branch_id') }}</div>
                        </div>
                        <ul class="py-1 border-t border-gray-200" role="none">
                            <li class=" border-b border-gray-200 mb-0.5">
                                <form action="">
                                    <button type="button" id="ChangePasswordButton" data-modal-target="ChangePassword"
                                        data-modal-toggle="ChangePassword"
                                        class="block px-4 py-2 text-sm w-full text-gray-700 hover:bg-gray-100">
                                        {{ __('users.change_password') }}
                                    </button>
                                </form>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="block px-4 py-2 text-sm w-full text-gray-700 hover:bg-gray-100">
                                        Sign out
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
@include('layouts.password')

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-24 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 "
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white ">

        {{-- หมวดหมู่: Homepage --}}
        <ul class="space-y-2 font-medium">
            @php
                // เช็คว่าหน้าปัจจุบันอยู่ในหมวด Homepage หรือไม่
                $isHomeActive = request()->routeIs([
                    'vendor-page.*',
                    'vendor_product_info_search',
                    'member.*',
                    'products-groups.*',
                    'vendor-promotion.*',
                    'card-promotion.*',
                    'users.*',
                    'branch.*',
                    'card-type.*',
                    'products.*',
                    'staff.*',
                    'product-units.*',
                    'product-sap.*',
                    'coupons.*',
                    'payment-group.*',
                    'payment_type.*',
                    'expense_vendor*',
                ]);
            @endphp
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isHomeActive ? 'bg-gray-50' : '' }}"
                    aria-controls="back_end_dev" data-collapse-toggle="back_end_dev">
                    <span
                        class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ __('menu.homepage') }}</span>
                    <svg class="w-3 h-3 transition-transform {{ $isHomeActive ? 'rotate-180' : '' }}"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                {{-- กางออกอัตโนมัติถ้า $isHomeActive เป็น true --}}
                <ul id="back_end_dev" class="{{ $isHomeActive ? '' : 'hidden' }} py-2 space-y-2">
                    @if ($user_back[0] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('vendor-page.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs(['vendor-page.*', 'vendor_product_info_search']) ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.vendor') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[1] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('member.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('member.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.member') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[2] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href=" {{ route('products-groups.index') }} "
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('products-groups.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.product_group') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[3] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('vendor-promotion.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('vendor-promotion.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.vendor_promotion') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[4] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('card-promotion.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('card-promotion.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3">{{ __('menu.card_promo') }}</span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[5] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href=" {{ route('users.index') }} "
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('users.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.users') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[6] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('branch.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('branch.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.branch') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    {{-- <li>
                        <div class=" bg-white border-b border-gray-200 ">
                            <a href="#"
                                class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group ">
                                <span class="ms-3"> {{ __('menu.card') }} </span>
                            </a>
                        </div>
                    </li> --}}
                    @if ($user_back[8] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('card-type.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('card-type.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.card_type') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[9] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('products.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('products.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.product') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    {{-- <li>
                        <div class=" bg-white border-b border-gray-200 ">
                            <a href="#"
                                class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group ">
                                <span class="ms-3"> {{ __('menu.rewards') }} </span>
                            </a>
                        </div>
                    </li> --}}
                    @if ($user_back[11] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('staff.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('staff.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.staff') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[12] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('product-units.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('product-units.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.product_unit') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[13] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('product-sap.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('product-sap.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.product_sap') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[14] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('coupons.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('coupons.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.coupons') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[15] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('payment-group.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('payment-group.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.payment_groups') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif

                    @if ($user_back[16] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('payment_type.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('payment_type.*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('menu.payment_types') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif

                    <li>
                        <div class=" bg-white border-b border-gray-200 ">
                            <a href="{{ route('expense_vendor.index') }}"
                                class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('expense_vendor*') ? 'active_menu' : 'text-gray-500' }}">
                                <span class="ms-3"> {{ __('expense_vendor.expense_vendor_title') }} </span>
                            </a>
                        </div>
                    </li>
                    {{-- <li>
                        <div class=" bg-white border-b border-gray-200 ">
                            <a href="#"
                                class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group ">
                                <span class="ms-3"> {{ __('menu.guide') }} </span>
                            </a>
                        </div>
                    </li> --}}
                    {{-- <li>
                        <div class=" bg-white border-b border-gray-200 ">
                            <a href="{{ route('vendor-type.index') }}"
                                class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('vendor-type.*') ? 'active_menu' : 'text-gray-500' }}">
                                <span class="ms-3"> {{ __('menu.vendor_type') }} </span>
                            </a>
                        </div>
                    </li> --}}
                    {{-- ... เมนูอื่นๆ ในกลุ่ม Homepage (ทำซ้ำ pattern เดียวกัน) ... --}}
                </ul>
            </li>
        </ul>

        <div class=" mt-3 "></div>

        {{-- หมวดหมู่: Import --}}
        <ul class="space-y-2 font-medium">
            @php $isImportActive = request()->routeIs('import.*'); @endphp
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isImportActive ? 'bg-gray-50' : '' }}"
                    aria-controls="import" data-collapse-toggle="import">
                    <span
                        class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ __('import.import') }}</span>
                    <svg class="w-3 h-3 transition-transform {{ $isImportActive ? 'rotate-180' : '' }}"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="import" class="{{ $isImportActive ? '' : 'hidden' }} py-2 space-y-2">
                    @if ($user_back[0] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('import.vendors') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('import.vendors*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('import.import_vendor') }} </span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('import.vendorproduct') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('import.vendorproduct*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('import.import_vendorproduct') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[9] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('import.product') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('import.product*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('import.import_product') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($user_back[4] == 1)
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('import.user') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('import.user*') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('import.import_user') }} </span>
                                </a>
                            </div>
                        </li>
                    @endif
                    {{-- ... เมนูอื่นๆ ในกลุ่ม Import ... --}}
                </ul>
            </li>
        </ul>

        <div class=" mt-3 "></div>
        <ul class="space-y-2 font-medium">
            @php $isChartActive = request()->routeIs('charts.*'); @endphp
            <button type="button"
                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isChartActive ? 'bg-gray-50' : '' }}"
                aria-controls="chart" data-collapse-toggle="chart">

                <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ __('chart.title') }}</span>
                <svg class="w-3 h-3 transition-transform {{ $isChartActive ? 'rotate-180' : '' }}" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>
            <ul id="chart" class=" py-2 space-y-2 {{ $isChartActive ? '' : 'hidden' }}">
                <li>
                    <div class=" bg-white border-b border-gray-200 ">
                        <a href="{{ route('charts.daily') }}"
                            class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('charts.daily') ? 'active_menu' : 'text-gray-500' }}">
                            <span class="ms-3"> {{ __('chart.daily_chart') }} </span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class=" bg-white border-b border-gray-200 ">
                        <a href="{{ route('charts.backupdaily') }}"
                            class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs(['charts.backupdaily', 'charts.showdailybackupchart']) ? 'active_menu' : 'text-gray-500' }}">
                            <span class="ms-3"> {{ __('chart.daily_backup_chart') }} </span>
                        </a>
                    </div>
                </li>
            </ul>
        </ul>

        {{-- หมวดหมู่: Report --}}
        @if ($user_back[20] == 1)
            @php $isReportActive = request()->routeIs('report.*'); @endphp
            <ul class="space-y-2 font-medium">
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isReportActive ? 'bg-gray-50' : '' }}"
                        aria-controls="report" data-collapse-toggle="report">
                        <span
                            class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ __('report.report_title') }}</span>
                        <svg class="w-3 h-3 transition-transform {{ $isReportActive ? 'rotate-180' : '' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="report" class="{{ $isReportActive ? '' : 'hidden' }} py-2 space-y-2">
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('report.index') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('report.index') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('report.daily_report') }} </span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('report.vendor') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('report.vendor') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('report.vendor_report') }} </span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('report.item') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('report.item') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('report.item_report') }} </span>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class=" bg-white border-b border-gray-200 ">
                                <a href="{{ route('report.payment') }}"
                                    class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('report.payment') ? 'active_menu' : 'text-gray-500' }}">
                                    <span class="ms-3"> {{ __('report.payment_type_report') }} </span>
                                </a>
                            </div>
                        </li>
                        {{-- ... เมนูอื่นๆ ในกลุ่ม Report ... --}}
                    </ul>
                </li>
            </ul>
        @endif

        <div class=" mt-3 "></div>
        @php $isOrtherActive = request()->routeIs(['other.*' , 'stock-info.*']); @endphp
        <ul class="space-y-2 font-medium">
            <li>
                <button type="button"
                    class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isOrtherActive ? 'bg-gray-50' : '' }}"
                    aria-controls="orther" data-collapse-toggle="orther">
                    <span
                        class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ __('menu.other_cate') }}</span>
                    <svg class="w-3 h-3 transition-transform {{ $isOrtherActive ? 'rotate-180' : '' }}"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <ul id="orther" class="{{ $isOrtherActive ? '' : 'hidden' }} py-2 space-y-2">

                    <li>
                        <div class=" bg-white border-b border-gray-200 ">
                            <a href="{{ route('stock-info.index') }}"
                                class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('stock-info.*') ? 'active_menu' : 'text-gray-500' }}">
                                <span class="ms-3"> {{ __('menu.stock_title') }} </span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class=" bg-white border-b border-gray-200 ">
                            <a href="{{ route('other.expensevendor_other_index') }}"
                                class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('other.expensevendor_*') ? 'active_menu' : 'text-gray-500' }}">
                                <span class="ms-3"> {{ __('expense_vendor.expense_vendor') }} </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            {{-- ส่วน Back DEV Maintenance --}}
            @if (session('auth_user.profile_code') == '00')
                <hr class=" my-8 border border-y-gray-200">
                @php $isDevActive = request()->is('log-viewer*') || request()->routeIs('session-main.*'); @endphp
                <ul class="space-y-2 font-medium">
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isDevActive ? 'bg-gray-50' : '' }}"
                            aria-controls="back_end" data-collapse-toggle="back_end">
                            <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Back DEV
                                Maintenance</span>
                            <svg class="w-3 h-3 transition-transform {{ $isDevActive ? 'rotate-180' : '' }}"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="back_end" class="{{ $isDevActive ? '' : 'hidden' }} py-2 space-y-2">
                            <li>
                                <div class=" bg-white border-b border-gray-200 ">
                                    <a href="/log-viewer" target="_blank"
                                        class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('log-viewer.*') ? 'active_menu' : 'text-gray-500' }}">
                                        <span class="ms-3"> LOG View </span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class=" bg-white border-b border-gray-200 ">
                                    <a href="{{ route('session-main.index') }}"
                                        class="flex items-center w-full p-2 mb-2 text-gray-900 transition duration-75 hover:bg-gray-100 rounded-lg pl-5 group {{ request()->routeIs('session-main.*') ? 'active_menu' : 'text-gray-500' }}">
                                        <span class="ms-3"> Session </span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endif
    </div>
</aside>
