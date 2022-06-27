<?php

use App\Http\Controllers\PollingController;
use App\Http\Controllers\VoteController;
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

Route::prefix('pollings')->group(function () {

    Route::get('/', [PollingController::class, 'index']);
    Route::get('/search/{query}', [PollingController::class, 'search']);
    Route::get('/polling/{polling}', [PollingController::class, 'show']);
    Route::get('/polling/result/{polling}', [PollingController::class, 'showresult']);

    Route::middleware('api.auth.basic')->group(function () {
        Route::post('/new', [PollingController::class, 'store']);
        Route::delete('/delete/{polling}', [PollingController::class, 'destroy']);
        Route::post('/vote', [VoteController::class, 'store']);
    });
});
