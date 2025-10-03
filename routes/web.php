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
use App\Http\Controllers\PaintController;
use App\Http\Controllers\BaseTypeController;
use App\Http\Controllers\ColorCardController;
use App\Http\Controllers\PaintProductController;
use App\Http\Controllers\ColoranceStockController;
use App\Http\Controllers\MachineRefillController;
use App\Http\Controllers\BaseStockController;
use App\Http\Controllers\PaintOrderController;
use App\Http\Controllers\UnitController;

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
  Route::resource('units', UnitController::class);

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
    Route::resource('transactionHistory', TransactionHistoryController::class);
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

    // Color Bank (view-only)
    Route::get('/paints', [PaintController::class, 'index'])->name('paints.index');

    // create-only endpoints used by the modal
    Route::post('/paints/types', [PaintProductController::class, 'store'])->name('paints.types.store');
    Route::put('/paints/types/{paintProduct}', [PaintProductController::class, 'update'])->name('paints.types.update');
    Route::delete('/paints/types/{paintProduct}', [PaintProductController::class, 'destroy'])->name('paints.types.destroy');
    
    Route::post('/paints/color-cards', [ColorCardController::class, 'store'])->name('paints.color-cards.store');
    Route::put('/paints/color-cards/{colorCard}', [ColorCardController::class, 'update'])->name('paints.color-cards.update');
    Route::delete('/paints/color-cards/{colorCard}', [ColorCardController::class, 'destroy'])->name('paints.color-cards.destroy');
    
    Route::post('/paints/base-types', [BaseTypeController::class, 'store'])->name('paints.base-types.store');
    Route::put('/paints/base-types/{baseType}', [BaseTypeController::class, 'update'])->name('paints.base-types.update');
    Route::delete('/paints/base-types/{baseType}', [BaseTypeController::class, 'destroy'])->name('paints.base-types.destroy');

    // Colorance Stock CRUD for the modal
    Route::get('/paints', [PaintController::class, 'index'])->name('paints.index');
    Route::post('/paints/colorance-stocks', [ColoranceStockController::class, 'store'])
        ->name('paints.colorance-stocks.store');

    Route::put('/paints/colorance-stocks/{coloranceStock}', [ColoranceStockController::class, 'update'])
        ->name('paints.colorance-stocks.update');

    Route::delete('/paints/colorance-stocks/{coloranceStock}', [ColoranceStockController::class, 'destroy'])
        ->name('paints.colorance-stocks.destroy');

    // Mixing (machine refill)
    Route::post('/paints/mixing', [MachineRefillController::class, 'store'])
        ->name('paints.mixing.store');

    Route::get('/paints/orders', [PaintOrderController::class, 'index'])
        ->name('paints.orders.index');

    Route::get('/paints/orders/create', [PaintOrderController::class, 'create'])
        ->name('paints.orders.create');

    Route::post('/paints/orders', [PaintOrderController::class, 'store'])
        ->name('paints.orders.store');
    // routes/web.php
    Route::post('/paints/orders/{order}/pay', [PaintOrderController::class, 'pay'])
        ->name('paints.orders.pay');

    // Base Stock Management Routes
    Route::prefix('base-stocks')->name('base-stocks.')->group(function () {
        Route::get('/', [BaseStockController::class, 'index'])->name('index');
        Route::post('/', [BaseStockController::class, 'store'])->name('store');
        Route::put('/{baseStock}', [BaseStockController::class, 'update'])->name('update');
        Route::delete('/{baseStock}', [BaseStockController::class, 'destroy'])->name('destroy');
        Route::get('/dropdown-data', [BaseStockController::class, 'getDropdownData'])->name('dropdown-data');
        Route::get('/transactions', [BaseStockController::class, 'getTransactions'])->name('transactions');
        Route::get('/transactions/download-pdf', [BaseStockController::class, 'downloadTransactionsPDF'])->name('transactions.download-pdf');
    });




});

Route::get('/barcode/{id}', [CategoryController::class, 'showBarcode']);
