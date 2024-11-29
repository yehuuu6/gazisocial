<?php

use App\Livewire\Pages\HomePage;
use App\Livewire\Pages\Auth\Login;
use App\Livewire\Pages\Auth\Verify;
use App\Livewire\Pages\Dev\ShowBug;
use App\Livewire\Pages\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Posts\EditPost;
use App\Livewire\Pages\Posts\ShowPost;
use App\Livewire\Pages\Users\EditUser;
use App\Livewire\Pages\Users\UserPage;
use App\Http\Middleware\CheckAdminRole;
use App\Livewire\Pages\DevCenter\ContributorsPage;
use App\Livewire\Pages\Post\RepliesPage;
use App\Livewire\Pages\Posts\CreatePost;
use App\Livewire\Pages\Posts\SearchPost;
use App\Livewire\Pages\Users\SearchUser;
use App\Livewire\Pages\Terms\PrivacyPage;
use App\Livewire\Pages\Auth\ResetPassword;
use App\Livewire\Components\Auth\LoginForm;
use App\Livewire\Pages\Auth\ForgotPassword;
use App\Livewire\Pages\Contact\ContactPage;
use App\Livewire\Pages\Terms\UserTermsPage;
use App\Livewire\Pages\Posts\ShowPostsByTag;
use App\Livewire\Pages\Admin\ShowMessagePage;
use App\Livewire\Pages\Contact\BugReportPage;
use App\Livewire\Pages\Faculty\ListFaculties;
use App\Livewire\Pages\Admin\SentMessagesPage;
use App\Livewire\Pages\DevCenter\HowToContributePage;
use App\Livewire\Pages\Terms\ReportedBugsPage;
use App\Livewire\Pages\Terms\FrequentlyAskedPage;

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

Route::get('/forgot-password', ForgotPassword::class)->middleware('guest')->name('password.request');

Route::get('/reset-password/{token}', ResetPassword::class)->middleware('guest')->name('password.reset');

Route::get('/terms-and-conditions', UserTermsPage::class)->name('terms');

Route::get('/privacy-policy', PrivacyPage::class)->name('privacy');

Route::get('/frequently-asked-questions', FrequentlyAskedPage::class)->name('faq');

Route::get('/contact', ContactPage::class)->name('contact');

Route::get('/about', BugReportPage::class)->name('about');

Route::get('/bug-report', BugReportPage::class)->name('bugs')->middleware('auth');

// Auth routes END

// Dev Center Routes START

Route::get('/dev-center/reported-bugs', ReportedBugsPage::class)->name('reported-bugs');

Route::get('/dev-center/reported-bug/{bug}', ShowBug::class)->name('show-bug');

Route::get('/dev-center/contributors', ContributorsPage::class)->name('contributors');

Route::get('/dev-center/contribution-guide', HowToContributePage::class)->name('how-to-contribute');

// Dev Center Routes END

Route::get('/', HomePage::class)->name('home');

// Post routes START

Route::get('/posts/create', CreatePost::class)->name('posts.create')->middleware('auth', 'verified');
Route::get('/posts/edit/{post}', EditPost::class)
    ->name('posts.edit')
    ->middleware('auth', 'verified');
Route::get('/posts', HomePage::class)->name('posts.index');
Route::get('/posts/search/{tag:slug}/{query}', SearchPost::class)->name('posts.search');
Route::get('/posts/{post}/comments/{comment}/replies', RepliesPage::class)->name('posts.replies');
Route::get('/posts/{post}/{slug}', ShowPost::class)->name('posts.show');

// Post Routes END

// User routes START

Route::get('/u/search/{query?}', SearchUser::class)->name('users.search');
Route::get('/u/{user:username}', UserPage::class)->name('users.show');
Route::get('/u/{user:username}/edit', EditUser::class)->name('users.edit')->middleware('auth');

// User routes END

// Faculties routes START

Route::get('/faculties', ListFaculties::class)->name('faculties')->middleware('can:join,App\Models\Faculty');

// Faculties routes END

// Tags routes START

Route::get('/tags/{tag:slug}', ShowPostsByTag::class)->name('tags.show');

// Tags routes END

// Admin routes START

Route::get('/admin/contact-us-submissions', SentMessagesPage::class)->name('admin.contacts')->middleware(CheckAdminRole::class);
Route::get('/admin/contact-us-submissions/{message}', ShowMessagePage::class)->name('admin.contact.show')->middleware(CheckAdminRole::class);

// Admin routes END