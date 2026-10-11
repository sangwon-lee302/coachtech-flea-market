<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
});
