<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConsoleController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\Moderator\BillModeratorController;
use App\Http\Controllers\Api\Moderator\OfferModeratorController;
use App\Http\Controllers\Api\Moderator\OrderModeratorController;
use App\Http\Controllers\Api\Moderator\ProviderModeratorController;
use App\Http\Controllers\Api\Moderator\UserNoteController;
use App\Http\Controllers\Api\Provider\BillProviderController;
use App\Http\Controllers\Api\Provider\ManagerProviderController;
use App\Http\Controllers\Api\Provider\OfferProviderController;
use App\Http\Controllers\Api\Provider\OrderProviderController;
use App\Http\Controllers\Api\CounterController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Public\CategoryController;
use App\Models\Enums\OrderStatusEnum;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'category' => CategoryController::class,
        'order_moderator' => OrderModeratorController::class,
        'user_note' => UserNoteController::class,
    ]);
    Route::post('/file', [FileController::class, 'file']);
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::get('/user/first', [UserController::class, 'first']);
    Route::get('/user/rule', [UserController::class, 'rule']);
    Route::get('/counter', [CounterController::class, 'index']);
    Route::get('/counter/{id}', [CounterController::class, 'index']);

    /**
     * Routes moderator
    */
    Route::get('/provider_moderator', [ProviderModeratorController::class, 'index']);
    Route::get('/provider_moderator/for_offer', [ProviderModeratorController::class, 'forOffer']);
    Route::post('/provider_moderator', [ProviderModeratorController::class, 'store']);
    Route::prefix('provider_moderator/{provider}')->group(function () {
        Route::get('/', [ProviderModeratorController::class, 'show']);
        Route::get('/with_offer', [ProviderModeratorController::class, 'with_offer']);
        Route::put('/', [ProviderModeratorController::class, 'update']);
    });

    Route::get('/offer_moderator', [OfferModeratorController::class, 'index']);
    Route::post('/offer_moderator', [OfferModeratorController::class, 'store']);
    Route::prefix('offer_moderator/{offer}')->group(function () {
        Route::get('/', [OfferModeratorController::class, 'show']);
        Route::put('/', [OfferModeratorController::class, 'update']);
        Route::delete('/', [OfferModeratorController::class, 'delete']);
        Route::put('/publish', [OfferModeratorController::class, 'publish']);
        Route::put('/send_to_provider', [OfferModeratorController::class, 'sendToProvider']);
        Route::put('/pause', [OfferModeratorController::class, 'pause']);
        Route::put('/resume', [OfferModeratorController::class, 'resume']);
    });

    Route::get('/moderator_search', [OrderModeratorController::class, 'search']);
    Route::prefix('orders/')->group(function () {
        Route::get('new', [OrderModeratorController::class, 'newList']);
        Route::get('in_progress', [OrderModeratorController::class, 'inProgressList']);
        Route::get('canceled', [OrderModeratorController::class, 'canceledList']);
    });

    Route::prefix('order/{id}')->group(function () {
        Route::post('accept', [OrderModeratorController::class, 'accept']);
        Route::post('note', [OrderModeratorController::class, 'note']);
        Route::post('verify', [OrderModeratorController::class, 'verify']);
        Route::post(OrderStatusEnum::in_progress->name, [OrderModeratorController::class, OrderStatusEnum::in_progress->name]);
        Route::post(OrderStatusEnum::postpone->name, [OrderModeratorController::class, OrderStatusEnum::postpone->name]);
        Route::post(OrderStatusEnum::canceled->name, [OrderModeratorController::class, OrderStatusEnum::canceled->name]);
        Route::post(OrderStatusEnum::finished->name, [OrderModeratorController::class, OrderStatusEnum::finished->name]);
    });

    Route::get('/bill_moderator', [BillModeratorController::class, 'index']);
    Route::get('/bill_moderator/{bill}', [BillModeratorController::class, 'show']);
    Route::put('/bill_moderator/{id}/payed', [BillModeratorController::class, 'payed']);

    /**
     * Routes partner
     */
    Route::get('/offer_partner', [OfferProviderController::class, 'index']);
    Route::get('/offer_partner/{offer}', [OfferProviderController::class, 'show']);
    Route::put('/offer_partner/{offer}/publish', [OfferProviderController::class, 'publish']);
    Route::put('/offer_partner/{offer}/manager', [OfferProviderController::class, 'manager']);
    Route::get('/offer_partner_menu', [OfferProviderController::class, 'menu']);
    Route::get('/partner_orders/{status}', [OrderProviderController::class, 'index']);
    Route::get('/partner_search', [OrderProviderController::class, 'search']);
    Route::prefix('partner_order/{id}')->group(function () {
        Route::post('accept', [OrderProviderController::class, 'accept']);
        Route::post('note', [OrderProviderController::class, 'note']);
        Route::post(OrderStatusEnum::in_progress->name, [OrderProviderController::class, OrderStatusEnum::in_progress->name]);
        Route::post(OrderStatusEnum::postpone->name, [OrderProviderController::class, OrderStatusEnum::postpone->name]);
        Route::post(OrderStatusEnum::canceled->name, [OrderProviderController::class, OrderStatusEnum::canceled->name]);
        Route::post(OrderStatusEnum::finished->name, [OrderProviderController::class, OrderStatusEnum::finished->name]);
    });
    Route::get('/partner_manager/', [ManagerProviderController::class, 'index']);
    Route::post('/partner_manager/', [ManagerProviderController::class, 'store']);
    Route::put('/partner_manager/{manager}', [ManagerProviderController::class, 'update']);
    Route::post('/partner_manager/{manager}/block', [ManagerProviderController::class, 'block']);

    Route::get('/bill_partner', [BillProviderController::class, 'index']);
    Route::get('/bill_partner/current', [BillProviderController::class, 'currentMonth']);
    Route::get('/bill_partner/{bill}', [BillProviderController::class, 'show']);
    Route::put('/bill_partner/{id}/accept', [BillProviderController::class, 'accept']);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/auth/token', 'login');
    Route::post('/auth/refresh_token', 'refresh_token');
    Route::get('/auth/logout', 'logout')->middleware(['auth:api']);
    Route::get('/auth/clear', 'clear');
    Route::post('/auth/check', 'check');
});
Route::group(['middleware' => 'auth.console'], function () {
    Route::controller(ConsoleController::class)->group(function () {
        Route::get('/console/bill/issue', 'bill_issue');
        Route::get('/console/offers/statistic', 'offers_statistic');
        Route::get('/console/orders/return_to_in_progress', 'return_to_in_progress');
    });
});

