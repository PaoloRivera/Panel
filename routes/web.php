<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TransparenciaController;
use App\Http\Controllers\DocenteController;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------------------------------------- 
| Web Routes 
|-------------------------------------------------------------------------- 
| 
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider and all of them will 
| be assigned to the "web" middleware group. Make something great! 
| 
*/

Route::get('/{any}', [AppController::class, 'index'])->where('any', '.*');

// Rutas para los controladores CRUD
Route::resource('slider', SliderController::class);
Route::resource('transparencia', TransparenciaController::class);
Route::resource('docente', DocenteController::class);
