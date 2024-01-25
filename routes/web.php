<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\BobotController;
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
    return view('dashboard');
})->name('dashboard');
Route::prefix('alternatif')->group(function () {
    Route::get('/index', [AlternatifController::class, 'index'])->name('alternatif.index');
    Route::get('/show/{id}', [AlternatifController::class, 'show']);
    Route::get('/create', [AlternatifController::class, 'create']);
    Route::post('/store', [AlternatifController::class, 'store']);
    Route::get('/edit/{id}', [AlternatifController::class, 'edit']);
    Route::put('/update/{id}', [AlternatifController::class, 'update']);
    Route::delete('/delete/{id}', [AlternatifController::class, 'destroy']);
});
Route::prefix('bobot')->group(function () {
    Route::get('/index', [BobotController::class, 'index'])->name('bobot.index');
    Route::get('/show/{id}', [BobotController::class, 'show']);
    Route::get('/create', [BobotController::class, 'create']);
    Route::post('/store', [BobotController::class, 'store']);
    Route::get('/edit/{id}', [BobotController::class, 'edit']);
    Route::put('/update/{id}', [BobotController::class, 'update']);
    Route::delete('/delete/{id}', [BobotController::class, 'destroy']);
});
