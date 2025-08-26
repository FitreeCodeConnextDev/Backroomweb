<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportCotroller extends Controller
{
    public function import_product()
    {
        $product_col = DB::table('information_schema.columns')
            ->select('column_name')
            ->where('table_name', 'product_info')
            ->orderBy('ordinal_position')
            ->pluck('column_name')
            ->toArray();
        // dd($product_col);

        return view('pages.importCsv.product_info.product', compact('product_col'));
    }
    public function import_vendorproduct(Request $request)
    {
        $vendor_col = DB::table('information_schema.columns')
            ->select('column_name')
            ->where('table_name', 'vendorproduct_info')
            ->orderBy('ordinal_position')
            ->pluck('column_name')
            ->toArray();
        // dd($vendor_col);

        return view('pages.importCsv.vendorproduct_info.vendor', compact('vendor_col'));
    }
    public function import_vendor(Request $request)
    {
        $vendor_col = DB::table('information_schema.columns')
            ->select('column_name')
            ->where('table_name', 'vendor_info')
            ->orderBy('ordinal_position')
            ->pluck('column_name')
            ->toArray();
        // dd($vendor_col);

        return view('pages.importCsv.vendor_info.vendor', compact('vendor_col'));
    }

    public function import_user(Request $request)
    {
        $user_col = DB::table('information_schema.columns')
            ->select('column_name')
            ->where('table_name', 'user_info')
            ->orderBy('ordinal_position')
            ->pluck('column_name')
            ->toArray();
        // dd($user_col);

        return view('pages.importCsv.user_info.users', compact('user_col'));
    }
    public function import_product_preview(Request $request)
    {
        $request->validate(
            [
                'csv_file' => 'required|file|mimes:csv,txt,xls,xlsx,ods,tsv|max:2048', // กำหนดขนาดไฟล์สูงสุด 2MB
                'selected' => 'required|array',
            ],
            [
                'csv_file.required' => __('import.import_file_required'),
                'csv_file.mimes' => __('import.import_format'),
                'csv_file.max' => __('import.import_error_desc') . ' (Max: 2MB)',
                'selected.required' => __('import.import_field_required'),
            ]
        );
        // dd($request->all());

        if (!$request->hasFile('csv_file')) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_file_required'));
            return redirect()->back();
        }

        $file = $request->file('csv_file');

        // ✅ อ่าน path ชั่วคราวแบบปลอดภัย
        $path = $file->getPathname();

        if (!$path || !file_exists($path)) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_csv'));
            return redirect()->back();
        }

        // ✅ เปิดไฟล์อย่างปลอดภัย
        $handle = fopen($path, 'r');

        if (!$handle) {
            sweetalert()
                ->timer(15000)
                ->error('ไม่สามารถเปิดไฟล์ CSV ได้');
            return redirect()->back();
        }
        $hasHeader = $request->input('has_header', false);

        $handle = fopen($file, 'r');
        $rows = [];
        $header = [];
        $lineNumber = 0;

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if (empty($line)) continue;

            $line = iconv('TIS-620', 'UTF-8//IGNORE', $line);
            $data = str_getcsv($line);

            if ($hasHeader && $lineNumber === 0) {
                $header = $data;
            } else {
                $rows[] = $data;
            }

            $lineNumber++;
        }

        if (!$hasHeader && isset($rows[0])) {
            // สร้าง header ชั่วคราว เช่น Column 1, Column 2, ...
            $header = array_map(fn($i) => "Column {$i}", array_keys($rows[0]));
        }

        fclose($handle);

        // สมมุติชื่อคอลัมน์ใน DB
        $columns_db = $request->input('selected', []);
        $db_columns = array_map(function ($column) {
            return str_replace(' ', '_', $column);
        }, $columns_db);

        $count_header = count($header);
        $count_column = count($db_columns);

        if ($count_header !== $count_column) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_count_field'));
            return redirect()->back();
        }

        return view('pages.importCsv.product_info.preview', compact('header', 'rows', 'db_columns', 'columns_db'));
    }
    public function import_vendorproduct_preview(Request $request)
    {
        $request->validate(
            [
                'csv_file' => 'required|file|mimes:csv,txt,xls,xlsx,ods,tsv|max:2048', // กำหนดขนาดไฟล์สูงสุด 2MB
                'selected' => 'required|array',
            ],
            [
                'csv_file.required' => __('import.import_file_required'),
                'csv_file.mimes' => __('import.import_format'),
                'csv_file.max' => __('import.import_error_desc') . ' (Max: 2MB)',
                'selected.required' => __('import.import_field_required'),
            ]
        );
        // dd($request->all());
        if (!$request->hasFile('csv_file')) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_file_required'));
            return redirect()->back();
        }
        $file = $request->file('csv_file');
        // ✅ อ่าน path ชั่วคราวแบบปลอดภัย
        $path = $file->getPathname();
        if (!$path || !file_exists($path)) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_csv'));
            return redirect()->back();
        }
        // ✅ เปิดไฟล์อย่างปลอดภัย
        $handle = fopen($path, 'r');
        if (!$handle) {
            sweetalert()
                ->timer(15000)
                ->error('ไม่สามารถเปิดไฟล์ CSV ได้');
            return redirect()->back();
        }
        $hasHeader = $request->input('has_header', false);
        $handle = fopen($file, 'r');
        $rows = [];
        $header = [];
        $lineNumber = 0;
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if (empty($line)) continue;
            $line = iconv('TIS-620', 'UTF-8//IGNORE', $line);
            $data = str_getcsv($line);
            if ($hasHeader && $lineNumber === 0) {
                $header = $data;
            } else {
                $rows[] = $data;
            }
            $lineNumber++;
            if (!$hasHeader && isset($rows[0])) {
                // สร้าง header ชั่วคราว เช่น Column 1, Column 2, ...
                $header = array_map(fn($i) => "Column {$i}", array_keys($rows[0]));
            }
        }
        fclose($handle);
        // สมมุติชื่อคอลัมน์ใน DB
        $columns_db = $request->input('selected', []);
        $db_columns = array_map(function ($column) {
            return str_replace(' ', '_', $column);
        }, $columns_db);
        $count_header = count($header);
        $count_column = count($db_columns);
        if ($count_header !== $count_column) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_count_field'));
            return redirect()->back();
        }
        return view('pages.importCsv.vendorproduct_info.preview', compact('header', 'rows', 'db_columns', 'columns_db'));
    }
    public function import_vendor_preview(Request $request)
    {
        $request->validate(
            [
                'csv_file' => 'required|file|mimes:csv,txt,xls,xlsx,ods,tsv|max:2048', // กำหนดขนาดไฟล์สูงสุด 2MB
                'selected' => 'required|array',
            ],
            [
                'csv_file.required' => __('import.import_file_required'),
                'csv_file.mimes' => __('import.import_format'),
                'csv_file.max' => __('import.import_error_desc') . ' (Max: 2MB)',
                'selected.required' => __('import.import_field_required'),
            ]
        );
        // dd($request->all());
        if (!$request->hasFile('csv_file')) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_file_required'));
            return redirect()->back();
        }
        $file = $request->file('csv_file');
        // ✅ อ่าน path ชั่วคราวแบบปลอดภัย
        $path = $file->getPathname();
        if (!$path || !file_exists($path)) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_csv'));
            return redirect()->back();
        }
        // ✅ เปิดไฟล์อย่างปลอดภัย
        $handle = fopen($path, 'r');
        if (!$handle) {
            sweetalert()
                ->timer(15000)
                ->error('ไม่สามารถเปิดไฟล์ CSV ได้');
            return redirect()->back();
        }
        $hasHeader = $request->input('has_header', false);
        $handle = fopen($file, 'r');
        $rows = [];
        $header = [];
        $lineNumber = 0;
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if (empty($line)) continue;
            $line = iconv('TIS-620', 'UTF-8//IGNORE', $line);
            $data = str_getcsv($line);
            if ($hasHeader && $lineNumber === 0) {
                $header = $data;
            } else {
                $rows[] = $data;
            }
            $lineNumber++;
            if (!$hasHeader && isset($rows[0])) {
                // สร้าง header ชั่วคราว เช่น Column 1, Column 2, ...
                $header = array_map(fn($i) => "Column {$i}", array_keys($rows[0]));
            }
        }
        fclose($handle);
        // สมมุติชื่อคอลัมน์ใน DB
        $columns_db = $request->input('selected', []);
        $db_columns = array_map(function ($column) {
            return str_replace(' ', '_', $column);
        }, $columns_db);
        $count_header = count($header);
        $count_column = count($db_columns);
        if ($count_header !== $count_column) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_count_field'));
            return redirect()->back();
        }
        return view('pages.importCsv.vendor_info.preview', compact('header', 'rows', 'db_columns', 'columns_db'));
    }
    public function import_user_preview(Request $request)
    {
        $request->validate(
            [
                'csv_file' => 'required|file|mimes:csv,txt,xls,xlsx,ods,tsv|max:2048', // กำหนดขนาดไฟล์สูงสุด 2MB
                'selected' => 'required|array',
            ],
            [
                'csv_file.required' => __('import.import_file_required'),
                'csv_file.mimes' => __('import.import_format'),
                'csv_file.max' => __('import.import_error_desc') . ' (Max: 2MB)',
                'selected.required' => __('import.import_field_required'),
            ]
        );
        // dd($request->all());
        if (!$request->hasFile('csv_file')) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_file_required'));
            return redirect()->back();
        }
        $file = $request->file('csv_file');
        // ✅ อ่าน path ชั่วคราวแบบปลอดภัย
        $path = $file->getPathname();
        if (!$path || !file_exists($path)) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_csv'));
            return redirect()->back();
        }
        // ✅ เปิดไฟล์อย่างปลอดภัย
        $handle = fopen($path, 'r');
        if (!$handle) {
            sweetalert()
                ->timer(15000)
                ->error('ไม่สามารถเปิดไฟล์ CSV ได้');
            return redirect()->back();
        }
        $hasHeader = $request->input('has_header', false);
        $handle = fopen($file, 'r');
        $rows = [];
        $header = [];
        $lineNumber = 0;
        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if (empty($line)) continue;
            $line = iconv('TIS-620', 'UTF-8//IGNORE', $line);
            $data = str_getcsv($line);
            if ($hasHeader && $lineNumber === 0) {
                $header = $data;
            } else {
                $rows[] = $data;
            }
            $lineNumber++;
            if (!$hasHeader && isset($rows[0])) {
                // สร้าง header ชั่วคราว เช่น Column 1, Column 2, ...
                $header = array_map(fn($i) => "Column {$i}", array_keys($rows[0]));
            }
        }
        fclose($handle);
        // สมมุติชื่อคอลัมน์ใน DB
        $columns_db = $request->input('selected', []);
        $db_columns = array_map(function ($column) {
            return str_replace(' ', '_', $column);
        }, $columns_db);
        $count_header = count($header);
        $count_column = count($db_columns);
        if ($count_header !== $count_column) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_count_field'));
            return redirect()->back();
        }
        return view('pages.importCsv.user_info.preview', compact('header', 'rows', 'db_columns', 'columns_db'));
    }

    public function import_product_save(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $columns = json_decode($request->input('columns'), true);

        // dd($data, $columns);

        if (empty($data) || empty($columns)) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_desc'));
            return back();
        }
        $insertData = [];
        $columns = array_map(fn($column) => str_replace(' ', '_', $column), $columns);

        // กำหนดคอลัมน์ที่ต้องการตรวจสอบ unique เช่น 'product_id'
        $uniqueColumn = 'product_id';
        $existingValues = DB::table('product_info')->pluck($uniqueColumn)->toArray();
        $newValues = [];

        try {
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $index => $column) {
                    $rowData[$column] = $row[$index];
                }
                // ตรวจสอบค่า unique
                if (isset($rowData[$uniqueColumn])) {
                    $value = $rowData[$uniqueColumn];
                    if (in_array($value, $existingValues) || in_array($value, $newValues)) {
                        // ถ้ามีค่าอยู่แล้ว ให้ข้ามหรือแจ้ง error
                        continue; // หรือเก็บ error เพื่อแจ้งผู้ใช้
                    }
                    $newValues[] = $value;
                }
                $insertData[] = $rowData;
            }

            if (empty($insertData)) {
                log::channel('activity')->error(session('auth_user.user_id') . ' import to product_info error Value Duplicate', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'Import Product',
                    'data' => $insertData,
                    'page' => 'Import Product Page',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
                sweetalert()
                    ->timer(15000)
                    ->error(__('import.import_error_desc') . ' ' . __('import.import_duplicate'));
                return redirect()->route('import.product');
            }

            // บันทึกข้อมูลลงฐานข้อมูล
            DB::table('product_info')->insert($insertData);
            log::channel('activity')->info(session('auth_user.user_id') . ' Accessed import to product_info', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'Import Product',
                'data' => $insertData,
                'page' => 'Import Product Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()->success(__('import.import_success'));
            return redirect()->route('import.product');
        } catch (\Exception $e) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_desc') . ' ' . $e->getMessage());
            return redirect()->route('import.product');
        }
    }
    public function import_vendorproduct_save(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $columns = json_decode($request->input('columns'), true);

        // dd($data, $columns);

        if (empty($data) || empty($columns)) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_desc'));
            return back();
        }
        $insertData = [];
        $columns = array_map(fn($column) => str_replace(' ', '_', $column), $columns);

        // กำหนดคอลัมน์ที่ต้องการตรวจสอบ unique เช่น 'product_id'
        $uniqueColumn = 'product_id';
        $existingValues = DB::table('vendorproduct_info')->pluck($uniqueColumn)->toArray();
        $newValues = [];

        try {
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $index => $column) {
                    $rowData[$column] = $row[$index];
                }
                // ตรวจสอบค่า unique
                if (isset($rowData[$uniqueColumn])) {
                    $value = $rowData[$uniqueColumn];
                    if (in_array($value, $existingValues) || in_array($value, $newValues)) {
                        // ถ้ามีค่าอยู่แล้ว ให้ข้ามหรือแจ้ง error
                        continue;
                    }
                    $newValues[] = $value;
                }
                $insertData[] = $rowData;
            }

            if (empty($insertData)) {
                log::channel('activity')->error(session('auth_user.user_id') . ' import to vendorproduct_info error Value Duplicate', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'Import Vendor Product',
                    'data' => $insertData,
                    'page' => 'Import Vendor Product Page',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
                sweetalert()
                    ->timer(15000)
                    ->error(__('import.import_error_desc') . ' ' . __('import.import_duplicate'));

                return redirect()->route('import.vendorproduct');
            }

            // บันทึกข้อมูลลงฐานข้อมูล
            DB::table('vendorproduct_info')->insert($insertData);
            log::channel('activity')->info(session('auth_user.user_id') . ' Accessed import to vendorproduct_info', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'Import Vendor Product',
                'data' => $insertData,
                'page' => 'Import Vendor Product Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()->success(__('import.import_success'));
            return redirect()->route('import.vendorproduct');
        } catch (\Exception $e) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_desc') . ' ' . $e->getMessage());
            return redirect()->route('import.vendorproduct');
        }
    }
    public function import_vendor_save(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $columns = json_decode($request->input('columns'), true);
        if (empty($data) || empty($columns)) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_desc'));
            return back();
        }
        $insertData = [];
        $columns = array_map(fn($column) => str_replace(' ', '_', $column), $columns);
        $uniqueColumn = 'vendor_id';
        $existingValues = DB::table('vendor_info')->pluck($uniqueColumn)->toArray();
        $newValues = [];
        try {
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $index => $column) {
                    $rowData[$column] = $row[$index];
                }
                // ตรวจสอบค่า unique
                if (isset($rowData[$uniqueColumn])) {
                    $value = $rowData[$uniqueColumn];
                    if (in_array($value, $existingValues) || in_array($value, $newValues)) {
                        // ถ้ามีค่าอยู่แล้ว ให้ข้ามหรือแจ้ง error
                        continue;
                    }
                    $newValues[] = $value;
                }
                $insertData[] = $rowData;
            }

            if (empty($insertData)) {
                log::channel('activity')->error(session('auth_user.user_id') . ' import to vendorproduct_info error Value Duplicate', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'Import Vendor ',
                    'data' => $insertData,
                    'page' => 'Import VendorPage',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
                sweetalert()
                    ->timer(15000)
                    ->error(__('import.import_error_desc') . ' ' . __('import.import_duplicate'));
                return redirect()->route('import.vendors');
            }

            // บันทึกข้อมูลลงฐานข้อมูล
            DB::table('vendor_info')->insert($insertData);
            log::channel('activity')->info(session('auth_user.user_id') . ' Accessed import to vendor_info', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'Import Vendor ',
                'data' => $insertData,
                'page' => 'Import Vendor  Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()->success(__('import.import_success'));
            return redirect()->route('import.vendors');
        } catch (\Exception $e) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_desc') . ' ' . $e->getMessage());
            return redirect()->route('import.vendors');
        }
    }
    public function import_user_save(Request $request)
    {
        $data = json_decode($request->input('data'), true);
        $columns = json_decode($request->input('columns'), true);
        if (empty($data) || empty($columns)) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_desc'));
            return back();
        }
        $insertData = [];
        $columns = array_map(fn($column) => str_replace(' ', '_', $column), $columns);
        $uniqueColumn = 'user_id';
        $existingValues = DB::table('user_info')->pluck($uniqueColumn)->toArray();
        $newValues = [];
        try {
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $index => $column) {
                    $rowData[$column] = $row[$index];
                }
                // ตรวจสอบค่า unique
                if (isset($rowData[$uniqueColumn])) {
                    $value = $rowData[$uniqueColumn];
                    if (in_array($value, $existingValues) || in_array($value, $newValues)) {
                        // ถ้ามีค่าอยู่แล้ว ให้ข้ามหรือแจ้ง error
                        continue;
                    }
                    $newValues[] = $value;
                }
                $insertData[] = $rowData;
            }
            if (empty($insertData)) {
                log::channel('activity')->error(session('auth_user.user_id') . ' import to user_info error Value Duplicate', [
                    'user_id' => session('auth_user.user_id'),
                    'action' => 'Import User ',
                    'data' => $insertData,
                    'page' => 'Import User Page',
                    'timestamp' => Carbon::now()->toDateTimeString(),
                ]);
                sweetalert()
                    ->timer(15000)
                    ->error(__('import.import_error_desc') . ' ' . __('import.import_duplicate'));
                return redirect()->route('import.user');
            }
            // dd($insertData);
            // บันทึกข้อมูลลงฐานข้อมูล
            DB::table('user_info')->insert($insertData);
            log::channel('activity')->info(session('auth_user.user_id') . ' Accessed import to user_info', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'Import User ',
                'data' => $insertData,
                'page' => 'Import User Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()->success(__('import.import_success'));
            return redirect()->route('import.user');
        } catch (\Exception $e) {
            sweetalert()
                ->timer(15000)
                ->error(__('import.import_error_desc') . ' ' . $e->getMessage());
            return redirect()->route('import.user');
        }
    }
}
