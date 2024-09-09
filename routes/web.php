<?php

use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\Verify;
use App\Livewire\Pages\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Posts\ShowPost;
use App\Livewire\Pages\Users\UserPage;
use App\Livewire\Pages\Posts\CreatePost;
use App\Livewire\Pages\Posts\SearchPost;
use App\Livewire\Pages\Users\SearchUser;
use App\Livewire\Components\Auth\LoginForm;
use App\Livewire\Pages\Categories\ShowPosts;
use App\Livewire\Pages\Faculty\ListFaculties;

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

Route::get('/posts/create', CreatePost::class)->name('post.create')->middleware('auth', 'verified');
Route::get('/posts/{post:slug}', ShowPost::class)->name('post.show');
Route::get('/posts/search/{query}', SearchPost::class)->name('post.search');

// Post Routes END

// User routes START

Route::get('/u/{user:username}', UserPage::class)->name('user.show');
Route::get('/u/search/{query}', SearchUser::class)->name('user.search');

// User routes END

// Faculties routes START

Route::get('/faculties', ListFaculties::class)->name('faculties');

// Faculties routes END

// Categories routes START

Route::get('/categories/{tag:name}', ShowPosts::class)->name('category.show');

// Categories routes END