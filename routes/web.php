<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\KriteriaController;
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
Route::prefix('kriteria')->group(function () {
    Route::get('/index', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/show/{id}', [KriteriaController::class, 'show']);
    Route::get('/create', [KriteriaController::class, 'create']);
    Route::post('/store', [KriteriaController::class, 'store']);
    Route::get('/edit/{id}', [KriteriaController::class, 'edit']);
    Route::put('/update/{id}', [KriteriaController::class, 'update']);
    Route::delete('/delete/{id}', [KriteriaController::class, 'destroy']);
});
