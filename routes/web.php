<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function ()
{
    return view('welcome');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function ()
{
    Route::get('/inventory', [App\Http\Controllers\Api\InventoryController::class, 'index'])->name('inventory.index');
    Route::patch('/inventory/{id}', [App\Http\Controllers\Api\InventoryController::class, 'update'])->name('inventory.update');
    Route::post('/inventory', [App\Http\Controllers\Api\InventoryController::class, 'store'])->name('inventory.store');

    Route::resource('products', App\Http\Controllers\Api\ProductController::class);
    Route::resource('pricing', App\Http\Controllers\Api\PricingController::class)->except(['show']);
    Route::get('/audit-logs', [App\Http\Controllers\Api\AuditLogController::class, 'index'])->name('audit_logs.index');
    Route::get('/transactions', [App\Http\Controllers\Api\TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions', [App\Http\Controllers\Api\TransactionController::class, 'store'])->name('transactions.store');
});

Route::middleware(['auth'])->group(function ()
{
    Route::get('/shop', [App\Http\Controllers\Client\ShopController::class, 'index'])->name('shop.index');
    Route::get('/shop/{product}', [App\Http\Controllers\Client\ShopController::class, 'show'])->name('shop.show');
    Route::post('/shop/{product}/buy', [App\Http\Controllers\Client\ShopController::class, 'buy'])->name('shop.buy');
    Route::get('/my-sales', [App\Http\Controllers\Client\ShopController::class, 'sales'])->name('shop.sales');
});