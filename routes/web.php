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
