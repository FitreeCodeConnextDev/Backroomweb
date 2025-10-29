<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VendorProductController extends Controller
{
    public function getProductDetails($product_id)
    {
        // ใช้ Query Builder เพื่อดึงข้อมูลของ Product
        $product = DB::table('product_info')->where('product_id', $product_id)->first();

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // ส่งข้อมูลกลับไปยัง JavaScript
        return response()->json([
            'product_barcode' => $product->product_barcode,
            'product_desc' => $product->product_desc,
            'product_sdesc' => $product->product_sdesc,
            'product_group' => $product->product_group,
        ]);
    }

    public function store(Request $request)
    {
        $form_vendor_product = $request->validate([
            'vendor_id' => 'required',
            'branch_id' => 'required',
            'term_id' => 'required',
            'product_id' => 'required',
            'product_free' => 'required',
            'groupvate' => 'required',
            'product_seq' => 'required|numeric|unique:vendorproduct_info,product_seq,NULL,id,activeflag,1,vendor_id,' . $request->input('vendor_id') . ',branch_id,' . $request->input('branch_id'),
            'use_point' => 'required',
            'add_point' => 'required',
            'priceunit' => 'required',
            'gp_normal' => 'required',
            'pricediscount' => 'required',
            'gp_promotion' => 'required',
            'pricemember' => 'required',
            'gp_member' => 'required',
            'pricestaff' => 'required',
            'gp_staff' => 'required',
            'pricerabbit' => 'required',
            'gp_rabbit' => 'required',
            'priceqr' => 'required',
            'gp_qr' => 'required',
            'product_perunit' => 'required',
            'vatrate' => 'required',
            'pricesp1' => 'required',
            'gp_sp1' => 'required',
            'pricesp2' => 'required',
            'gp_sp2' => 'required',
            'pricesp3' => 'required',
            'gp_sp3' => 'required',
            'pricesp4' => 'required',
            'gp_sp4' => 'required',
            'pricesp5' => 'required',
            'gp_sp5' => 'required',
            'priceedc' => 'nullable',
            'gp_edc' => 'nullable',
            'campaing_code' => 'nullable',
            'campaing_startdate' => 'nullable',
            'campaing_enddate' => 'nullable',
            'campaing_starttime' => 'nullable',
            'campaing_endtime' => 'nullable',

        ], [
            'vendor_id.required' => __('vendor_product.vendor_id_required'),
            'branch_id.required' => __('vendor_product.branch_id_required'),
            'term_id.required' => __('vendor_product.term_id_required'),
            'product_id.required' => __('vendor_product.product_id_required'),
            'product_free.required' => __('vendor_product.product_free_required'),
            'groupvate.required' => __('vendor_product.groupvat_required'),
            'product_seq.required' => __('vendor_product.product_seq_required'),
            'product_seq.numeric' => __('vendor_product.product_seq_numeric'),
            'product_seq.unique' => __('vendor_product.product_seq_unique'),
            'use_point.required' => __('vendor_product.product_use_point_required'),
            'add_point.required' => __('vendor_product.product_add_point_required'),
            'priceunit.required' => __('vendor_product.product_priceunit_required'),
            'gp_normal.required' => __('vendor_product.product_gp_normal_required'),
            'pricediscount.required' => __('vendor_product.product_pricediscount_required'),
            'gp_promotion.required' => __('vendor_product.product_gp_promotion_required'),
            'pricemember.required' => __('vendor_product.product_price_member_required'),
            'gp_member.required' => __('vendor_product.product_gp_member_required'),
            'pricestaff.required' => __('vendor_product.product_price_staff_required'),
            'gp_staff.required' => __('vendor_product.product_gp_staff_required'),
            'pricerabbit.required' => __('vendor_product.product_price_rabbit_required'),
            'gp_rabbit.required' => __('vendor_product.product_gp_rabbit_required'),
            'priceqr.required' => __('vendor_product.product_price_qr_required'),
            'gp_qr.required' => __('vendor_product.product_gp_qr_required'),
            'product_perunit.required' => __('vendor_product.product_perunit_required'),
            'vatrate.required' => __('vendor_product.product_vatrate_required'),
            'pricesp1.required' => __('vendor_product.product_sp1_required'),
            'gp_sp1.required' => __('vendor_product.product_gp_sp1_required'),
            'pricesp2.required' => __('vendor_product.product_sp2_required'),
            'gp_sp2.required' => __('vendor_product.product_gp_sp2_required'),
            'pricesp3.required' => __('vendor_product.product_sp3_required'),
            'gp_sp3.required' => __('vendor_product.product_gp_sp3_required'),
            'pricesp4.required' => __('vendor_product.product_sp4_required'),
            'gp_sp4.required' => __('vendor_product.product_gp_sp4_required'),
            'pricesp5.required' => __('vendor_product.product_sp5_required'),
            'gp_sp5.required' => __('vendor_product.product_gp_sp5_required'),
            'priceedc.required' => __('vendor_product.product_price_edc_required'),
            'gp_edc.required' => __('vendor_product.product_gp_edc_required'),

        ]);

        $campaing_startdate = Carbon::parse($form_vendor_product['campaing_startdate'])->format('Y-m-d');
        $campaing_enddate = Carbon::parse($form_vendor_product['campaing_enddate'])->format('Y-m-d');
        $campaing_start = Carbon::parse($campaing_startdate . ' ' . $form_vendor_product['campaing_starttime'])->format('Y-m-d H:i:s');
        $campaing_end = Carbon::parse($campaing_enddate . ' ' . $form_vendor_product['campaing_endtime'])->format('Y-m-d H:i:s');
        if ($form_vendor_product) {
            $insertData = [
                'vendor_id' => $form_vendor_product['vendor_id'],
                'branch_id' => $form_vendor_product['branch_id'],
                'term_id' => $form_vendor_product['term_id'],
                'product_id' => $form_vendor_product['product_id'],
                'product_free' => $form_vendor_product['product_free'],
                'product_seq' => $form_vendor_product['product_seq'],
                'groupvat' => $form_vendor_product['groupvate'],
                'use_point' => $form_vendor_product['use_point'],
                'add_point' => $form_vendor_product['add_point'],
                'priceunit' => $form_vendor_product['priceunit'],
                'gp_normal' => $form_vendor_product['gp_normal'],
                'pricediscount' => $form_vendor_product['pricediscount'],
                'gp_promotion' => $form_vendor_product['gp_promotion'],
                'pricemember' => $form_vendor_product['pricemember'],
                'gp_member' => $form_vendor_product['gp_member'],
                'pricestaff' => $form_vendor_product['pricestaff'],
                'gp_staff' => $form_vendor_product['gp_staff'],
                'pricerabbit' => $form_vendor_product['pricerabbit'],
                'gp_rabbit' => $form_vendor_product['gp_rabbit'],
                'priceqr' => $form_vendor_product['priceqr'],
                'gp_qr' => $form_vendor_product['gp_qr'],
                'product_perunit' => $form_vendor_product['product_perunit'],
                'vatrate' => $form_vendor_product['vatrate'],
                'pricesp1' => $form_vendor_product['pricesp1'],
                'gp_sp1' => $form_vendor_product['gp_sp1'],
                'pricesp2' => $form_vendor_product['pricesp2'],
                'gp_sp2' => $form_vendor_product['gp_sp2'],
                'pricesp3' => $form_vendor_product['pricesp3'],
                'gp_sp3' => $form_vendor_product['gp_sp3'],
                'pricesp4' => $form_vendor_product['pricesp4'],
                'gp_sp4' => $form_vendor_product['gp_sp4'],
                'pricesp5' => $form_vendor_product['pricesp5'],
                'gp_sp5' => $form_vendor_product['gp_sp5'],
                'campaign_code' => $form_vendor_product['campaing_code'],
                'campaign_startdate' => $campaing_start,
                'campaign_enddate' => $campaing_end,
                'activeflag' => 1,
            ];

            if ($form_vendor_product['priceedc'] !== null) {
                $insertData['priceedc'] = $form_vendor_product['priceedc'];
            }

            if ($form_vendor_product['gp_edc'] !== null) {
                $insertData['gp_edc'] = $form_vendor_product['gp_edc'];
            }

            $vendor_product_insert = DB::table('vendorproduct_info')
                ->insert($insertData);
            if ($vendor_product_insert) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' created vendor product: ' . $form_vendor_product['product_id'], [
                    'vendor_id' => $form_vendor_product['vendor_id'],
                    'branch_id' => $form_vendor_product['branch_id'],
                    'product_id' => $form_vendor_product['product_id'],
                    'product_seq' => $form_vendor_product['product_seq'],
                    'action' => 'created',
                    'created_at' => now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' failed to create vendor product: ' . $form_vendor_product['product_id'], [
                    'vendor_id' => $form_vendor_product['vendor_id'],
                    'branch_id' => $form_vendor_product['branch_id'],
                    'product_id' => $form_vendor_product['product_id'],
                    'product_seq' => $form_vendor_product['product_seq'],
                    'action' => 'failed',
                    'created_at' => now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                return response()->json(['message' => __('menu.save_is_failed')]);
            }
        }
    }
    public function update(Request $request, $product_seq)
    {

        $vendor_id = $request->input('vendor_id');
        $branch_id = $request->input('branch_id');
        $form_vendor_edit = [
            'product_seq' => $request->input('product_seq'),
            'groupvate' => $request->input('groupvate'),
            'use_point' => $request->input('use_point'),
            'add_point' => $request->input('add_point'),
            'priceunit' => $request->input('priceunit'),
            'gp_normal' => $request->input('gp_normal'),
            'pricediscount' => $request->input('pricediscount'),
            'gp_promotion' => $request->input('gp_promotion'),
            'pricemember' => $request->input('pricemember'),
            'gp_member' => $request->input('gp_member'),
            'pricestaff' => $request->input('pricestaff'),
            'gp_staff' => $request->input('gp_staff'),
            'pricerabbit' => $request->input('pricerabbit'),
            'gp_rabbit' => $request->input('gp_rabbit'),
            'priceqr' => $request->input('priceqr'),
            'gp_qr' => $request->input('gp_qr'),
            'product_perunit' => $request->input('product_perunit'),
            'vatrate' => $request->input('vatrate'),
            'pricesp1' => $request->input('pricesp1'),
            'gp_sp1' => $request->input('gp_sp1'),
            'pricesp2' => $request->input('pricesp2'),
            'gp_sp2' => $request->input('gp_sp2'),
            'pricesp3' => $request->input('pricesp3'),
            'gp_sp3' => $request->input('gp_sp3'),
            'pricesp4' => $request->input('pricesp4'),
            'gp_sp4' => $request->input('gp_sp4'),
            'pricesp5' => $request->input('pricesp5'),
            'gp_sp5' => $request->input('gp_sp5'),
            'priceedc' => $request->input('priceedc'),
            'gp_edc' => $request->input('gp_edc'),
            'campaing_code' => $request->input('campaing_code'),
            'campaing_startdate' => $request->input('campaing_startdate'),
            'campaing_enddate' => $request->input('campaing_enddate'),
            'campaing_starttime' => $request->input('campaing_starttime'),
            'campaing_endtime' => $request->input('campaing_endtime'),
        ];
        $campaing_startdate = Carbon::parse($form_vendor_edit['campaing_startdate'])->format('Y-m-d');
        $campaing_enddate = Carbon::parse($form_vendor_edit['campaing_enddate'])->format('Y-m-d');
        $campaing_start = Carbon::parse($campaing_startdate . ' ' . $form_vendor_edit['campaing_starttime'])->format('Y-m-d H:i:s');
        $campaing_end = Carbon::parse($campaing_enddate . ' ' . $form_vendor_edit['campaing_endtime'])->format('Y-m-d H:i:s');
        $product_seq_id = DB::table('vendorproduct_info')
            ->where('vendor_id', '=', $vendor_id)
            ->where('branch_id', '=', $branch_id)
            ->where('product_seq', '=', $product_seq)
            ->first();
        $all_seq = DB::table('vendorproduct_info')
            ->where('vendor_id', $vendor_id)
            ->where('branch_id', $branch_id)
            ->pluck('product_seq')
            ->toArray();
        $form_vendor_update = [
            'product_seq' => $form_vendor_edit['product_seq'],
            'groupvat' => $form_vendor_edit['groupvate'],
            'use_point' => $form_vendor_edit['use_point'],
            'add_point' => $form_vendor_edit['add_point'],
            'priceunit' => $form_vendor_edit['priceunit'],
            'gp_normal' => $form_vendor_edit['gp_normal'],
            'pricediscount' => $form_vendor_edit['pricediscount'],
            'gp_promotion' => $form_vendor_edit['gp_promotion'],
            'pricemember' => $form_vendor_edit['pricemember'],
            'gp_member' => $form_vendor_edit['gp_member'],
            'pricestaff' => $form_vendor_edit['pricestaff'],
            'gp_staff' => $form_vendor_edit['gp_staff'],
            'pricerabbit' => $form_vendor_edit['pricerabbit'],
            'gp_rabbit' => $form_vendor_edit['gp_rabbit'],
            'priceqr' => $form_vendor_edit['priceqr'],
            'gp_qr' => $form_vendor_edit['gp_qr'],
            'product_perunit' => $form_vendor_edit['product_perunit'],
            'vatrate' => $form_vendor_edit['vatrate'],
            'pricesp1' => $form_vendor_edit['pricesp1'],
            'gp_sp1' => $form_vendor_edit['gp_sp1'],
            'pricesp2' => $form_vendor_edit['pricesp2'],
            'gp_sp2' => $form_vendor_edit['gp_sp2'],
            'pricesp3' => $form_vendor_edit['pricesp3'],
            'gp_sp3' => $form_vendor_edit['gp_sp3'],
            'pricesp4' => $form_vendor_edit['pricesp4'],
            'gp_sp4' => $form_vendor_edit['gp_sp4'],
            'pricesp5' => $form_vendor_edit['pricesp5'],
            'gp_sp5' => $form_vendor_edit['gp_sp5'],
            'campaign_code' => $form_vendor_edit['campaing_code'],
            'campaign_startdate' => $campaing_start,
            'campaign_enddate' => $campaing_end,
        ];
        if ($form_vendor_edit['priceedc'] !== null) {
            $form_vendor_update['priceedc'] = $form_vendor_edit['priceedc'];
        }
        if ($form_vendor_edit['gp_edc'] !== null) {
            $form_vendor_update['gp_edc'] = $form_vendor_edit['gp_edc'];
        }
        // ✅ ถ้ามี และเป็นของตัวเอง (เท่ากับค่าที่แก้ไข) → ผ่าน
        if ($product_seq_id->product_seq == $form_vendor_edit['product_seq']) {
            $vendor_product_update = DB::table('vendorproduct_info')
                ->where([
                    'vendor_id' => $vendor_id,
                    'branch_id' => $branch_id,
                    'product_seq' => $product_seq,
                ])
                ->update($form_vendor_update);
            if ($vendor_product_update == true) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' updated vendor product: ' . $product_seq, [
                    'vendor_id' => $vendor_id,
                    'branch_id' => $branch_id,
                    'product_seq' => $product_seq,
                    'action' => 'updated',
                    'update detail' => $form_vendor_edit,
                    'updated_at' => now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
                sweetalert()
                    ->success(__('menu.edit_is_success'));
                return redirect()->back();
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' failed to update vendor product: ' . $product_seq, [
                    'vendor_id' => $vendor_id,
                    'branch_id' => $branch_id,
                    'product_seq' => $product_seq,
                    'action' => 'failed',
                    'update detail' => $form_vendor_edit,
                    'updated_at' => now()->toDateTimeString(),
                    'updated_by' => session('auth_user.user_id'),
                ]);
                sweetalert()
                    ->error(__('menu.edit_is_failed'));
                return redirect()->back();
            }
        }
        // ❌ ถ้ามี และไม่เท่ากับของตัวเอง (แปลว่าซ้ำของคนอื่น) → error
        elseif (in_array($form_vendor_edit['product_seq'], $all_seq)) {
            sweetalert()->error(__('vendor_product.product_seq_unique'));
            return redirect()->back();
        }

        // ✅ ถ้ายังไม่มี product_seq ในฐาน → ผ่าน
        $vendor_product_update = DB::table('vendorproduct_info')
            ->where([
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
                'product_seq' => $product_seq,
            ])
            ->update($form_vendor_update);
        if ($vendor_product_update == true) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' updated vendor product: ' . $product_seq, [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
                'product_seq' => $product_seq,
                'action' => 'updated',
                'update detail' => $form_vendor_edit,
                'updated_at' => now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->success(__('menu.edit_is_success'));
            return redirect()->back();
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to update vendor product: ' . $product_seq, [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
                'product_seq' => $product_seq,
                'action' => 'failed',
                'update detail' => $form_vendor_edit,
                'updated_at' => now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->error(__('menu.edit_is_failed'));
            return redirect()->back();
        }
    }

    public function destroy_product($product_seq, $vendor_id, $branch_id)
    {
        $vendor_product_delete = DB::table('vendorproduct_info')
            ->where([
                'product_seq' => $product_seq,
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
            ])
            ->update([
                'activeflag' => 0,
            ]);
        if ($vendor_product_delete) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' deleted vendor product: ' . $product_seq, [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
                'product_seq' => $product_seq,
                'action' => 'deleted',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->success(__('menu.delete_is_success'));
            return redirect()->back();
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete vendor product: ' . $product_seq, [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
                'product_seq' => $product_seq,
                'action' => 'failed',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->error(__('menu.delete_is_failed'));
            return redirect()->back();
        }
    }

    public function insert_product_component(Request $request)
    {
        $form = $request->validate([
            'vendor_id' => 'required',
            'product_id' => 'required',
            'productdetail_id' => 'required',
            'qty' => 'required|numeric|min:1',
        ], [
            'vendor_id.required' => __('vendor_product.vendor_id_required'),
            'product_id.required' => __('vendor_product.product_id_required'),
            'productdetail_id.required' => __('vendor_product.productdetail_id_required'),
            'qty.required' => __('vendor_product.qty_required'),
            'qty.numeric' => __('vendor_product.qty_numeric'),
            'qty.min' => __('vendor_product.qty_min'),
        ]);
        // dd($form);
        // log::channel('activity')->info(session('auth_user.user_id') . ' insert product component', [
        //     'vendor_id' => $form['vendor_id'],
        //     'product_id' => $form['product_id'],
        //     'productdetail_id' => $form['productdetail_id'],
        //     'qty' => $form['qty'],
        // ]);
        if (isset($form)) {
            DB::table('productdetail_info')
                ->insert([
                    'vendor_id' => $form['vendor_id'],
                    'product_id' => $form['product_id'],
                    'productdetail_id' => $form['productdetail_id'],
                    'qty' => $form['qty'],
                ]);
            Log::channel('activity')->notice(session('auth_user.user_id') . ' inserted product component', [
                'vendor_id' => $form['vendor_id'],
                'product_id' => $form['product_id'],
                'productdetail_id' => $form['productdetail_id'],
                'qty' => $form['qty'],
                'action' => 'inserted',
                'created_at' => now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to insert product component', [
                'action' => 'failed',
                'created_at' => now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            return response()->json(['success' => false, 'message' => __('menu.save_is_failed')]);
        }
    }

    public function insert_promo(Request $request)
    {
        $promo_form = $request->validate([
            'vendor_id' => 'required',
            'branch_id' => 'required',
            'term_id' => 'required',
            'product_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'priceunit' => 'required|numeric|min:0',
            'gp_normal' => 'required|numeric|min:0|max:100',
            'pricediscount' => 'required|numeric|min:0',
            'gp_promotion' => 'required|numeric|min:0|max:100',
            'pricemember' => 'required|numeric|min:0',
            'gp_member' => 'required|numeric|min:0|max:100',
            'pricestaff' => 'required|numeric|min:0',
            'gp_staff' => 'required|numeric|min:0|max:100',
            'pricerabbit' => 'required|numeric|min:0',
            'gp_rabbit' => 'required|numeric|min:0|max:100',
            'priceqr' => 'required|numeric|min:0',
            'gp_qr' => 'required|numeric|min:0|max:100',
            'pricesp1' => 'required|numeric|min:0',
            'gp_sp1' => 'required|numeric|min:0|max:100',
            'pricesp2' => 'required|numeric|min:0',
            'gp_sp2' => 'required|numeric|min:0|max:100',
            'pricesp3' => 'required|numeric|min:0',
            'gp_sp3' => 'required|numeric|min:0|max:100',
            'pricesp4' => 'required|numeric|min:0',
            'gp_sp4' => 'required|numeric|min:0|max:100',
            'pricesp5' => 'required|numeric|min:0',
            'gp_sp5' => 'required|numeric|min:0|max:100',
            'priceedc' => 'nullable|numeric|min:0',
            'gp_edc' => 'nullable|numeric|min:0|max:100'
        ], [
            'vendor_id.required' => __('vendor_product.vendor_id_required'),
            'branch_id.required' => __('vendor_product.branch_id_required'),
            'term_id.required' => __('vendor_product.term_id_required'),
            'product_id.required' => __('vendor_product.product_id_required'),
            'start_date.required' => __('vendor_product.start_date_required'),
            'start_date.date' => __('vendor_product.start_date_date'),
            'end_date.required' => __('vendor_product.end_date_required'),
            'end_date.date' => __('vendor_product.end_date_date'),
            'end_date.after_or_equal' => __('vendor_product.end_date_after_or_equal'),
            'start_time.required' => __('vendor_product.start_time_required'),
            'end_time.required' => __('vendor_product.end_time_required'),
            'priceunit.required' => __('vendor_product.price_required'),
            'priceunit.numeric' => __('vendor_product.price_numeric'),
            'priceunit.min' => __('vendor_product.price_min'),
            'gp_normal.required' => __('vendor_product.gp_required'),
            'gp_normal.numeric' => __('vendor_product.gp_numeric'),
            'gp_normal.min' => __('vendor_product.gp_min'),
            'gp_normal.max' => __('vendor_product.gp_max')
        ]);
        $start_date = Carbon::parse($promo_form['start_date'])->format('Y-m-d');

        $end_date = Carbon::parse($promo_form['end_date'])->format('Y-m-d');
        $start = Carbon::parse($start_date . '' . $promo_form['start_time'])->format('Y-m-d H:i:s');
        $end = Carbon::parse($end_date . '' . $promo_form['end_time'])->format('Y-m-d H:i:s');


        if ($promo_form) {
            // dd($promo_form);
            $time_seq = DB::table('vendorproductpromotion_info')
                ->where([
                    'vendor_id' => $promo_form['vendor_id'],
                    'branch_id' => $promo_form['branch_id'],
                ])
                ->max('time_seq');
            $insert_data = DB::table('vendorproductpromotion_info')
                ->insert([
                    'vendor_id' => $promo_form['vendor_id'],
                    'branch_id' => $promo_form['branch_id'],
                    'term_id' => $promo_form['term_id'],
                    'product_id' => $promo_form['product_id'],
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'start_time' => $start,
                    'end_time' => $end,
                    'time_seq' => $time_seq + 1,
                    'priceunit' => $promo_form['priceunit'],
                    'gp_normal' => $promo_form['gp_normal'],
                    'pricediscount' => $promo_form['pricediscount'],
                    'gp_promotion' => $promo_form['gp_promotion'],
                    'pricemember' => $promo_form['pricemember'],
                    'gp_member' => $promo_form['gp_member'],
                    'pricestaff' => $promo_form['pricestaff'],
                    'gp_staff' => $promo_form['gp_staff'],
                    'pricerabbit' => $promo_form['pricerabbit'],
                    'gp_rabbit' => $promo_form['gp_rabbit'],
                    'priceqr' => $promo_form['priceqr'],
                    'gp_qr' => $promo_form['gp_qr'],
                    'pricesp1' => $promo_form['pricesp1'],
                    'gp_sp1' => $promo_form['gp_sp1'],
                    'pricesp2' => $promo_form['pricesp2'],
                    'gp_sp2' => $promo_form['gp_sp2'],
                    'pricesp3' => $promo_form['pricesp3'],
                    'gp_sp3' => $promo_form['gp_sp3'],
                    'pricesp4' => $promo_form['pricesp4'],
                    'gp_sp4' => $promo_form['gp_sp4'],
                    'pricesp5' => $promo_form['pricesp5'],
                    'gp_sp5' => $promo_form['gp_sp5'],
                    'priceedc' => $promo_form['priceedc'],
                    'gp_edc' => $promo_form['gp_edc'],
                ]);
            if (isset($insert_data)) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' inserted vendor product promotion: ' . $promo_form['product_id'], [
                    'vendor_id' => $promo_form['vendor_id'],
                    'branch_id' => $promo_form['branch_id'],
                    'product_id' => $promo_form['product_id'],
                    'time_seq' => $time_seq + 1,
                    'action' => 'inserted',
                    'created_at' => now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                return response()->json(['success' => true, 'message' => __('menu.save_is_success')]);
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' failed to insert vendor product promotion: ' . $promo_form['product_id'], [
                    'vendor_id' => $promo_form['vendor_id'],
                    'branch_id' => $promo_form['branch_id'],
                    'product_id' => $promo_form['product_id'],
                    'time_seq' => $time_seq + 1,
                    'action' => 'failed',
                    'created_at' => now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                return response()->json(['success' => false, 'message' => 'faile']);
            }
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to insert vendor product promotion: ' . $promo_form['product_id'], [
                'vendor_id' => $promo_form['vendor_id'],
                'branch_id' => $promo_form['branch_id'],
                'product_id' => $promo_form['product_id'],
                'action' => 'failed',
                'created_at' => now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->error(__('menu.save_is_failed'));
            return redirect()->back();
        }
    }
    public function del_promo($time_seq, $vendor_id, $branch_id)
    {

        $delete_data = DB::table('vendorproductpromotion_info')
            ->where([
                'time_seq' => $time_seq,
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
            ])
            ->delete();
        if ($delete_data) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' deleted vendor product promotion: ' . $time_seq, [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
                'time_seq' => $time_seq,
                'action' => 'deleted',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->success(__('menu.delete_is_success'));
            return redirect()->back();
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete vendor product promotion: ' . $time_seq, [
                'vendor_id' => $vendor_id,
                'branch_id' => $branch_id,
                'time_seq' => $time_seq,
                'action' => 'failed',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->error(__('menu.delete_is_failed'));
            return redirect()->back();
        }
    }

    public function insert_promo_print(Request $request)
    {
        $form = $request->validate([
            'vendor_id' => 'required',
            'product_id' => 'required',
            'start_date' => 'required|date',
            'valid_date' => 'required|date|after_or_equal:start_date',
            'description1' => 'nullable|string|max:255',
            'description2' => 'nullable|string|max:255',
            'barcode' => 'nullable|string|max:255',
            'amount_check' => 'nullable|numeric|min:0',
        ], [
            'vendor_id.required' => __('vendor_product.vendor_id_required'),
            'product_id.required' => __('vendor_product.product_id_required'),
            'start_date.required' => __('vendor_product.start_date_required'),
            'start_date.date' => __('vendor_product.start_date_date'),
            'valid_date.required' => __('vendor_product.valid_date_required'),
            'valid_date.date' => __('vendor_product.valid_date_date'),
            'valid_date.after_or_equal' => __('vendor_product.valid_date_after_or_equal'),
            'description1.string' => __('vendor_product.description1_string'),
            'description1.max' => __('vendor_product.description1_max'),
            'description1.regex' => __('vendor_product.description1_regex'),
            'description2.string' => __('vendor_product.description2_string'),
            'description2.max' => __('vendor_product.description2_max'),
            'description2.regex' => __('vendor_product.description2_regex'),
            'barcode.string' => __('vendor_product.barcode_string'),
            'barcode.max' => __('vendor_product.barcode_max'),
            'barcode.regex' => __('vendor_product.barcode_regex'),
            'amount_check.numeric' => __('vendor_product.amount_check_numeric'),
            'amount_check.min' => __('vendor_product.amount_check_min'),
        ]);

        $card_all = [
            'card_barcode' => $request->input('card_barcode'),
            'card_before' => $request->input('card_before'),
            'card_staff' => $request->input('card_staff'),
            'card_member' => $request->input('card_member'),
            'card_rabbit' => $request->input('card_rabbit'),
            'card_qr' => $request->input('card_qr'),
        ];

        $start_date = Carbon::parse($form['start_date'])->format('Y-m-d H:i:s');
        $valid_date = Carbon::parse($form['valid_date'])->format('Y-m-d H:i:s');

        $card_use = implode($card_all);
        // dd($form, $card_use);

        if ($form && $card_all) {
            $promo_seq = DB::table('vendorpromotionprint_info')->max('promo_seq');
            $insert = DB::table('vendorpromotionprint_info')
                ->insert([
                    'vendor_id' => $form['vendor_id'],
                    'product_id' => $form['product_id'],
                    'promo_seq' => $promo_seq + 1,
                    'start_date' => $start_date,
                    'valid_date' => $valid_date,
                    'description1' => $form['description1'],
                    'description2' => $form['description2'],
                    'barcode' => $form['barcode'],
                    'amount_check' => $form['amount_check'],
                    'card_use' => $card_use,
                ]);

            if ($insert) {
                Log::channel('activity')->notice(session('auth_user.user_id') . ' inserted vendor promotion print: ' . $form['product_id'], [
                    'vendor_id' => $form['vendor_id'],
                    'product_id' => $form['product_id'],
                    'promo_seq' => $promo_seq + 1,
                    'action' => 'inserted',
                    'created_at' => now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                return response()->json(['success' => true]);
            } else {
                Log::channel('activity')->error(session('auth_user.user_id') . ' failed to insert vendor promotion print: ' . $form['product_id'], [
                    'vendor_id' => $form['vendor_id'],
                    'product_id' => $form['product_id'],
                    'promo_seq' => $promo_seq + 1,
                    'action' => 'failed',
                    'created_at' => now()->toDateTimeString(),
                    'created_by' => session('auth_user.user_id'),
                ]);
                return response()->json(['success' => false]);
            }
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to insert vendor promotion print: ' . $form['product_id'], [
                'vendor_id' => $form['vendor_id'],
                'product_id' => $form['product_id'],
                'action' => 'failed',
                'created_at' => now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]);
            return response()->json(['success' => false]);
        }
    }

    public function del_component($product_id, $productdetail_id)
    {
        $delete_data = DB::table('productdetail_info')
            ->where([
                'product_id' => $product_id,
                'productdetail_id' => $productdetail_id,
            ])
            ->delete();
        if ($delete_data) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' deleted product component: ' . $productdetail_id, [
                'product_id' => $product_id,
                'productdetail_id' => $productdetail_id,
                'action' => 'deleted',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->success(__('menu.delete_is_success'));
            return redirect()->back();
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete product component: ' . $productdetail_id, [
                'product_id' => $product_id,
                'productdetail_id' => $productdetail_id,
                'action' => 'failed',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->error(__('menu.delete_is_failed'));
            return redirect()->back();
        }
    }
    public function del_promo_print($vendor_id, $promo_seq)
    {
        $delete_data = DB::table('vendorpromotionprint_info')
            ->where([
                'vendor_id' => $vendor_id,
                'promo_seq' => $promo_seq,
            ])
            ->delete();
        if ($delete_data) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' deleted vendor promotion print: ' . $promo_seq, [
                'vendor_id' => $vendor_id,
                'promo_seq' => $promo_seq,
                'action' => 'deleted',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->success(__('menu.delete_is_success'));
            return redirect()->back();
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete vendor promotion print: ' . $promo_seq, [
                'vendor_id' => $vendor_id,
                'promo_seq' => $promo_seq,
                'action' => 'failed',
                'deleted_at' => now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]);
            sweetalert()
                ->error(__('menu.delete_is_failed'));
            return redirect()->back();
        }
    }

    public function update_garantee(Request $request, $vendor_id)
    {
        // $form_garantee = $request->validate([
        //     'min_garantee1' => 'required|numeric',
        //     'min_garantee2' => 'required|numeric',
        //     'min_garantee3' => 'required|numeric',
        //     'dis_garantee' => 'required|numeric',

        // ], [
        //     'min_garantee1.required' => __('vendor_product.min_garantee1_required'),
        //     'min_garantee1.numeric' => __('vendor_product.min_garantee1_numeric'),
        //     'min_garantee2.required' => __('vendor_product.min_garantee2_required'),
        //     'min_garantee2.numeric' => __('vendor_product.min_garantee2_numeric'),
        //     'min_garantee3.required' => __('vendor_product.min_garantee3_required'),
        //     'min_garantee3.numeric' => __('vendor_product.min_garantee3_numeric'),
        //     'dis_garantee.required' => __('vendor_product.dis_garantee_required'),
        //     'dis_garantee.numeric' => __('vendor_product.dis_garantee_numeric'),
        // ]);
        $form_garantee = [
            'min_garantee1' => $request->input('min_garantee1'),
            'min_garantee2' => $request->input('min_garantee2'),
            'min_garantee3' => $request->input('min_garantee3'),
            'dis_garantee' => $request->input('dis_garantee'),
        ];
        // dd($form_garantee);
        $guarantee = [
            'min_garantee1' => $form_garantee['min_garantee1'],
            'min_garantee2' => $form_garantee['min_garantee2'],
            'min_garantee3' => $form_garantee['min_garantee3'],
            'dis_garantee' => $form_garantee['dis_garantee'],
        ];
        $update_guarantee = DB::table('vendor_info')
            ->where([
                'vendor_id' => $vendor_id,
            ])
            ->update($guarantee);
        if ($update_guarantee !== false) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' updated guarantee for vendor product: ' . $vendor_id, [
                'vendor_id' => $vendor_id,
                'action' => 'updated',
                'updated_at' => now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            return response()->json(['success' => true, 'message' => __('menu.edit_is_success')]);
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to update guarantee for vendor product: ' . $vendor_id, [

                'action' => 'failed',
                'updated_at' => now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]);
            return response()->json(['success' => false, 'message' => __('menu.edit_is_failed')]);
        }
    }
}
