<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Payme\UserBalanceController;
use App\Http\Controllers\Api\Payme\OrderController;
use App\Http\Controllers\Api\Click\ClickUserController;
use App\Http\Controllers\Api\Click\ClickOrderController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/**-------------------------Payme-api-routes------------------------*/
Route::post('payme/user', [UserBalanceController::class, 'actionApi']);
Route::post('payme/order', [OrderController::class, 'actionApi']);

/**--------------------------Click-api-routes-----------------------*/
Route::post('/click/user/prepare', [ClickUserController::class, 'actionPrepare']);
Route::post('/click/user/complete', [ClickUserController::class, 'actionComplete']);

Route::post('/click/order/prepare', [ClickOrderController::class, 'actionPrepare']);
Route::post('/click/order/complete', [ClickOrderController::class, 'actionComplete']);
