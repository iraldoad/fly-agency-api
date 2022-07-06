<?php

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

Route::group([
    'middleware' => config('app.use_api_key')
        ? ['auth.apikey']
        : []
], function () {
    Route::apiResources([
        'flights' => \App\Http\Controllers\FlightController::class,

        'tickets' => \App\Http\Controllers\TicketController::class,
    ]);
});
