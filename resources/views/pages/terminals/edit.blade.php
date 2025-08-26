@extends('layouts.master')
@section('title')
    Edit Terminal
@endsection
@section('content')
    <div class="pb-4 mb-4 rounded-t">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('terminal.index') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Terminal
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
                            class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">Edit
                            Terminal
                            Terminal ID : {{ $term_id }}
                        </a>
                    </div>
                </li>

            </ol>
        </nav>
    </div>
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Terminal
        </h3>
    </div>

    <div class="grid gap-4 mb-4 sm:grid-cols-1">
        <p class="my-4 text-lg text-gray-500">Terminal ID : {{ $term_id }}</p>

        <form action="{{ route('terminal.update', $term_id) }}" method="post">
            @csrf
            @method('PUT')
            @foreach ($datagroup as $item)
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Branch
                            ID</label>
                        <input type="text" id="text" name="branch_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $item['branch_id'] }}" required />
                    </div>
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Terminal
                            Name</label>
                        <input type="text" id="last_name" name="term_name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $item['term_name'] }}" required />
                    </div>
                    <div>
                        <label for="text"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">PMINO</label>
                        <input type="text" id="text" name="pmino"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $item['pmino'] }}" />
                    </div>
                    <div>
                        <label for="website" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Serial
                            No.</label>
                        <input type="text" id="text" name="serialno"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $item['serialno'] }}" />
                    </div>
                    <div>
                        <label for="visitors" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IP
                            Address</label>
                        <input type="text" id="company" name="ipaddress"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $item['ipaddress'] }}" />
                    </div>
                    <div>
                        <label for="activateflag"
                            class="block mb-3 text-sm font-medium text-gray-900 dark:text-white">Activate
                            Flag</label>
                        <label class="inline-flex items-center me-5 cursor-pointer">
                            <input type="hidden" name="activeflag" value="0" class="sr-only peer">
                            <input id="activateflag" type="checkbox" name="activeflag" value="1" <?php echo $item['activeflag'] === '1' ? 'checked' : ''; ?>
                                class="sr-only peer">
                            <div
                                class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                        </label>
                    </div>

                    <div>
                        <label for="visitors" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slip
                            Prefix</label>
                        <input type="text" id="company" name="slipprefix"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $item['slipprefix'] }}" />
                    </div>
                    <div>
                        <label for="visitors" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">File
                            Adrress </label>
                        <input type="text" id="company" name="file_address"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $item['file_address'] }}" required />
                    </div>
                    <div>
                        <label for="visitors" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Download
                            Flag</label>
                        <input type="text" id="company" name="file_address"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $item['download_flag'] }}" required />
                    </div>
                    <div>
                        <label for="visitors" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Download
                            Date</label>

                        <input type="text" id="company" name="download_date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ isset($item['download_date']) && !empty($item['download_date']) ? $item['download_date'] : '' }}" />


                    </div>

                </div>

                <div class="w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Terminal Function</h2>
                    <hr>
                    {{-- เครื่องพิมพ์ --}}
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">เครื่องพิมพ์</h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-2">
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ใช้อุปกรณ์</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="equipment"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['equipment'] === '0' ? 'selected' : ''; ?>>ไม่ใช้</option>
                                        <option value="1" <?php echo $terminal_function_group['equipment'] === '1' ? 'selected' : ''; ?>>ใช้ Printer</option>
                                        <option value="2" <?php echo $terminal_function_group['equipment'] === '2' ? 'selected' : ''; ?>>ใช้ Keyboard</option>
                                    </select>
                                </label>
                            </div>
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">การพิมพ์</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="type_equipment"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['type_equipment'] === '0' ? 'selected' : ''; ?>>พิมพ์ทันที</option>
                                        <option value="1" <?php echo $terminal_function_group['type_equipment'] === '1' ? 'selected' : ''; ?>>พิมพ์เมื่อต้องการ</option>
                                    </select>


                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Toggle Making a transaction --}}
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">การทำรายการ</h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-2">
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Void
                                    รายการขาย</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="void_list"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['void_list'] === '0' ? 'selected' : ''; ?>>ไม่ใช้</option>
                                        <option value="1" <?php echo $terminal_function_group['void_list'] === '1' ? 'selected' : ''; ?>>ใช้</option>
                                    </select>
                                </label>
                            </div>
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ใช้
                                    Supervisor</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="supervoid"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['supervoid'] === '0' ? 'selected' : ''; ?>>ไม่ใช้</option>
                                        <option value="1" <?php echo $terminal_function_group['supervoid'] === '1' ? 'selected' : ''; ?>>ใช้</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Toggle Check the machine IP --}}
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">ตรวจสอบ IP เครื่อง</h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-2">
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ตรวจสอบ IP</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="ip_check"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['ip_check'] === '0' ? 'selected' : ''; ?>>ไม่ใช้</option>
                                        <option value="1" <?php echo $terminal_function_group['ip_check'] === '1' ? 'selected' : ''; ?>>ใช้</option>
                                    </select>
                                </label>
                            </div>
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">สอบถามคะแนน</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="show_score"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['show_score'] === '0' ? 'selected' : ''; ?>>ไม่ใช้</option>
                                        <option value="1" <?php echo $terminal_function_group['show_score'] === '1' ? 'selected' : ''; ?>>ใช้</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Swipe to check card balance --}}
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">รูดตรวจสอบเงินบัตร
                        </h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-2">
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เลือก</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="check_cardmoney"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['check_cardmoney'] === '0' ? 'selected' : ''; ?>>ไม่ใช้</option>
                                        <option value="1" <?php echo $terminal_function_group['check_cardmoney'] === '1' ? 'selected' : ''; ?>>ใช้</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Types of printing at the store --}}
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">ประเภทการพิมพ์ร้านค้า
                        </h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-2">
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">การพิมพ์แบบ</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="print_type"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['print_type'] === '0' ? 'selected' : ''; ?>>พิมพ์เฉพาะบัตร 0</option>
                                        <option value="1" <?php echo $terminal_function_group['print_type'] === '1' ? 'selected' : ''; ?>>พิมพ์ทุกรายการ</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Show balance In case of not enough money --}}
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">แสดงยอดเงิน กรณีเงินไม่พอ
                        </h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-2">
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">เลือก</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="balance_enough"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['balance_enough'] === '0' ? 'selected' : ''; ?>>ไม่ใช้</option>
                                        <option value="1" <?php echo $terminal_function_group['balance_enough'] === '1' ? 'selected' : ''; ?>>ใช้</option>
                                    </select>
                                </label>
                            </div>
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">แสดงผล</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="show_balance"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['show_balance'] === '0' ? 'selected' : ''; ?>>ไม่แสดงผล</option>
                                        <option value="1" <?php echo $terminal_function_group['show_balance'] === '1' ? 'selected' : ''; ?>>แสดงผล</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                    {{-- Expire --}}
                    <div class="bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 mt-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">หมดอายุ
                        </h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 mt-2">
                            <div>
                                <label for="visitors"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">แสดงผล</label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <select name="expire"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option selected disabled>เลือก</option>
                                        <option value="0" <?php echo $terminal_function_group['expire'] === '0' ? 'selected' : ''; ?>>ไม่ใช้</option>
                                        <option value="1" <?php echo $terminal_function_group['expire'] === '1' ? 'selected' : ''; ?>>ใช้</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

    </div>
    @endforeach
    <button type="submit"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
    <button type="button"
        class="text-white focus:outline-non bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 mt-2 ">
        <a href="{{ route('terminal.index') }}">
            Cancel
        </a>
    </button>
    </form>
    </div>
@endsection

@section('scripts')
@endsection
