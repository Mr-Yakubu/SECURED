<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncryptionController;

Route::get('/encrypt', [EncryptionController::class, 'showEncryptForm'])->name('encrypt.form');
Route::post('/encrypt', [EncryptionController::class, 'encrypt'])->name('encrypt');
Route::get('/decrypt', [EncryptionController::class, 'showDecryptForm'])->name('decrypt.form');
Route::post('/decrypt', [EncryptionController::class, 'decrypt'])->name('decrypt');
