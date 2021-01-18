<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\External\InitController;
use App\Http\Controllers\External\CommandController;
use App\Http\Controllers\External\ResetController;

Route::group(
    [           
        'namespace' => 'External',
        'prefix' => 'api/10',
    ], function(){

        Route::post('/reset', [ResetController::class, 'reset'])->name('api:10:reset');
        Route::post('/init', [InitController::class, 'input'])->name('api:10:init');
        Route::post('/command', [CommandController::class, 'input'])->name('api:10:command');

});



