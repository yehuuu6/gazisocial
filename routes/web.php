<?php

use App\Livewire\HomePage;
use App\Livewire\AdvancedSearch;
use App\Livewire\Docs\Terms\FAQ;
use App\Livewire\Auth\Pages\Login;
use App\Livewire\Auth\Pages\Verify;
use App\Livewire\Docs\Terms\Privacy;
use App\Livewire\Auth\Pages\Register;
use App\Livewire\Post\Pages\ShowPost;
use App\Livewire\User\Pages\EditUser;
use App\Livewire\User\Pages\ShowUser;
use Illuminate\Support\Facades\Route;
use App\Livewire\Docs\Terms\UserTerms;
use App\Livewire\Post\Pages\ListPosts;
use App\Livewire\Faculty\ShowFaculties;
use App\Livewire\Post\Pages\CreatePost;
use App\Livewire\Post\Pages\EditPost;
use App\Livewire\ZalimKasaba\ShowLobby;
use App\Livewire\ZalimKasaba\CreateLobby;
use App\Livewire\ZalimKasaba\LobbiesList;
use App\Livewire\Auth\Pages\ResetPassword;
use App\Livewire\Auth\Pages\ForgotPassword;
use App\Livewire\Docs\AboutUs;
use App\Livewire\Docs\NewAccountInfo;
use App\Livewire\Post\Pages\ListPostsByTag;
use App\Livewire\Games\Pages\GamesList;
use App\Livewire\ZalimKasaba\ZKGuide;

// Auth routes START
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::delete('/logout', [Login::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/email/verify', Verify::class)->middleware('auth')->name('verification.notice');
Route::post('/email/verification-notification', [Verify::class, 'sendVerifyMail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/forgot-password', ForgotPassword::class)->middleware('guest')->name('password.request');

Route::get('/reset-password/{token}', ResetPassword::class)->middleware('guest')->name('password.reset');

// Auth routes END

// DOC routes START

Route::get('/terms-and-conditions', UserTerms::class)->name('terms');

Route::get('/privacy-policy', Privacy::class)->name('privacy');

Route::get('/frequently-asked-questions', FAQ::class)->name('faq');

Route::get('/about-us', AboutUs::class)->name('about');

Route::get('/new-account', NewAccountInfo::class)->name('new-account');

// DOC routes END

Route::get('/', HomePage::class)->name('home');

// Post routes START

Route::get('/p/create', CreatePost::class)->name('posts.create')->middleware('auth', 'verified');
Route::get('/p/{post}/edit', EditPost::class)->name('posts.edit')->middleware('auth', 'verified');
Route::get('/posts/{order?}', ListPosts::class)->name('posts.index');
Route::get('/p/{post}/{slug}/{order?}', ShowPost::class)->name('posts.show');
Route::get('/p/{post}/{slug}/comments/{comment}', ShowPost::class)->name('posts.show.comment');

// Post Routes END

Route::get('/search/{query?}', AdvancedSearch::class)->name('search');

// User routes START

Route::get('/u/{user:username}', ShowUser::class)->name('users.show');
Route::get('/u/{user:username}/comments', ShowUser::class)->name('users.comments');
Route::get('/u/{user:username}/edit', EditUser::class)->name('users.edit')->middleware('auth');

// User routes END

// Notifications routes START

Route::get('/notifications', \App\Livewire\User\Pages\AllNotifications::class)->name('notifications.index')->middleware('auth');

// Notifications routes END

// Faculties routes START

Route::get('/faculties', ShowFaculties::class)->name('faculties')->middleware('can:join,App\Models\Faculty');

// Faculties routes END

// Tags routes START

Route::get('/tags/{tag:slug}/{order?}', ListPostsByTag::class)->name('tags.show');

// Tags routes END

// Games routes START

Route::get('/games', GamesList::class)->name('games.index');

// Games routes END

// Zalim Kasaba routes START

Route::get('/games/zk', ZKGuide::class)->name('games.zk.guide');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/games/zk/lobbies', LobbiesList::class)->name('games.zk.lobbies');
    Route::get('/games/zk/create', CreateLobby::class)->name('games.zk.create');
    Route::get('/games/zk/{lobby:uuid}', ShowLobby::class)->name('games.zk.show');
});

// Zalim Kasaba routes END