<?php

use App\Livewire\Docs\ShowBug;
use App\Livewire\Docs\ReportBug;
use App\Livewire\Docs\Terms\FAQ;
use App\Livewire\Post\Pages\Home;
use App\Livewire\Auth\Pages\Login;
use App\Livewire\Docs\ContactPage;
use App\Livewire\Auth\Pages\Verify;
use App\Livewire\Docs\Terms\Privacy;
use App\Livewire\Auth\Pages\Register;
use App\Livewire\Post\Pages\EditPost;
use App\Livewire\Post\Pages\ShowPost;
use App\Livewire\User\Pages\EditUser;
use Illuminate\Support\Facades\Route;
use App\Livewire\Docs\Terms\UserTerms;
use App\Http\Middleware\CheckAdminRole;
use App\Livewire\Docs\ReportedBugsList;
use App\Livewire\Faculty\ShowFaculties;
use App\Livewire\Post\Pages\CreatePost;
use App\Livewire\User\Pages\SearchUser;
use App\Livewire\Admin\Pages\ShowMessage;
use App\Livewire\Auth\Pages\ResetPassword;
use App\Livewire\Auth\Pages\ForgotPassword;
use App\Livewire\Post\Pages\ShowPostsByTag;
use App\Livewire\Admin\Pages\MessagesIndexer;
use App\Livewire\Docs\DevCenter\Contributors;
use App\Livewire\Docs\DevCenter\ContributionGuide;
use App\Livewire\Post\Pages\ListPosts;

// Auth routes START
Route::middleware('guest')->group(function () {
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::delete('/logout', [Login::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/email/verify', Verify::class)->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [Verify::class, 'verifyUser'])
    ->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', [Verify::class, 'sendVerifyMail'])
    ->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/forgot-password', ForgotPassword::class)->middleware('guest')->name('password.request');

Route::get('/reset-password/{token}', ResetPassword::class)->middleware('guest')->name('password.reset');

// Auth routes END

// DOC routes START

Route::get('/terms-and-conditions', UserTerms::class)->name('terms');

Route::get('/privacy-policy', Privacy::class)->name('privacy');

Route::get('/frequently-asked-questions', FAQ::class)->name('faq');

Route::get('/contact', ContactPage::class)->name('contact');

Route::get('/about', ReportBug::class)->name('about');

Route::get('/bug-report', ReportBug::class)->name('bugs')->middleware('auth');

Route::get('/reported-bugs', ReportedBugsList::class)->name('reported-bugs');

Route::get('/reported-bug/{bug}', ShowBug::class)->name('show-bug');

// DOC routes END

// Dev Center Routes START

Route::get('/dev-center/contributors', Contributors::class)->name('contributors');

Route::get('/dev-center/contribution-guide', ContributionGuide::class)->name('how-to-contribute');

// Dev Center Routes END

Route::get('/', Home::class)->name('home');

// Post routes START

Route::get('/p/create', CreatePost::class)->name('posts.create')->middleware('auth', 'verified');
Route::get('/p/edit/{post}', EditPost::class)
    ->name('posts.edit')
    ->middleware('auth', 'verified');
Route::get('/posts', ListPosts::class)->name('posts.index');
Route::get('/p/{post}/{slug}', ShowPost::class)->name('posts.show');

// Post Routes END

// User routes START

Route::get('/u/search/{query?}', SearchUser::class)->name('users.search');
Route::get('/u/{user:username}', function (\App\Models\User $user) {
    return "User: {$user->username}";
})->name('users.show');
Route::get('/u/{user:username}/edit', EditUser::class)->name('users.edit')->middleware('auth');

// User routes END

// Faculties routes START

Route::get('/faculties', ShowFaculties::class)->name('faculties')->middleware('can:join,App\Models\Faculty');

// Faculties routes END

// Tags routes START

Route::get('/tags/{tag:slug}', ShowPostsByTag::class)->name('tags.show');

// Tags routes END

// Admin routes START

Route::get('/admin/contact-us-submissions', MessagesIndexer::class)->name('admin.contacts')->middleware(CheckAdminRole::class);
Route::get('/admin/contact-us-submissions/{message}', ShowMessage::class)->name('admin.contact.show')->middleware(CheckAdminRole::class);

// Admin routes END