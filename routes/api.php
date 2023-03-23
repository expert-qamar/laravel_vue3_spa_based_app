<?php

use App\Http\Controllers\Api\{
    CarDetailsController,
    CategoiesController
};
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::apiResource('cars-detail', CarDetailsController::class);
    Route::apiResource('categories', CategoiesController::class);

    Route::get('/all-categories', [CarDetailsController::class, 'categories']);
    Route::get('/user', [AuthenticatedSessionController::class, 'index']);
});
