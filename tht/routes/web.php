<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('tickets.index');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tickets', TicketController::class)->except(['edit', 'destroy']);
    Route::post('/tickets/{ticket}/comments', [CommentController::class, 'store'])->name('comments.store');
    
    // Chat Discussion Route
    Route::get('/chats', [App\Http\Controllers\ChatController::class, 'index'])->name('chats.index');
});

require __DIR__.'/auth.php';
