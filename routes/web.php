<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PromptCheckController;
use App\Http\Controllers\IncidentController;

Route::get('/', function () {
    return Inertia::render('Welcome', []);
})->name('home');

Route::get('/prompt-check', [PromptCheckController::class, 'create'])->name('prompt-check.create')->middleware(['verified']);
Route::post('/prompt-check', [PromptCheckController::class, 'store'])->name('prompt-check.store')->middleware(['verified']);

Route::get('/incidents', [IncidentController::class, 'index'])->name('incidents.index')->middleware(['verified']);
Route::get('/incidents/{incident}', [IncidentController::class, 'show'])->name('incidents.show')->middleware(['verified']);
Route::post('/incidents/from-check/{promptCheck}', [IncidentController::class, 'storeFromCheck'])->name('incidents.from-check')->middleware(['verified']);
Route::patch('/incidents/{incident}', [IncidentController::class, 'update'])->name('incidents.update')->middleware(['verified']);

require __DIR__.'/settings.php';
