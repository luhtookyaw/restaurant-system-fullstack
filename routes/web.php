<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrdersController;

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

Route::get('/', [OrdersController::class, 'index'])->name('order.form');
Route::post('/order_submit', [OrdersController::class, 'submit'])->name('order.submit');
Route::get('/order_serve/{order}', [OrdersController::class, 'serve'])->name('order.serve');

Route::get('/dashboard', [KitchenController::class, 'index'])->name('dashboard');
Route::post('/dashboard', [KitchenController::class, 'store'])->name('dashboard.store');
Route::get('/dashboard/{dish}/edit', [KitchenController::class, 'edit'])->name('dashboard.edit');
Route::post('/dashboard/{dish}', [KitchenController::class, 'update'])->name('dashboard.update');
Route::delete('/dashboard/{dish}', [KitchenController::class, 'destroy'])->name('dashboard.delete');



require __DIR__.'/auth.php';

Route::get('/dashboard/orders', [KitchenController::class, 'order'])->name('dashboard.order');
Route::get('/dashboard/orders/{order}/approve', [KitchenController::class, 'approve'])->name('dashboard.order.approve');
Route::get('/dashboard/orders/{order}/cancel', [KitchenController::class, 'cancel'])->name('dashboard.order.cancel');
Route::get('/dashboard/orders/{order}/ready', [KitchenController::class, 'ready'])->name('dashboard.order.ready');

