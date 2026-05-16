<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\RequireLogin;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware([RequireLogin::class])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/my-records/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('my-records.show');
        Route::get('/my-records/{id}/pdf', [MedicalRecordController::class, 'exportPdf'])->name('my-records.pdf');

        Route::middleware(['nurse'])->group(function () {
            Route::get('/medical-records/{id}/pdf', [MedicalRecordController::class, 'exportPdf'])->name('medical-records.pdf');
            Route::resource('students', StudentController::class);
            Route::resource('medical-records', MedicalRecordController::class);
        });
    });
});
