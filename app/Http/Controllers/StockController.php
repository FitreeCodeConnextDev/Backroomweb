<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    public function index()
    {
        $stock_info = DB::table('sale_adjuststocktotal_daily')
            ->join('vendor_info', 'sale_adjuststocktotal_daily.vendor_id', '=', 'vendor_info.vendor_id')
            ->select('sale_adjuststocktotal_daily.*', 'vendor_info.vendor_name')
            ->where('sale_adjuststocktotal_daily.void_flag', '0')
            ->orderBy('sale_adjuststocktotal_daily.txnno', 'asc')
            ->get();
        return view('pages.stock_info.index', compact('stock_info'));
    }

    // Additional methods for create, store, show, edit, update, destroy can be added here

    public function create()
    {
        $vendor_name = DB::table('vendor_info')->select('vendor_id', 'vendor_name')->orderBy('vendor_id', 'asc')->get();
        return view('pages.stock_info.create', compact('vendor_name'));
    }

    public function store(Request $request)
    {
        // Logic to store stock information
        $validatedData = $request->validate([
            'txnno' => 'required|unique:sale_adjuststocktotal_daily,txnno',
            'txndate' => 'required|date',
            'remark' => 'nullable|string',
            'refdate' => 'nullable|date',
            'vendor_id' => 'required',
            'txn_type' => 'required|in:00,01',
            'products_json' => 'required|json',
        ], [
            'txnno.required' => __('stock.txnno_required'),
            'txnno.unique' => __('stock.txnno_unique'),
            'txndate.required' => __('stock.txndate_required'),
            'vendor_id.required' => __('stock.vendor_id_required'),
            'remark.required' => __('stock.remark_required'),
            'refdate.required' => __('stock.refdate_required'),
        ]);

        $txndate_formatted = date('Y-m-d', strtotime($validatedData['txndate']));
        $refdate_formatted = date('Y-m-d', strtotime($validatedData['refdate']));
        $products = json_decode($validatedData['products_json'], true);


        if (isset($validatedData)) {
            DB::transaction(function () use ($validatedData, $products, $txndate_formatted, $refdate_formatted) {
                // Insert Header
                $qty_sale = count($products);
                DB::table('sale_adjuststocktotal_daily')->insert([
                    'txnno' => $validatedData['txnno'],
                    'txndate' => $txndate_formatted,
                    'remark' => $validatedData['remark'],
                    'qty' => $qty_sale,
                    'refdate' => $refdate_formatted,
                    'vendor_id' => $validatedData['vendor_id'],
                    'txntype' => $validatedData['txn_type'],
                    'void_flag' => '0',
                ]);

                // Log Header
                Log::channel('activity')->notice('Stock transaction created', [
                    'txnno' => $validatedData['txnno'],
                    'vendor_id' => $validatedData['vendor_id'],
                    'txn_type' => $validatedData['txn_type'],
                    'txndate' => $validatedData['txndate'],
                    'inserted_by' => session('auth_user.user_name'),
                    'created_at' => now(),
                ]);

                // Process Products
                foreach ($products as $index => $product) {


                    // Insert Detail
                    DB::table('sale_adjuststock_daily')->insert([
                        'txnno' => $validatedData['txnno'],
                        'vendor_id' => $validatedData['vendor_id'],
                        'runno' => $index + 1,
                        'product_id' => $product['product_id'],
                        'product_desc' => $product['product_desc'],
                        'qty' => $product['qty'],
                        'priceunit' => $product['priceunit'],
                    ]);

                    // Update or Insert Stock Info
                    $stock_info = DB::table('stock_info')
                        ->where('product_id', $product['product_id'])
                        ->first();

                    if ($stock_info) {

                        $in_stock = $stock_info->in_stock + $product['qty'];
                        DB::table('stock_info')
                            ->where('product_id', $product['product_id'])
                            ->update([
                                'in_stock' => $in_stock,
                                'lastupdate' => now(),
                            ]);
                        Log::channel('activity')->notice('Stock transaction updated', [
                            'txnno' => $validatedData['txnno'],
                            'vendor_id' => $validatedData['vendor_id'],
                            'txn_type' => $validatedData['txn_type'],
                            'txndate' => $validatedData['txndate'],
                            'updated_by' => session('auth_user.user_name'),
                            'updated_at' => now(),
                        ]);
                    } else {
                        // Fetch product details for new stock_info entry if needed
                        $productDetails = DB::table('product_info')->where('product_id', $product['product_id'])->first();

                        if ($productDetails) {
                            DB::table('stock_info')->insert([
                                'vendor_id' => $validatedData['vendor_id'],
                                'product_id' => $product['product_id'],
                                'product_barcode' => $productDetails->product_barcode ?? '',
                                'product_desc' => $product['product_desc'],
                                'product_sdesc' => $productDetails->product_sdesc ?? '',
                                'cur_balance' => 0.00,
                                'in_stock' => $product['qty'],
                                'sale' => 0.00,
                                'miss' => 0.00,
                                'damage' => 0.00,
                                'out_stock' => 0.00,
                                'priceunit' => $product['priceunit'],
                                'lastupdate' => now()
                            ]);
                        }
                    }
                }
            });

            session()->flash('clear_local_storage_item', 'data_product');
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('stock.stock_added'));

            return redirect()->route('stock-info.index');
        } else {
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
    }


    public function cancel_adjuststock($txnno)
    {
        $stock_sale_adjust = DB::table('sale_adjuststock_daily')->where('txnno', $txnno)->get();
        foreach ($stock_sale_adjust as $stock_sale_adjust) {
            $stock_info = DB::table('stock_info')
                ->where('product_id', $stock_sale_adjust->product_id)
                ->where('vendor_id', $stock_sale_adjust->vendor_id)
                ->first();
            if ($stock_info) {
                $in_stock = $stock_info->in_stock - $stock_sale_adjust->qty;
                DB::table('stock_info')
                    ->where('product_id', $stock_sale_adjust->product_id)
                    ->where('vendor_id', $stock_sale_adjust->vendor_id)
                    ->update([
                        'in_stock' => $in_stock,
                        'lastupdate' => now(),
                    ]);

                DB::table('sale_adjuststocktotal_daily')->where('txnno', $txnno)->update([
                    'void_flag' => '1',
                    'void_date' => now(),
                    'void_userid' => session('auth_user.user_id'),
                ]);
            }
        }
        Log::channel('activity')->warning('Stock transaction Cancel', [
            'action' => 'Cancel',
            'txnno' => $txnno,
            'vendor_id' => $stock_sale_adjust->vendor_id,
            'product_id' => $stock_sale_adjust->product_id,
            'qty' => $stock_sale_adjust->qty,
            'cancel_by' => session('auth_user.user_name'),
            'cancel_at' => now(),
        ]);
        flash()
            ->option('position', 'bottom-right')
            ->option('timeout', 3000)
            ->success(__('stock.stock_adjusted_cancel'));
        return redirect()->route('stock-info.index');
    }



    public function getProductDetailsStock($product_id)
    {
        // ใช้ Query Builder เพื่อดึงข้อมูลของ Product
        $product = DB::table('product_info')
            ->join('unit_info', 'product_info.unit_id', '=', 'unit_info.unit_id')
            ->where('product_id', $product_id)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // ส่งข้อมูลกลับไปยัง JavaScript
        return response()->json([
            'product_desc' => $product->product_desc,
            'unit_name' => $product->unit_name,
        ]);
    }
}
