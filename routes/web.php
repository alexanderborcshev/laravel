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

Route::middleware(['auth.basic'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/smslog', function () {
        ob_start();
        echo "<pre>";
        require(storage_path('logs/') . "sms.log");
        return ob_get_clean();
    });
});
