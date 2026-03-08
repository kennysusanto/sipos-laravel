<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BillItemController;
use App\Http\Controllers\CashierMenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::get('/unauthorized', [AuthController::class, 'unauthorized'])->name('unauthorized');
Route::get('/not-found', [AuthController::class, 'notFound'])->name('not-found');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/tenants/{tenant}/detail', [TenantController::class, 'detail'])->name('tenants.detail');
        Route::resource('tenants', TenantController::class)->except(['show']);
        Route::resource('menuitems', MenuItemController::class)->parameters(['menuitems' => 'menuitem'])->except(['show']);
    });

    Route::resource('bills', BillController::class)->except(['show']);
    Route::get('/bills/{bill}/detail', [BillController::class, 'detail'])->name('bills.detail');

    Route::get('/bills/{bill}/items/create', [BillItemController::class, 'create'])->name('billitems.create');
    Route::post('/bills/{bill}/items', [BillItemController::class, 'store'])->name('billitems.store');
    Route::get('/billitems/{billitem}/edit', [BillItemController::class, 'edit'])->name('billitems.edit');
    Route::put('/billitems/{billitem}', [BillItemController::class, 'update'])->name('billitems.update');
    Route::delete('/billitems/{billitem}', [BillItemController::class, 'destroy'])->name('billitems.destroy');

    Route::get('/cashiermenu', [CashierMenuController::class, 'index'])->name('cashiermenu.index');
    Route::post('/cashiermenu', [CashierMenuController::class, 'store'])->name('cashiermenu.store');
});
