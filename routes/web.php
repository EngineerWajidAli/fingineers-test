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

Route::get('/inventory', [App\Http\Controllers\Api\InventoryController::class, 'index'])->name('inventory.index');
Route::patch('/inventory/{id}', [App\Http\Controllers\Api\InventoryController::class, 'update'])->name('inventory.update');
Route::post('/inventory', [App\Http\Controllers\Api\InventoryController::class, 'store'])->name('inventory.store');

Route::get('/pricing', [App\Http\Controllers\Api\PricingController::class, 'index'])->name('pricing.index');
Route::post('/pricing', [App\Http\Controllers\Api\PricingController::class, 'store'])->name('pricing.store');

Route::get('/transactions', [App\Http\Controllers\Api\TransactionController::class, 'index'])->name('transactions.index');
Route::post('/transactions', [App\Http\Controllers\Api\TransactionController::class, 'store'])->name('transactions.store');

Route::get('/audit-logs', [App\Http\Controllers\Api\AuditLogController::class, 'index'])->name('audit_logs.index');

Route::resource('products', App\Http\Controllers\Api\ProductController::class);