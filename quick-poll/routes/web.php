<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

Route::get('/', function () {
    return view('index')->name('index');
});

Route::get('/polls', [PollController::class, 'index'])->name('polls.index');
Route::get('/polls/{slug}/result', [PollController::class, 'result'])->name('polls.result');
Route::post('/polls/redirect', [PollController::class, 'redirect'])->name('polls.redirect');
Route::get('/polls/{slug}', [PollController::class, 'show'])->name('polls.show');
Route::post('/polls/{slug}/vote', [PollController::class, 'vote'])->name('polls.vote');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::get('/create-poll', [AdminController::class, 'create'])->name('create.poll');
    Route::post('/store', [AdminController::class, 'store'])->name('polls.store');

    Route::get('/polls/{slug}/admin', [AdminController::class, 'viewAdmin'])->name('polls.admin');
    Route::get('/polls/{slug}/edit', [AdminController::class, 'edit'])->name('polls.edit');
    Route::post('/polls/{slug}/update', [AdminController::class, 'update'])->name('polls.update');
    Route::post('/polls/{slug}/destroy', [AdminController::class, 'destroy'])->name('polls.destroy');
});

require __DIR__ . '/auth.php';


