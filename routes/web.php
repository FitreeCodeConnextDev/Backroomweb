<?php

use App\Http\Controllers\api\UnitTest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CardTypeController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ImportCotroller;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentGroupController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\ProductSapController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\PromotionCardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorProductController;
use App\Http\Controllers\VendorPromoController;
use App\Http\Controllers\VendorTypeController;
use Illuminate\Support\Facades\Route;
use Jaspersoft\Client\Client;
use Jaspersoft\Service\Criteria\RepositorySearchCriteria;

// Route::get('/', function () {
//     return view('login');
// });
Route::get('/welindex', function () {
        return view('welindex');
});
Route::get('/unit-test-Coupon', [UnitTest::class, 'CouponTest']);
Route::get('/User-Test', [UnitTest::class, 'index']);
Route::get('/checkPermiss-Test', [UnitTest::class, 'checkPermiss']);
Route::get('/dailyBackup-chart', [UnitTest::class, 'chartDailyBackup']);


Route::middleware('guest_root')->group(function () {
        Route::get('/', [AuthController::class, 'index']);
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth_user'])->group(function () {


        Route::get('/checkPermiss', [AuthController::class, 'checkPermiss'])->name('checkPermiss');

        Route::resource('/vendor-page', VendorController::class);
        Route::post('/vendor_user', [VendorController::class, 'vendor_user'])->name('vendor_user');
        Route::put('/vendor_user_delete/{vendor_id}/{user_id}', [VendorController::class, 'vendor_user_delete'])->name('vendor_user_delete');

        Route::put('vendor_funtion/{id}', [VendorController::class, 'vendor_function_update'])->name('vendor_function_update');
        Route::put('/vendor_promo_dis/{id}', [VendorController::class, 'vendor_promo_dis'])->name('vendor_promo_dis');
        Route::put('/vendor_rabbit/{id}', [VendorController::class, 'vendor_rabbit_update'])->name('vendor_rabbit');
        Route::post('/vendor_gp_insert', [VendorController::class, 'vendor_gp_insert'])->name('vendor_gp_insert');
        Route::put('/vendor_gp_del/{vendor_id}/{gp_seq}/', [VendorController::class, 'vendor_gp_del'])->name('vendor_gp_del');
        Route::put('/vendor_invoice_update/{id}', [VendorController::class, 'vendor_invoice_update'])->name('vendor_invoice_update');
        route::put('/vendor_linepay/{id}', [VendorController::class, 'vendor_linepay_update'])->name('vendor_linepay');

        Route::resource('vendor-product', VendorProductController::class);
        Route::post('/vendor-product/insert-component', [VendorProductController::class, 'insert_product_component'])->name('insert_product_component');
        Route::put('/vendor-product/{product_seq}/{vendor_id}/{branch_id}', [VendorProductController::class, 'destroy_product'])->name('vendor-product.destroy_product');
        Route::post('/vendor-product-promotion-insert', [VendorProductController::class, 'insert_promo'])->name('vendor_promotion_insert');
        Route::put('/vendorproduct-delete-promotion/{time_seq}/{vendor_id}/{branch_id}', [VendorProductController::class, 'del_promo'])->name('vendorproduct_promotion_delete');
        Route::post('/vendor-product-promotion-print', [VendorProductController::class, 'insert_promo_print'])->name('insert_promo_print');
        Route::put('/vendor-product-promotion-print-del/{vendor_id}/{promo_seq}', [VendorProductController::class, 'del_promo_print'])->name('del_promo_print');
        Route::put('/vendor-product-del-component/{vendor_id}/{productdetail_id}', [VendorProductController::class, 'del_component'])->name('del_component');

        Route::put('/vendor-product-update-garantee/{vendor_id}', [VendorProductController::class, 'update_garantee'])->name('vendor_product_update_garantee');


        Route::get('/get-product-details/{product_id}', [VendorProductController::class, 'getProductDetails']);


        Route::resource('/member', MemberController::class);
        Route::resource('/users', UsersController::class,);
        Route::resource('/terminal', TerminalController::class,);
        Route::resource('/products', ProductController::class,);
        Route::resource('/products-groups', ProductGroupController::class,);
        Route::resource('/product-units', ProductUnitController::class,);
        Route::resource('/product-sap', ProductSapController::class,);
        Route::resource('/payment-group', PaymentGroupController::class);
        Route::resource('/payment_type', PaymentTypeController::class);
        Route::resource('/vendor-type', VendorTypeController::class);
        Route::resource('/vendor-promotion', VendorPromoController::class);
        Route::resource('/branch', BranchController::class);
        route::resource('/card-promotion', PromotionCardController::class);
        Route::post('/card-promotion_print_add/{id}', [PromotionCardController::class, 'store_print'])->name('card_promotion_print');
        Route::resource('/card-type', CardTypeController::class);
        Route::resource('/staff', StaffController::class);
        Route::resource('/coupons', CouponController::class);
        Route::post('/coupons/coupon_detail_insert', [CouponController::class, 'coupon_detail_insert'])->name('coupon_detail_insert');

        Route::put('/coupons/coupon_detail_destroy/{coupon_id}/{coupon_no}', [CouponController::class, 'coupon_detail_destroy'])->name('coupon_detail_destroy');
        Route::put('/coupons/coupon_detail_lock/{coupon_no}', [CouponController::class, 'coupon_detail_lock'])->name('coupon_detail_lock');
        Route::put('/coupons/coupon_lockall/{coupon_id}', [CouponController::class, 'coupon_lockall'])->name('coupon_lockall');

        Route::get('/daily-charts', [ChartController::class, 'chartDaily'])->name('chart_daily');
        Route::get('/daily-backup-charts', [ChartController::class, 'chartDailyBackup'])->name('daily-backup-charts');

        Route::post('/show-dailybackupchart', [ChartController::class, 'showDailyChartBackup'])->name('daily-backup-showdailybackupchart');

        Route::resource('/session-main', SessionController::class);

        Route::get('/import-product', [ImportCotroller::class, 'import_product'])->name('import.product');
        Route::post('/preview-csv', [ImportCotroller::class, 'import_product_preview'])->name('import.preview');

        Route::post('/import-product-save', [ImportCotroller::class, 'import_product_save'])->name('import.product.save');

        Route::get('/import-vendorproduct', [ImportCotroller::class, 'import_vendorproduct'])->name('import.vendorproduct');
        // Route::post('/import-vendor-save', [ImportCotroller::class, 'import_vendor_save'])->name('import.vendor.save');
        Route::post('/import-vendorproduct-preview', [ImportCotroller::class, 'import_vendorproduct_preview'])->name('import.vendorproduct.preview');
        Route::post('/import-vendorproduct-save', [ImportCotroller::class, 'import_vendorproduct_save'])->name('import.vendorproduct.save');

        Route::get('/import-vendor', [ImportCotroller::class, 'import_vendor'])->name('import.vendors');
        Route::post('/import-vendor-preview', [ImportCotroller::class, 'import_vendor_preview'])->name('import.vendors.preview');
        Route::post('/import-vendor-save', [ImportCotroller::class, 'import_vendor_save'])->name('import.vendors.save');

        Route::get('/import-user', [ImportCotroller::class, 'import_user'])->name('import.user');
        Route::post('/import-user-preview', [ImportCotroller::class, 'import_user_preview'])->name('import.user.preview');
        Route::post('/import-user-save', [ImportCotroller::class, 'import_user_save'])->name('import.user.save');

        Route::get('/index-report', [ReportController::class, 'index'])->name('report.index');
        Route::get('/report-testReport', [ReportController::class, 'testReport'])->name('report.testReport');

        Route::get('/report-rpt_sum_daily', [ReportController::class, 'sum_daily_rpt'])->name('rpt_sum_daily');
        Route::post('/report-gen_rpt_sum_daily', [ReportController::class, 'gen_sum_daily_rpt'])->name('gen_rpt_sum_daily');
        Route::get('/report-rpt_sum_debt', [ReportController::class, 'sum_debt_rpt'])->name('rpt_sum_debt_daily');
        Route::post('/report-gen_rpt_sum_debt', [ReportController::class, 'gen_sum_debt_rpt'])->name('gen_rpt_sum_debt');

        Route::get('/jasper-test', function () {
                $serverUrl = env('JASPER_URL');
                $username  = env('JASPER_USER');
                $password  = env('JASPER_PASSWORD');

                try {
                        $client = new Client($serverUrl, $username, $password);

                        // สร้าง criteria เบื้องต้นเพื่อทดสอบ connection
                        $criteria = new RepositorySearchCriteria([
                                'folderUri'    => '/backroomweb',          // root folder
                                'resourceType' => 'reportUnit',
                                'limit'        => 1             // แค่ 1 เพื่อทดสอบ
                        ]);

                        $client->repositoryService()->searchResources($criteria);

                        return response()->json([
                                'connected' => true,
                                'message'   => '✅ Connect Success',
                                'serverUrl' => $serverUrl,
                                'username'  => $username,
                        ]);
                } catch (\Exception $e) {
                        return response()->json([
                                'connected' => false,
                                'message' => '❌ Connection failed',
                                'error' => $e->getTraceAsString(),
                                'serverUrl' => $serverUrl,
                                'username' => $username,
                        ]);
                }
        });
});
