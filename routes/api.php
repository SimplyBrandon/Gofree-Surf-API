<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\PlayerController;
use App\Http\Controllers\API\V1\MapController;
use App\Http\Controllers\API\V1\TimeController;

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
    'prefix' => 'v1',
    'as' => 'api',
    'namespace' => 'API\V1'
], function () {
    Route::get('players', [PlayerController::class, 'index']);
    Route::get('players/{steamid}', [PlayerController::class, 'show']);

    Route::get('maps', [MapController::class, 'index']);
    Route::get('maps/{mapname}', [MapController::class, 'show']);

    Route::get('times/{mapname}', [TimeController::class, 'index']);
});
