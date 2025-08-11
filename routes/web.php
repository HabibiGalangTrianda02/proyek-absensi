<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute Halaman Utama
Route::get('/', [PublicController::class, 'index'])->name('home');

// Rute untuk Peserta Rapat (Publik)
Route::get('/absen/{meeting:slug}', [AttendanceController::class, 'create'])->name('attendance.create');
Route::post('/absen', [AttendanceController::class, 'store'])->name('attendance.store');


// Rute untuk Admin (Perlu Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [MeetingController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/meetings/{meeting}/download-pdf', [MeetingController::class, 'downloadPdf'])->name('meetings.download');

    Route::resource('meetings', MeetingController::class);
});

require __DIR__.'/auth.php';