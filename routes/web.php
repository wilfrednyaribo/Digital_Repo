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

Route::get('/sys-manage/{command}', function (Request $request, $command) {
    // 1. The Security Key (Change this to something complex!)
    $secretToken = 'SkyTech-Deploy-Key-wBV@1?uM2cL9,NkU'; 
    
    if ($request->query('token') !== $secretToken) {
        abort(403, 'Unauthorized access.');
    }

    // 2. The Whitelist (Only allow safe commands)
    $allowedCommands = [
        'migrate'  => 'migrate --force',       // Force is required in production
        'optimize' => 'optimize:clear',        // Clears all caches
        'cache'    => 'cache:clear',
        'config'   => 'config:clear',
        'view'     => 'view:clear',
    ];

    if (!array_key_exists($command, $allowedCommands)) {
        abort(404, 'Command not allowed.');
    }

    // 3. Execute and Capture Output
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
