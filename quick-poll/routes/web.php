<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

//Route::get('/login', function () {
//    return view('auth/login');
//});
//
//Route::get('/register', function () {
//    return view('auth/register');
//});

//admin olmayan kullanici
Route::get('/', function () {
    return view('index');
});
Route::get('/polls', [PollController::class, 'index'])->name('polls.index');
Route::post('/polls/{slug}/vote', [PollController::class, 'vote'])->name('polls.vote');
Route::get('/polls/{slug}/results', [PollController::class, 'results'])->name('polls.results');
Route::post('/polls/redirect', [PollController::class, 'redirect'])->name('polls.redirect');
Route::get('/polls/{slug}', [PollController::class, 'show'])->name('polls.show');


//admin
Route::get('/create', [AdminController::class, 'create']);
Route::post('/store', [AdminController::class, 'store'])->name('polls.store');
Route::get('/polls/{slug}/admin', [AdminController::class, 'admin'])->name('polls.admin');
Route::get('/polls/{slug}/edit', [AdminController::class, 'edit'])->name('polls.edit');
Route::post('/polls/{slug}/update', [AdminController::class, 'update'])->name('polls.update');
Route::post('/polls/{slug}/destroy', [AdminController::class, 'destroy'])->name('polls.destroy');
