<?php

use Azuriom\Plugin\CreatorCodes\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group that contains the "admin-access" middleware group.
|
*/

Route::middleware('can:creatorcodes.manage')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/', [AdminController::class, 'store'])->name('store');
    Route::get('/{creator}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{creator}', [AdminController::class, 'update'])->name('update');
    Route::post('/{creator}/toggle', [AdminController::class, 'toggle'])->name('toggle');
    Route::delete('/{creator}', [AdminController::class, 'destroy'])->name('destroy');
});
