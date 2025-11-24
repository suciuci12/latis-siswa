<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;

Route::get('/', function () {
    return redirect()->route('siswa.index');
});

Route::middleware('auth')->group(function () {


    Route::get('/dashboard', function () {
        return redirect()->route('siswa.index');
    })->name('dashboard');

    Route::resource('siswa', SiswaController::class);
    Route::get('/siswa-export', [SiswaController::class, 'export'])->name('siswa.export');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
