<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

use App\Http\Controllers\PromptCheckController;
use App\Http\Controllers\IncidentController;

Route::get('/', function () {
    return Inertia::render('Welcome', []);
})->name('home');

Route::get('/prompt-check', [PromptCheckController::class, 'create'])->name('prompt-check.create');
Route::post('/prompt-check', [PromptCheckController::class, 'store'])->name('prompt-check.store');

Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index');
Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incidents.show');
Route::post('/incidents/from-check/{promptCheck}', [IncidentController::class, 'storeFromCheck'])->name('incidents.from-check');
Route::patch('/incidents/{incident}', [IncidentController::class, 'update'])->name('incidents.update');

require __DIR__.'/settings.php';
