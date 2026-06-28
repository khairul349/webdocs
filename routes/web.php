<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\TypingController;
use App\Http\Controllers\SharedDocumentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get(
    '/shared/{token}',
    [SharedDocumentController::class, 'show']
)->name('documents.shared');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('documents.index');
    })->name('dashboard');

    Route::get(
        '/documents',
        [DocumentController::class, 'index']
    )->name('documents.index');

    Route::post(
    '/documents/{document}/realtime',
    [DocumentController::class, 'realtime']
)->name('documents.realtime');

    Route::post(
        '/documents',
        [DocumentController::class, 'store']
    )->name('documents.store');

    Route::post(
    '/documents/{document}/invite',
    [DocumentController::class, 'invite']
)->name('documents.invite');

    Route::get(
        '/documents/{document}',
        [DocumentController::class, 'show']
    )->name('documents.show');

    Route::put(
        '/documents/{document}',
        [DocumentController::class, 'update']
    )->name('documents.update');

    Route::delete(
        '/documents/{document}',
        [DocumentController::class, 'destroy']
    )->name('documents.destroy');

    Route::get(
    '/documents/{document}/history',
    [DocumentController::class, 'history']
)->name('documents.history');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

        Route::post('/documents/{document}/typing',[TypingController::class, 'typing']
)->name('documents.typing');
});

require __DIR__.'/auth.php';