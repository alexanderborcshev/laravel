<?php

use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\OfferController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResources([
    'category' => CategoryController::class,
    'offer' => OfferController::class,
]);
Route::post('/offer/order', [OfferController::class, 'order']);
