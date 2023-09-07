<?php

use App\Http\Controllers\Api\ApiGrocerController;
use App\Http\Controllers\GrocerController;
use App\Http\Controllers\StoreController;
use App\Http\Livewire\Country;
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

Route::get('/', function () {
    return view('layout');
});

Route::resource('store', StoreController::class);
Route::resource('grocer', GrocerController::class);
Route::get('paises', Country::class)->name('paises');

Route::get('login', [ApiGrocerController::class, 'loginResp'])->name('login');

