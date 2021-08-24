<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('GrahamCampbell\Throttle\Http\Middleware\ThrottleMiddleware:10,1')->post('/translate',[\App\Http\Controllers\TranslateController::class,'translate']);

Route::get('/language',[\App\Http\Controllers\TranslateController::class,'language']);
