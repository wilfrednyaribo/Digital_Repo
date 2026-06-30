<?php

use App\Http\Controllers\DocumentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (No authentication required)
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicController::class, 'readerPortal'])->name('reader.portal');
Route::get('/library', [PublicController::class, 'readerPortal'])->name('reader.portal');
Route::get('/reports', [PublicController::class, 'reports'])->name('public.reports');
Route::get('documents/{document}/read', [PublicController::class, 'readInline'])->name('documents.read');

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

Route::get('/dashboard', [DocumentController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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
    | Category Routes (CRUD + Management)
    |------------------------------------------------------------------
    */
    Route::controller(CategoryController::class)->group(function () {
        Route::get('categories/manage', 'manage')->name('categories.manage');
        Route::post('categories', 'store')->name('categories.store');
        Route::put('categories/{category}', 'update')->name('categories.update');
        Route::delete('categories/{category}', 'destroy')->name('categories.destroy');
        Route::delete('categories/bulk-destroy', 'bulkDestroy')->name('categories.bulkDestroy');
    });

    /*
    |------------------------------------------------------------------
    | Document Routes (Protected)
    |------------------------------------------------------------------
    */
    Route::controller(DocumentController::class)->group(function () {
        Route::get('documents/manage', 'manage')->name('documents.manage');
        Route::get('documents/create', 'create')->name('documents.create');
        Route::get('documents/{document}/edit', 'edit')->name('documents.edit')->whereNumber('document');
        Route::post('documents', 'store')->name('documents.store');
        Route::put('documents/{document}', 'update')->name('documents.update')->whereNumber('document');
        Route::delete('documents/{document}', 'destroy')->name('documents.destroy')->whereNumber('document');
        Route::delete('documents/bulk-delete', 'bulkDelete')->name('documents.bulk-delete');

        Route::post('/documents/regenerate-cover/{document}', [DocumentController::class, 'regenerateCover'])->name('documents.regenerate.cover');
    });

});

require __DIR__.'/auth.php';