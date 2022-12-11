<?php

use App\Http\Controllers\BiodataController;
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

Route::get('/', [BiodataController::class,'index'])->name('biodata.index');
Route::get('/biodata/create',[BiodataController::class,'create'])->name('biodata.create');
Route::post('/biodata/store',[BiodataController::class,'store'])->name('biodata.store');
Route::get('/biodata/{id}/edit',[BiodataController::class,'edit'])->name('biodata.edit');
Route::put('/biodata/{id}',[BiodataController::class,'update'])->name('biodata.update');
Route::delete('/biodata/{id}',[BiodataController::class,'destroy'])->name('biodata.destroy');
