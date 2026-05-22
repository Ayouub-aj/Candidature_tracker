<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\EntretienController;

Route::get('/', function () {
    return view('welcome');
});

// All routes below require the user to be logged in
Route::middleware('auth')->group(function () {

    // Dashboard — two names for the same route
    Route::get('/dashboard', [CandidatureController::class, 'index'])
        ->name('candidatures.index');
    Route::get('/dashboard', [CandidatureController::class, 'index'])
        ->name('dashboard');

    // Candidatures
    Route::resource('candidatures', CandidatureController::class);

    // Extra candidature routes
    Route::get('/candidatures/archives', [CandidatureController::class, 'archives'])
        ->name('candidatures.archives');
    Route::patch('/candidatures/{candidature}/restore', [CandidatureController::class, 'restore'])
        ->name('candidatures.restore');

    // Entretiens
    Route::get('/candidatures/{candidature}/entretiens/create', [EntretienController::class, 'create'])
        ->name('entretiens.create');
    Route::post('/candidatures/{candidature}/entretiens', [EntretienController::class, 'store'])
        ->name('entretiens.store');
    Route::get('/entretiens/{entretien}/edit', [EntretienController::class, 'edit'])
        ->name('entretiens.edit');
    Route::put('/entretiens/{entretien}', [EntretienController::class, 'update'])
        ->name('entretiens.update');
    Route::delete('/entretiens/{entretien}', [EntretienController::class, 'destroy'])
        ->name('entretiens.destroy');

});

require __DIR__.'/auth.php';