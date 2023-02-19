<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'product'], function () {
    Route::get('/list', [API\ProductController::class, 'index']);
    Route::get('/view/{id}', [API\ProductController::class, 'show']);
    Route::post('/store', [API\ProductController::class, 'store']);
    Route::post('/update/{id}', [API\ProductController::class, 'update']);
    Route::get('/delete/{id}', [API\ProductController::class, 'destroy']);
});

Route::group(['prefix' => 'user'], function () {
    Route::get('/list', [API\UserController::class, 'index']);
    Route::post('/store', [API\UserController::class, 'store']);
});
