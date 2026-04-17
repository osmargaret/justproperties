<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Blog\Article;
use App\Livewire\Blog\BlogRoll;
use App\Livewire\Guest\About;
use App\Livewire\Guest\Contact;
use App\Livewire\Guest\PrivacyPolicy;
use App\Livewire\Guest\TermsOfService;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

/* Guest Routes */
Route::get('about', About::class)->name('about');
Route::get('contact', Contact::class)->name('contact');
Route::get('privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
Route::get('terms-of-service', TermsOfService::class)->name('terms-of-service');

/* Blog Routes */
Route::get('blog', BlogRoll::class)->name('blog');
Route::get('blog/post', Article::class)->name('article');

Route::middleware(['web'])->group(function () {
    Route::view('dashboard', 'livewire.dashboard.landing')->name('dashboard');
    Route::view('profile', 'livewire.dashboard.profile')->name('profile');
    Route::view('plan', 'livewire.plan')->name('plan');
    Route::view('list-property', 'livewire.dashboard.list_property')->name('list-property');
    Route::view('transactions', 'livewire.dashboard.transaction')->name('transactions');
});

require __DIR__.'/settings.php';
