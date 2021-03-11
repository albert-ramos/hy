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


Route::group(
    [           
        'namespace' => 'External',
        'prefix' => '10',
    ], function(){

        Route::get('ping', function(){
            return response('pong');
        })->name('api:10:ping');

        Route::post('reset', [ResetController::class, 'reset'])->name('api:10:reset');
        Route::post('init', [InitController::class, 'input'])->name('api:10:init');
        Route::post('command', [CommandController::class, 'input'])->name('api:10:command');

});

