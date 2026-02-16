<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!PermissionHelper::checkUserPermission('back', null, 9)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        // Get the search term from the request (if it exists)
        $search = $request->input('search', ''); // Default to empty if not present

        // Start the query to fetch products
        $products = DB::table('product_info')
            ->where('activeflag', 1)
            ->where(function ($query) use ($search) {
                // If search term is provided, filter by product description or product id
                if ($search) {
                    $query->where('product_desc', 'like', '%' . $search . '%')
                        ->orWhere('product_id', 'like', '%' . $search . '%');
                }
            })
            ->select('product_id', 'product_desc')
            ->orderBy('product_id', 'desc')
            ->paginate(10);

        // Return the view, passing the products and search term
        return view('pages.products.index', compact('products', 'search'));
    }
    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 27)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product Create Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product Create Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $product_group = DB::table('groupproduct_info')
            ->where('activeflag', 1)
            ->orderBy('groupproduct_id', 'asc')->get();
        $card_type = DB::table('sub_info')->select('subno', 'subdesc')
            ->where('activeflag', 1)
            ->orderBy('subno', 'asc')->get();
        $product_unit = DB::table('unit_info')
            ->where('activeflag', 1)
            ->orderBy('unit_id')->get();
        $product_category = DB::table('catproductgroup_info')
            ->orderBy('catproduct_group')->get();
        $group_type = DB::table('typeproduct_info')
            ->orderBy('type_group')->get();
        $gtype_group = DB::table('grouptypeproduct_info')
            ->orderBy('gtype_group')->get();
        return view("pages.products.create", compact('card_type', 'product_unit', 'product_category', 'product_group', 'group_type', 'gtype_group'));
    }

    public function store(Request $request)
    {
        try {
            $productData = $request->validate(
                [
                    'product_id' => 'required|max:6|unique:product_info,product_id',
                    'product_barcode' => 'required',
                    'product_desc' => 'required',
                    'product_sdesc' => 'nullable',
                    'product_group' => 'required',
                    'subno' => 'required',
                    'unit_id' => 'nullable',
                    'show_color' => 'nullable',
                    'catproduct_group' => 'nullable',
                    'product_edesc' => 'nullable',
                    'rabbit_discount' => 'nullable',
                    'show_kiosk' => 'nullable',
                    'type_group' => 'nullable',
                    'gtype_group' => 'nullable',
                    'product_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                ],
                [
                    'product_id.required' => __('product.product_id_valid'),
                    'product_id.max' => __('product.product_id_valid'),
                    'product_id.unique' => __('product.product_id_unique'),
                    'product_desc.required' => __('product.product_desc_valid'),
                    'product_barcode.required' => __('product.product_barcode_valid'),
                    'product_group.required' => __('product.product_group_valid'),
                    'subno.required' => __('product.subno_valid'),
                    'unit_id.required' => __('product.unit_id_valid'),
                    'product_img.image' => __('product.product_img_valid'),
                    'product_img.mimes' => __('product.product_img_mimes'),
                    'product_img.max' => __('product.product_img_max'),

                ]
            );

            $insert_product = DB::table('product_info')->insert([
                'product_id' => $productData['product_id'],
                'product_barcode' => $productData['product_barcode'],
                'product_desc' => $productData['product_desc'],
                'product_sdesc' => $productData['product_sdesc'],
                'product_group' => $productData['product_group'],
                'subno' => $productData['subno'],
                'unit_id' => $productData['unit_id'],
                'show_color' => $productData['show_color'],
                'product_edesc' => $productData['product_edesc'],
                'rabbit_discount' => $productData['rabbit_discount'],
                'catproduct_group' => $productData['catproduct_group'],
                'show_kiosk' => $productData['show_kiosk'],
                'type_group' => $productData['type_group'] ?? null,
                'gtype_group' => $productData['gtype_group'] ?? null,
                'activeflag' => 1,
            ]);
            if ($request->hasFile('product_img')) {
                upload_product_bmp(
                    $request->file('product_img'),
                    $productData['product_id'] . '.bmp'
                );
            }

            if (isset($insert_product)) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' created product: ' . $productData['product_id'], [
                    'product_id' => $productData['product_id'],
                    'product_barcode' => $productData['product_barcode'],
                    'product_desc' => $productData['product_desc'],
                    'product_sdesc' => $productData['product_sdesc'],
                    'product_group' => $productData['product_group'],
                    'subno' => $productData['subno'],
                    'unit_id' => $productData['unit_id'],
                    'show_color' => $productData['show_color'],
                    'catproduct_group' => $productData['catproduct_group'],
                    'action' => 'create',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.save_is_success'));
                return redirect()->route('products.index');
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' failed to create product: ' . $productData['product_id'], [
                    'product_id' => $productData['product_id'],
                    'product_barcode' => $productData['product_barcode'],
                    'product_desc' => $productData['product_desc'],
                    'product_sdesc' => $productData['product_sdesc'],
                    'product_group' => $productData['product_group'],
                    'subno' => $productData['subno'],
                    'unit_id' => $productData['unit_id'],
                    'show_color' => $productData['show_color'],
                    'catproduct_group' => $productData['catproduct_group'],
                    'action' => 'create',
                    'created_at' => Carbon::now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.save_is_failed'));
                return redirect()->route('products.create');
            }
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' exception when creating product: ' . $request->input('product_id') . ' - ' . $e->getMessage(), [
                'product_id' => $request->input('product_id'),
                'error' => $e->getMessage(),
                'action' => 'create',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->route('products.create');
        }
    }

    public function edit($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 28)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product Edit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product Edit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $product = DB::table('product_info')->where('product_id', $id)->first();
        $product_group = DB::table('groupproduct_info')->orderBy('groupproduct_id', 'asc')->get();
        $card_type = DB::table('sub_info')->select('subno', 'subdesc')->orderBy('subno', 'asc')->get();
        $product_unit = DB::table('unit_info')->orderBy('unit_id')->get();
        $product_category = DB::table('catproductgroup_info')->orderBy('catproduct_group')->get();
        $group_type = DB::table('typeproduct_info')
            ->orderBy('type_group')->get();
        $gtype_group = DB::table('grouptypeproduct_info')
            ->orderBy('gtype_group')->get();
        Log::channel('activity')->info('Product Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'product' => $product,
            'page' => 'Product Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view("pages.products.edit", compact('product', 'card_type', 'product_unit', 'product_category', 'product_group', 'group_type', 'gtype_group'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            $productData = $request->validate(
                [
                    'product_barcode' => 'required',
                    'product_desc' => 'required',
                    'product_sdesc' => 'nullable',
                    'product_group' => 'required',
                    'subno' => 'required',
                    'unit_id' => 'nullable',
                    'show_color' => 'nullable',
                    'catproduct_group' => 'nullable',
                    'product_edesc' => 'nullable',
                    'rabbit_discount' => 'nullable',
                    'show_kiosk' => 'nullable',
                    'type_group' => 'nullable',
                    'gtype_group' => 'nullable',
                    'product_img' => 'nullable|image|mimes:jpeg,png,jpg|max:1048',

                ],
                [
                    'product_desc.required' => __('product.product_desc_valid'),
                    'product_barcode.required' => __('product.product_barcode_valid'),
                    'product_group.required' => __('product.product_group_valid'),
                    'subno.required' => __('product.subno_valid'),
                    'unit_id.required' => __('product.unit_id_valid'),
                    'product_img.image' => __('product.product_img_valid'),
                    'product_img.mimes' => __('product.product_img_mimes'),
                    'product_img.max' => __('product.product_img_max'),
                    'product_img.dimensions' => __('product.product_img_dimensions'),

                ]
            );

            $update_product = DB::table('product_info')->where('product_id', $id)
                ->update([
                    'product_barcode' => $productData['product_barcode'],
                    'product_desc' => $productData['product_desc'],
                    'product_sdesc' => $productData['product_sdesc'],
                    'product_group' => $productData['product_group'],
                    'subno' => $productData['subno'],
                    'unit_id' => $productData['unit_id'],
                    'show_color' => $productData['show_color'],
                    'product_edesc' => $productData['product_edesc'],
                    'rabbit_discount' => $productData['rabbit_discount'],
                    'catproduct_group' => $productData['catproduct_group'],
                    'show_kiosk' => $productData['show_kiosk'],
                    'type_group' => $productData['type_group'] ?? null,
                    'gtype_group' => $productData['gtype_group'] ?? null,
                ]);
            if ($request->hasFile('product_img')) {
                upload_product_bmp(
                    $request->file('product_img'),
                    $id . '.bmp'
                );
            }

            if (isset($update_product)) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' updated product: ' . $id, [
                    'product_id' => $id,
                    'product_barcode' => $productData['product_barcode'],
                    'product_desc' => $productData['product_desc'],
                    'product_sdesc' => $productData['product_sdesc'],
                    'product_group' => $productData['product_group'],
                    'subno' => $productData['subno'],
                    'unit_id' => $productData['unit_id'],
                    'show_color' => $productData['show_color'],
                    'catproduct_group' => $productData['catproduct_group'],
                    'action' => 'update',
                    'update detail' => $productData,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->success(__('menu.edit_is_success'));
                return redirect()->route('products.index');
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' failed to update product: ' . $id, [
                    'product_id' => $id,
                    'product_barcode' => $productData['product_barcode'],
                    'product_desc' => $productData['product_desc'],
                    'product_sdesc' => $productData['product_sdesc'],
                    'product_group' => $productData['product_group'],
                    'subno' => $productData['subno'],
                    'unit_id' => $productData['unit_id'],
                    'show_color' => $productData['show_color'],
                    'catproduct_group' => $productData['catproduct_group'],
                    'action' => 'update',
                    'update detail' => $productData,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
                flash()
                    ->option('position', 'bottom-right')
                    ->option('timeout', 3000)
                    ->error(__('menu.edit_is_failed'));
                return redirect()->route('products.edit', $id);
            }
        } catch (\Exception $e) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' exception when updating product: ' . $id . ' - ' . $e->getMessage(), [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'action' => 'update',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            // flash()
            //     ->option('position', 'bottom-right')
            //     ->option('timeout', 3000)
            //     ->error($e->getMessage());
            sweetalert()
                ->timer(15000)
                ->error($e->getMessage());
            return redirect()->route('products.edit', $id);
        }
    }

    public function destroy($id)
    {
        if (!PermissionHelper::checkUserPermission('function', 29)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product Delete Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product Delete Page',
                'timestamp' => Carbon::now()->toDateTimeString(),
            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $delete_product = DB::table('product_info')->where('product_id', $id)
            ->update([
                'activeflag' => 0,
            ]);
        if (isset($delete_product)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' deleted product: ' . $id, [
                'product_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('products.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete product: ' . $id, [
                'product_id' => $id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('products.index')->with('error', 'ไม่สามารถลบข้อมูลสินค้าได้');
        }
    }
}
