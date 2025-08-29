<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReturnItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SizeController;

use App\Http\Controllers\QuotationController;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\ManualPosController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/dashboard', function () {
    return Inertia::location(route('dashboard'));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        //
        if (Gate::allows('hasRole', ['Cashier'])) {
            return redirect()->route('pos.index');
        }

        return Inertia::render('Dashboard');

    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::post('suppliers/{supplier}', [SupplierController::class, 'update']);
    Route::post('products/{product}', [ProductController::class, 'update']);
    Route::post('products-variant', [ProductController::class, 'productVariantStore'])->name('productVariant');

    Route::post('products-size', [ProductController::class, 'sizeStore'])->name('productSize');


    // Route::resource('company-info', CompanyInfoController::class)->name('companyInfo.index');
    Route::get('/company-info', [CompanyInfoController::class, 'index'])->name('companyInfo.index');
    Route::post('/company-info/{companyInfo}', [CompanyInfoController::class, 'update'])->name('companyInfo.update');


    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos', [PosController::class, 'getProduct'])->name('pos.getProduct');
    Route::post('/get-coupon', [PosController::class, 'getCoupon'])->name('pos.getCoupon');
    Route::post('/pos/submit', [PosController::class, 'submit'])->name('pos.checkout');
    Route::resource('payment', PaymentController::class);
    Route::resource('reports', ReportController::class);
    Route::get('/batch-management/search', [ReportController::class, 'searchByCode']);
    Route::resource('customers', CustomerController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('transactionHistory', TransactionHistoryController::class );
    Route::post('/transactions/delete', [TransactionHistoryController::class, 'destroy'])->name('transactions.delete');
    Route::resource('stock-transition', StockTransactionController::class); 
    Route::resource('manualpos', ManualPosController::class);



    Route::resource('/quotation', QuotationController::class);
    Route::post('/api/save-quotation', [QuotationController::class, 'saveQuotationPdf']);






    // Route::get('/stock-transition', [PosController::class, 'index'])->name('pos.index');
    // Route::post('/stock-transition', [PosController::class, 'getProduct'])->name('pos.getProduct');


    Route::resource('return-bill', ReturnItemController::class);


    

    Route::post('/api/products', [ProductController::class, 'fetchProducts']);
    Route::post('/api/sale/items', [ReturnItemController::class, 'fetchSaleItems'])->name('sale.items');


});

Route::get('/barcode/{id}', [CategoryController::class, 'showBarcode']);
