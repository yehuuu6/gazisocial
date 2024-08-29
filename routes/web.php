<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\Register;
use App\Livewire\Pages\Auth\Verify;
use App\Livewire\Pages\Posts\ShowPost;
use App\Livewire\Components\Auth\LoginForm;

// Auth routes START
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::delete('/logout', [LoginForm::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/email/verify', Verify::class)->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [Verify::class, 'verifyUser'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [Verify::class, 'sendVerifyMail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Auth routes END

Route::get('/', HomePage::class)->name('home');

// Post routes START

Route::get('/posts/{post:slug}', ShowPost::class)->name('post.show');

// Post Routes END
