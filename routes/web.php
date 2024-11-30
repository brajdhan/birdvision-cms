<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/customers/trashed/recycle-bin', [CustomerController::class, 'recycleBin'])->name('customers.recycleBin');
    Route::patch('/customers/trashed/{customer}/restore', [CustomerController::class, 'restore'])->name('customers.restore');
    Route::delete('/customers/trashed/{customer}/force-delete', [CustomerController::class, 'forceDelete'])->name('customers.forceDelete');
    
    Route::get('/customers/export-import', [CustomerController::class, 'exportImportCustomers'])->name('customers.export-import');
    Route::get('/customers/export', [CustomerController::class, 'exportCustomers'])->name('customers.export');
    Route::post('/customers/import', [CustomerController::class, 'importCustomers'])->name('customers.import');
    
    Route::resource('customers', CustomerController::class);
    
    Route::get('/sales/trashed/recycle-bin', [SalesController::class, 'recycleBin'])->name('sales.recycleBin');
    Route::patch('/sales/trashed/{customer}/restore', [SalesController::class, 'restore'])->name('sales.restore');
    Route::delete('/sales/trashed/{customer}/force-delete', [SalesController::class, 'forceDelete'])->name('sales.forceDelete');
    
    Route::get('/sales/export-import', [SalesController::class, 'exportImportSales'])->name('sales.export-import');
    Route::get('/sales/export', [SalesController::class, 'exportSales'])->name('sales.export');
    Route::post('/sales/import', [SalesController::class, 'importSales'])->name('sales.import');

    Route::resource('sales', SalesController::class);

    // Root route
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Dashboard route with name
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:sales_manager'])->group(function () {
    Route::resource('customers', CustomerController::class)->except(['destroy']);
    Route::resource('sales', SalesController::class)->except(['destroy']);
});

require __DIR__ . '/auth.php';
