<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes (Placeholder)
|--------------------------------------------------------------------------
|
| These routes are placeholders for authentication.
| Use Laravel Breeze, Jetstream, or Filament for full auth.
|
*/

// Placeholder auth routes - implement with Laravel Breeze/Jetstream
Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
});

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');
