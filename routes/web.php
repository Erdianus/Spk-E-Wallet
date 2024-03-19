<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\SubCriteriaController;

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
    Route::post('/input/{id}', [AlternativeController::class, 'inputDataAlternatif'])->name('alternatif.input-data');
    Route::post('/update/{id}', [AlternativeController::class, 'updateDataAlternatif'])->name('alternatif.update-data');
    Route::post('/store', [AlternativeController::class, 'store'])->name('alternatif.store');
    Route::get('/edit/{id}', [AlternativeController::class, 'edit'])->name('alternatif.edit');
    Route::put('/update', [AlternativeController::class, 'update'])->name('alternatif.update');
    Route::delete('/delete/{id}', [AlternativeController::class, 'destroy'])->name('alternatif.delete');
});
Route::prefix('kriteria')->group(function () {
    Route::get('/index', [CriteriaController::class, 'index'])->name('kriteria.index');
    Route::post('/store', [CriteriaController::class, 'store'])->name('kriteria.store');
    Route::put('/update', [CriteriaController::class, 'update'])->name('kriteria.update');
    Route::delete('/delete/{id}', [CriteriaController::class, 'destroy'])->name('kriteria.delete');
    Route::prefix('sub-kriteria')->group(function () {
        Route::get('/index/{id}', [SubCriteriaController::class, 'index'])->name('sub-kriteria.index');
        Route::post('/store', [SubCriteriaController::class, 'store'])->name('sub-kriteria.store');
        Route::put('/update', [SubCriteriaController::class, 'update',])->name('sub-kriteria.update');
        Route::delete('/delete/{id}', [SubCriteriaController::class, 'destroy'])->name('sub-kriteria.delete');
    });
});
Route::get('/ahp', [PerhitunganController::class, 'index'])->name('pembobotan.index');
Route::post('/ahp/pembobotan', [PerhitunganController::class, 'weighting'])->name('pembobotan.kriteria');
Route::get('/ahp/pembobotan/check-konsistensi', [PerhitunganController::class, 'checkConsistency'])->name('pembobotan.check');
Route::get('/ahp/hasil', [PerhitunganController::class, 'result'])->name('pembobotan.hasil');
