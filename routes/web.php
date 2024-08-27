<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\Register;

Route::get('/', HomePage::class)->name('home');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});
