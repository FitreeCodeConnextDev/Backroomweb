<?php

use App\Http\Controllers\api\UnitTest;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CardTypeController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ExpenseVendorController;
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
use App\Http\Controllers\ReportItemController;
use App\Http\Controllers\ReportPaymentController;
use App\Http\Controllers\ReportVendorController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StockController;
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

        Route::get('/vendor-page/{vendor_id}/{pages_search}', [VendorProductController::class, 'vendor_product_info_search'])->name('vendor_product_info_search');
        Route::get('/vendor-page/{vendor_id}', [VendorProductController::class, 'vendor_product_info_search_show'])->name('vendor_product_info_search_show');

        Route::post('/vendor-product-cloneproduct', [VendorProductController::class, 'clone_product'])->name('vendor_product_clone_product');


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

        Route::get('/daily-charts', [ChartController::class, 'chartDaily'])->name('charts.daily');
        Route::get('/daily-backup-charts', [ChartController::class, 'chartDailyBackup'])->name('charts.backupdaily');

        Route::post('/show-dailybackupchart', [ChartController::class, 'showDailyChartBackup'])->name('charts.showdailybackupchart');

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
        Route::post('/report-toReportName', [ReportController::class, 'toReportName'])->name('report.getReportName');

        Route::get('/report-gen_rpt_sum_daily/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_sum_daily_rpt'])->name('rpt_sum_daily');
        Route::get('/report-gen_rpt_sum_debt/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_sum_debt_rpt'])->name('rpt_sum_debt_daily');
        Route::get('/report-gen_rpt_sum_cashier_daily/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_sum_cashier_daily'])->name('rpt_sum_cashier_daily');
        Route::get('/report-gen_rpt_sum_vendor_daily/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_sum_vendor_daily'])->name('rpt_sum_vendor_daily');

        Route::get('/report-gen_rpt_sum_use_card_daily/{start_date}/{end_date}/{type_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_sum_use_card_daily'])->name('rpt_sum_use_card_daily');
        Route::get('/report-gen_rpt_sum_refund_card_daily/{start_date}/{end_date}/{type_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_sum_refund_card_daily'])->name('rpt_sum_refund_card_daily');
        Route::get('/report-gen_rpt_sum_balance_advancecard_daily/{start_date}/{end_date}/{type_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_sum_balance_advancecard_daily'])->name('rpt_sum_balance_advancecard_daily');


        Route::get('/report-gen_rpt_invoicevendor_daily/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_invoicevendor_daily'])->name('rpt_invoicevendor_daily');
        Route::get('/report-gen_rpt_sum_cardnotreturn/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_sum_cardnotreturn'])->name('rpt_sum_cardnotreturn');

        Route::get('/report-gen_rpt_cardexpire/{start_date}/{end_date}/{type_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_cardexpire'])->name('rpt_cardexpire');
        Route::get('/report-gen_rpt_stockcard/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_stockcard'])->name('rpt_stockcard');
        Route::get('/report-rpt_sum_promotioncard_daily/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_sum_promotioncard_daily'])->name('rpt_sum_promotioncard_daily');
        Route::get('/report-gen_rpt_sum_expense_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportController::class, 'gen_rpt_sum_expense_vendor'])->name('rpt_sum_expense_vendor');

        Route::get('/report-checkConnection', [ReportController::class, 'checkConnection'])->name('report.checkConnection');
        Route::get('/reportnameclient', [ReportController::class, 'test_report_client'])->name('report.test_report_client');

        Route::get('/report-vendor', [ReportVendorController::class, 'index'])->name('report.vendor');
        Route::post('/report-generateVendorReport', [ReportVendorController::class, 'generateVendorReport'])->name('report.generateVendorReport');
        Route::get('/report-gen_rpt_sum_salecard_by_vendor/{format}/{start_date}/{end_date}', [ReportVendorController::class, 'gen_rpt_sum_salecard_by_vendor'])->name('rpt_sum_salecard_by_vendor');
        Route::get('/report-gen_rpt_sum_salecard_by_groupvendor/{format}/{start_date}/{end_date}', [ReportVendorController::class, 'gen_rpt_sum_salecard_by_groupvendor'])->name('rpt_sum_salecard_by_groupvendor');
        Route::get('/report-gen_rpt_sum_salecard_by_typeofcard/{format}/{start_date}/{end_date}', [ReportVendorController::class, 'gen_rpt_sum_salecard_by_typeofcard'])->name('rpt_sum_salecard_by_typeofcard');
        Route::get('/report-gen_rpt_sum_salecard_by_refcode/{format}/{start_date}/{end_date}', [ReportVendorController::class, 'gen_rpt_sum_salecard_by_refcode'])->name('rpt_sum_salecard_by_refcode');
        Route::get('/report-gen_rpt_sum_salecard_by_payment/{format}/{start_date}/{end_date}', [ReportVendorController::class, 'gen_rpt_sum_salecard_by_payment'])->name('rpt_sum_salecard_by_payment');

        Route::get('/report-item', [ReportItemController::class, 'index'])->name('report.item');
        Route::post('/report-toReportItem', [ReportItemController::class, 'toReportItem'])->name('report.toReportItem');
        Route::get('/report-gen_rpt_sum_item_by_product/{start_date}/{end_date}/{format}/{report_name}', [ReportItemController::class, 'gen_rpt_sum_item_by_product'])->name('rpt_sum_item_by_product');
        Route::get('/report-rpt_sum_item_by_groupproduct/{start_date}/{end_date}/{format}/{report_name}', [ReportItemController::class, 'gen_rpt_sum_item_by_groupproduct'])->name('rpt_sum_item_by_groupproduct');
        Route::get('/report-gen_rpt_sum_item_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportItemController::class, 'gen_rpt_sum_item_by_vendor'])->name('rpt_sum_item_by_vendor');
        Route::get('/report-gen_rpt_sum_item_by_groupvendor/{start_date}/{end_date}/{format}/{report_name}', [ReportItemController::class, 'gen_rpt_sum_item_by_groupvendor'])->name('rpt_sum_item_by_groupvendor');
        Route::get('/report-gen_rpt_stock_by_vendor_product/{start_date}/{end_date}/{format}/{report_name}', [ReportItemController::class, 'gen_rpt_stock_by_vendor_product'])->name('rpt_stock_by_vendor_product');
        Route::get('/report-gen_rpt_stock_balance_daily/{start_date}/{end_date}/{format}/{report_name}', [ReportItemController::class, 'gen_rpt_stock_balance_daily'])->name('rpt_stock_balance_daily');
        Route::get('/report-gen_rpt_sum_item_by_typevendor/{start_date}/{end_date}/{format}/{report_name}', [ReportItemController::class, 'gen_rpt_sum_item_by_typevendor'])->name('rpt_sum_item_by_typevendor');
        Route::get('/report-gen_rpt_sum_itembest_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportItemController::class, 'gen_rpt_sum_itembest_by_vendor'])->name('rpt_sum_itembest_by_vendor');

        Route::get('/report-payment', [ReportPaymentController::class, 'index'])->name('report.payment');
        Route::post('/report-toReportPayment', [ReportPaymentController::class, 'toReportPayment'])->name('report.toReportPayment');
        Route::get('/report-gen_rpt_sum_use_thaiqr/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_sum_use_thaiqr'])->name('rpt_sum_use_thaiqr');
        Route::get('/report-gen_rpt_sum_use_thaiqr_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_sum_use_thaiqr_by_vendor'])->name('rpt_sum_use_thaiqr_by_vendor');
        Route::get('/report-gen_rpt_detail_use_thaiqr_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_detail_use_thaiqr_by_vendor'])->name('rpt_detail_use_thaiqr_by_vendor');
        Route::get('/report-gen_rpt_sum_use_alipay/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_sum_use_alipay'])->name('rpt_sum_use_alipay');
        Route::get('/report-gen_rpt_sum_use_alipay_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_sum_use_alipay_by_vendor'])->name('rpt_sum_use_alipay_by_vendor');
        Route::get('/report-gen_rpt_detail_use_alipay_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_detail_use_alipay_by_vendor'])->name('rpt_detail_use_alipay_by_vendor');
        Route::get('/report-gen_rpt_sum_use_wechat/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_sum_use_wechat'])->name('rpt_sum_use_wechat');
        Route::get('/report-gen_rpt_sum_use_wechat_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_sum_use_wechat_by_vendor'])->name('rpt_sum_use_wechat_by_vendor');
        Route::get('/report-gen_rpt_detail_use_wechat_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_detail_use_wechat_by_vendor'])->name('rpt_detail_use_wechat_by_vendor');
        Route::get('/report-gen_rpt_sum_use_true/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_sum_use_true'])->name('rpt_sum_use_true');
        Route::get('/report-gen_rpt_sum_use_true_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_sum_use_true_by_vendor'])->name('rpt_sum_use_true_by_vendor');
        Route::get('/report-gen_rpt_detail_use_true_by_vendor/{start_date}/{end_date}/{format}/{report_name}', [ReportPaymentController::class, 'gen_rpt_detail_use_true_by_vendor'])->name('rpt_detail_use_true_by_vendor');

        Route::resource('/stock-info', StockController::class);
        Route::get('/get-product-details-stock/{product_id}', [StockController::class, 'getProductDetailsStock']);
        Route::put('/stock-info-cancel-adjuststock/{txnno}', [StockController::class, 'cancel_adjuststock'])->name('cancel_adjuststock');

        Route::resource('/expense_vendor', ExpenseVendorController::class);
        Route::get('/expense_vendor_other', [ExpenseVendorController::class, 'expensevendor_other'])->name('other.expensevendor_other_index');
        Route::post('/expense_vendor_other_store', [ExpenseVendorController::class, 'store_other'])->name('expensevendor_other_store');
        Route::delete('/expense_vendor_other_destroy/{txnyear}/{txnmonth}/{vendor_id}/{exp_code}', [ExpenseVendorController::class, 'destroy_expensevendor_other'])->name('expensevendor_other_destroy');
        Route::get('/get-expense-details/{exp_code}', [ExpenseVendorController::class, 'fetch_expensevendor_other'])->name('get_expense_details');

        Route::post('/change-password', [UsersController::class, 'changePassword'])->name('change_password');
});
