<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (No authentication required)
|--------------------------------------------------------------------------
*/

// Root URL → Login page
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Public document routes (order matters - specific routes first)
Route::controller(DocumentController::class)->group(function () {
    Route::get('documents', 'index')->name('documents.index');
    Route::get('documents/{document}/download', 'download')->name('documents.download');
    Route::get('documents/{document}', 'show')->name('documents.show')->whereNumber('document');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Login required)
|--------------------------------------------------------------------------
*/

// Dashboard
Route::get('/dashboard', [DocumentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// All protected routes
Route::middleware('auth')->group(function () {

    /*
    |------------------------------------------------------------------
    | Profile Routes (Laravel Breeze)
    |------------------------------------------------------------------
    */
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    /*
    |------------------------------------------------------------------
    | Category Routes (CRUD)
    |------------------------------------------------------------------
    */
    Route::controller(CategoryController::class)->group(function () {
        Route::post('categories', 'store')->name('categories.store');
        Route::put('categories/{category}', 'update')->name('categories.update');
        Route::delete('categories/{category}', 'destroy')->name('categories.destroy');
    });

    /*
    |------------------------------------------------------------------
    | Document Routes (Protected)
    |------------------------------------------------------------------
    */
    Route::controller(DocumentController::class)->group(function () {
        // Management views
        Route::get('documents/manage', 'manage')->name('documents.manage');
        Route::get('documents/create', 'create')->name('documents.create');
        Route::get('documents/{document}/edit', 'edit')->name('documents.edit')->whereNumber('document');

        // Store/Update actions
        Route::post('documents', 'store')->name('documents.store');
        Route::put('documents/{document}', 'update')->name('documents.update')->whereNumber('document');

        // Delete actions
        Route::delete('documents/{document}', 'destroy')->name('documents.destroy')->whereNumber('document');
        Route::delete('documents/bulk-delete', 'bulkDelete')->name('documents.bulk-delete');
    });

});

require __DIR__.'/auth.php';