<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ApiWebController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api_key')->group(function () {
    Route::post('/send-email/dp', [EmailController::class, 'sendEmailDiegoPenaVicente']);
    Route::post('/send-email/olimed', [EmailController::class, 'sendEmailOlimed']);
    Route::post('/send-email/lanonnarose', [EmailController::class, 'sendEmailLaNonnaRose']);


    Route::get('/content-web/all', [ApiWebController::class, 'fetchWebData']);

});