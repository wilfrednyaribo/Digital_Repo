<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (No login required)
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [DocumentController::class, 'index'])->name('home');

// Public document routes - order matters!
Route::controller(DocumentController::class)->group(function () {
    Route::get('documents', 'index')->name('documents.index');
    Route::get('documents/{document}/download', 'download')->name('documents.download');
    Route::get('documents/{document}', 'show')->name('documents.show')->where('document', '[0-9]+');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Login required)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DocumentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Protected Document Routes (Upload & Delete)
    Route::controller(DocumentController::class)->group(function () {
        Route::get('documents/create', 'create')->name('documents.create');
        Route::post('documents', 'store')->name('documents.store');
        Route::delete('documents/{document}', 'destroy')->name('documents.destroy')->where('document', '[0-9]+');
    });
});

require __DIR__.'/auth.php';