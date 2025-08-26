<?php

namespace App\Http\Controllers;

use App\Helpers\PermissionHelper;
use Carbon\Carbon;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductUnitController extends Controller
{
    public function index()
    {
        if (!PermissionHelper::checkUserPermission('back', null, 12)) {
            Log::channel('activity')->error(session('auth_user.user_id') . ' Permission Denied: Access Product Unit Page ', [
                'user_id' => session('auth_user.user_id'),
                'action' => 'access',
                'page' => 'Product Unit Page',
                'timestamp' => Carbon::now()->toDateTimeString(),

            ]);
            sweetalert()
                ->error(__('menu.is_permission_denied'));
            return redirect()->back();
        }
        $unit_info = DB::table('unit_info')
            ->where('activeflag', '=', '1')
            ->select('unit_id', 'unit_name')
            ->orderBy('unit_id', 'asc')
            ->get();
        return view('pages.product_units.index', compact('unit_info'));
    }

    public function create()
    {
        if (!PermissionHelper::checkUserPermission('function', 36)) {
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
        return view("pages.product_units.create");
    }

    public function store(Request $request)
    {
        // Validate the input
        $validatedData = $request->validate(
            [
                'unit_id' => 'required|max:2|unique:unit_info,unit_id',
                'unit_name' => 'required|string|max:255',
            ],
            [
                'unit_id.required' => __('menu.unit_id_valid'),
                'unit_id.max' => __('menu.unit_id_max'),
                'unit_id.unique' => __('menu.unit_id_unique'),
                'unit_name.required' => __('menu.unit_name_valid'),
            ]
        );

        $inserted = DB::table('unit_info')->insert([
            'unit_id' => $validatedData['unit_id'],
            'unit_name' => $validatedData['unit_name'],
            'activeflag' => 1,
        ]);
        if ($inserted) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' created a new product unit: ' . $validatedData['unit_name'] . json_encode([
                'unit_id' => $validatedData['unit_id'],
                'unit_name' => $validatedData['unit_name'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.save_is_success'));
            return redirect()->route('product-units.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to create a new product unit: ' . $validatedData['unit_name'] . json_encode([
                'unit_id' => $validatedData['unit_id'],
                'unit_name' => $validatedData['unit_name'],
                'action' => 'create',
                'created_at' => Carbon::now()->toDateTimeString(),
                'created_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.save_is_failed'));
            return redirect()->back();
        }
    }

    public function edit($unit_id)
    {
        if (!PermissionHelper::checkUserPermission('function', 37)) {
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
        $unit_info = DB::table('unit_info')->where('unit_id', $unit_id)->first();
        Log::channel('activity')->info('Product Unit Edit Page', [
            'user_id' => session('auth_user.user_id'),
            'action' => 'edit',
            'product_unit' => $unit_info,
            'page' => 'Product Unit Edit Page',
            'timestamp' => Carbon::now()->toDateTimeString(),
        ]);
        return view('pages.product_units.edit', compact('unit_info'));
    }

    public function update(Request $request, $unit_id)
    {
        $validatedData = $request->validate(
            [
                'unit_name' => 'required|string|max:255',
            ],
            [
                'unit_name.required' => __('menu.unit_name_valid'),
            ]
        );
        $updatedData = DB::table('unit_info')->where('unit_id', $unit_id)
            ->update([
                'unit_name' => $validatedData['unit_name'],
            ]);
        if (isset($updatedData)) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' updated product unit: ' . $unit_id . ' to ' . $validatedData['unit_name'] . json_encode([
                'unit_id' => $unit_id,
                'unit_name' => $validatedData['unit_name'],
                'action' => 'update',
                'update detail' => $validatedData,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.edit_is_success'));
            return redirect()->route('product-units.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to update product unit: ' . $unit_id . ' to ' . $validatedData['unit_name'] . json_encode([
                'unit_id' => $unit_id,
                'unit_name' => $validatedData['unit_name'],
                'action' => 'update',
                'update detail' => $validatedData,
                'updated_at' => Carbon::now()->toDateTimeString(),
                'updated_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.edit_is_failed'));
            return redirect()->route('product-units.edit', $unit_id);
        }
    }

    public function destroy($unit_id)
    {
        if (!PermissionHelper::checkUserPermission('function', 38)) {
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
        // Attempt to delete the unit with the given unit_id
        $deleted = DB::table('unit_info')
            ->where('unit_id', $unit_id)
            ->update([
                'activeflag' => 0,
            ]);

        // Check if the deletion was successful
        if ($deleted) {
            Log::channel('activity')->notice(session('auth_user.user_id') . ' deleted product unit: ' . $unit_id . json_encode([
                'unit_id' => $unit_id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->success(__('menu.delete_is_success'));
            return redirect()->route('product-units.index');
        } else {
            Log::channel('activity')->error(session('auth_user.user_id') . ' failed to delete product unit: ' . $unit_id . json_encode([
                'unit_id' => $unit_id,
                'action' => 'delete',
                'deleted_at' => Carbon::now()->toDateTimeString(),
                'deleted_by' => session('auth_user.user_id'),
            ]));
            flash()
                ->option('position', 'bottom-right')
                ->option('timeout', 3000)
                ->error(__('menu.delete_is_failed'));
            return redirect()->route('product-units.index');
        }
    }
}
