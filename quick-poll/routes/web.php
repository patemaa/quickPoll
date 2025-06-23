<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

//Route::get('/login', function () {
//    return view('auth/login')
//});
//
//Route::get('/register', function () {
//    return view('auth/register');
//});

//admin olmayan kullanici]

Route::get('/dashboard',  [AdminController::class, 'dashboard'])->name('dashboard')->middleware(['auth', 'verified']);
Route::get('/create-poll', [AdminController::class, 'create'])->name('create.poll')->middleware(['auth', 'verified']);


Route::get('/', function () {
    return view('index');
});
Route::get('/polls', [PollController::class, 'index'])->name('polls.index');
Route::post('/polls/{slug}/vote', [PollController::class, 'vote'])->name('polls.vote');
Route::get('/polls/{slug}/result', [PollController::class, 'result'])->name('polls.result');
Route::post('/polls/redirect', [PollController::class, 'redirect'])->name('polls.redirect');
Route::get('/polls/{slug}', [PollController::class, 'show'])->name('polls.show');


//admin
//Route::post('/store', [AdminController::class, 'store'])->name('polls.store');
//Route::get('/polls/{slug}/admin', [AdminController::class, 'viewAdmin'])->name('polls.admin');
//Route::get('/polls/{slug}/edit', [AdminController::class, 'edit'])->name('polls.edit');
//Route::post('/polls/{slug}/update', [AdminController::class, 'update'])->name('polls.update');
//Route::post('/polls/{slug}/destroy', [AdminController::class, 'destroy'])->name('polls.destroy');



//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
