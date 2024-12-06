<?php
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProgramDonasiController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\TestimoniController;

Route::apiResource('pengguna', PenggunaController::class);
Route::apiResource('program-donasi', ProgramDonasiController::class);
Route::apiResource('donasi', DonasiController::class);
Route::apiResource('testimoni', TestimoniController::class);
