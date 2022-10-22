<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/sms', function () {
    return [];
});


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::any('/sms', [App\Http\Controllers\SMSController::class, 'index'])->name('sms.index');
Route::any('/alert', [App\Http\Controllers\AlertController::class, 'index'])->name('alert.index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/api/alerts', [App\Http\Controllers\AirTableController::class, 'index'])->name('airtable.index');
Route::get('/api/types', [App\Http\Controllers\AirTableController::class, 'types'])->name('airtable.types');
