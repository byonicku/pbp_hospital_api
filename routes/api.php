<?php

use App\Http\Controllers\DaftarPeriksaController;
use App\Http\Controllers\UserController;
use App\Models\DaftarPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('user', UserController::class);
Route::post('user/login', [UserController::class, 'login'])->name('login'); // untuk login
Route::post('user/updatePass', [UserController::class, 'updatePass'])->name('updatePass');
Route::post('user/updatePfp', [UserController::class, 'updatePfp'])->name('updatePfp');

Route::apiResource('daftar_periksa', DaftarPeriksaController::class);
Route::post('daftar_periksa/updateStatus', [DaftarPeriksaController::class, 'updateStatus'])->name('updateStatus');
Route::post('updateRatingUlasan', [DaftarPeriksaController::class,'updateRatingUlasan'])->name('updateRatingUlasan'); // update rating dan ulasan di id daftar periksa tertentu
