<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\UserController;

Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    Route::get('', [UserController::class, 'get_all'])->name('api.users');
    Route::get('', [UserController::class, 'get_all'])->name('api.users');
    Route::post('',[UserController::class, 'store'])->name('api.users.store');
    Route::put('/{id}',[UserController::class, 'update'])->name('api.users.update');
    Route::delete('/{id}',[UserController::class, 'destroy'])->name('api.users.destroy');
    Route::post('insert_batch', [UserController::class, 'insert_batch'])->name('api.users.insert_batch');
});

// api auth
Route::post('login', [LoginController::class, 'login'])->name('api.login');