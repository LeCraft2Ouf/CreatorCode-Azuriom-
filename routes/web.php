<?php

use Azuriom\Plugin\CreatorCodes\Controllers\CreatorCodeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::post('/apply', [CreatorCodeController::class, 'apply'])
        ->middleware('throttle:5,1')
        ->name('apply');
    Route::post('/remove', [CreatorCodeController::class, 'remove'])
        ->middleware('throttle:20,1')
        ->name('remove');
});
