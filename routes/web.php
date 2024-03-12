<?php

use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;
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
    Route::get('/index', [AlternativeController::class, 'index'])->name('alternatif.index');
    Route::get('/create', [AlternativeController::class, 'create'])->name('alternatif.create');
    Route::post('/store', [AlternativeController::class, 'store'])->name('alternatif.store');
    Route::get('/edit/{id}', [AlternativeController::class, 'edit'])->name('alternatif.edit');
    Route::put('/update', [AlternativeController::class, 'update'])->name('alternatif.update');
    Route::delete('/delete/{id}', [AlternativeController::class, 'destroy'])->name('alternatif.delete');
});
Route::prefix('kriteria')->group(function () {
    Route::get('/index', [CriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/create', [CriteriaController::class, 'create'])->name('kriteria.create');
    Route::post('/store', [CriteriaController::class, 'store'])->name('kriteria.store');
    Route::get('/edit/{id}', [CriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/update', [CriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/delete/{id}', [CriteriaController::class, 'destroy'])->name('kriteria.delete');
});
