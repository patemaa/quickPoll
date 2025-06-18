<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PollController;

Route::get('/', function () {
    return view('index');
});

//Route::get('/login', function () {
//    return view('auth/login');
//});
//
//Route::get('/register', function () {
//    return view('auth/register');
//});


//Route::get('/', [PollController::class, '']);
Route::get('/create', [PollController::class, 'create']);
Route::post('/store', [PollController::class, 'store'])->name('polls.store');
Route::get('/polls/{slug}', [PollController::class, 'show'])->name('polls.show');
Route::post('/polls/{slug}/vote', [PollController::class, 'vote'])->name('polls.vote');
Route::get('/polls/{slug}/results', [PollController::class, 'results'])->name('polls.results');

Route::post('/polls/redirect', [PollController::class, 'redirect'])->name('polls.redirect');

Route::get('/polls/{slug}/admin', [PollController::class, 'admin'])->name('polls.admin');

Route::get('/polls/{slug}/edit', [PollController::class, 'edit'])->name('polls.edit');
Route::post('/polls/{slug}/update', [PollController::class, 'update'])->name('polls.update');
