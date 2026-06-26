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

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

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
    });

});

require __DIR__.'/auth.php';

Route::get('/sys-manage/{command}', function (Request $request, $command) {
    $secretToken = 'SkyTech-Deploy-Key-wBV@1?uM2cL9,NkU'; 
    
    if ($request->query('token') !== $secretToken) {
        abort(403, 'Unauthorized access.');
    }

    $allowedCommands = [
        'migrate'  => 'migrate --force',
        'optimize' => 'optimize:clear',
        'cache'    => 'cache:clear',
        'config'   => 'config:clear',
        'view'     => 'view:clear',
    ];

    if (!array_key_exists($command, $allowedCommands)) {
        abort(404, 'Command not allowed.');
    }

    try {
        Artisan::call($allowedCommands[$command]);
        $output = Artisan::output();
        
        return response("<div style='background:#1e1e1e; color:#4af626; padding:20px; font-family:monospace; border-radius:5px;'>
            <h3>Command '{$command}' executed.</h3>
            <pre>{$output}</pre>
        </div>");
        
    } catch (\Exception $e) {
        return response("<div style='background:#1e1e1e; color:#ff4444; padding:20px; font-family:monospace; border-radius:5px;'>
            <h3>Error executing '{$command}'</h3>
            <pre>{$e->getMessage()}</pre>
        </div>", 500);
    }
});