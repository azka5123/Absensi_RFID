<?php

use App\Http\Controllers\Api\ApiAbsenController;
use App\Http\Controllers\Api\ApiWaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/absensi/masuk', [ApiAbsenController::class, 'masuk']);
Route::post('/absensi/keluar', [ApiAbsenController::class, 'keluar']);
Route::post('/absensi/izin', [ApiAbsenController::class, 'izin']);
// Route::post('/absensi/cek-siswa', [ApiAbsenController::class, 'cekSiswa']);

//api wa
Route::get('/wa/send-devices', [ApiWaController::class, 'test']);
Route::get('/wa/get-devices', [ApiWaController::class, 'getDevice']);
Route::get('/wa/delete-devices', [ApiWaController::class, 'deleteDevice']);
Route::get('/wa/get-qrcode', [ApiWaController::class, 'getQrCode']);
Route::get('/wa/send-messages', [ApiWaController::class, 'sendMessages']);
Route::get('/wa/quota', [ApiWaController::class, 'quota']);
