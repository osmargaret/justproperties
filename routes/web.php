<?php

use App\Livewire\Admin\AdminBlog;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\Coupons;
use App\Livewire\Admin\Inspections as AdminInspections;
use App\Livewire\Admin\Payments;
use App\Livewire\Admin\Promotions as AdminPromotions;
use App\Livewire\Admin\Properties;
use App\Livewire\Admin\PropertyDetails;
use App\Livewire\Admin\Subscriptions as AdminSubscriptions;
use App\Livewire\Admin\UserDetails;
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Settings\Categories as AdminSettingsCategories;
use App\Livewire\Admin\Settings\Countries as AdminSettingsCountries;
use App\Livewire\Admin\Settings\General as AdminSettingsGeneral;
use App\Livewire\Admin\Settings\PromotionPlans as AdminSettingsPromotionPlans;
use App\Livewire\Admin\Settings\RolesPermissions as AdminSettingsRolesPermissions;
use App\Livewire\Admin\Settings\Staff as AdminSettingsStaff;
use App\Livewire\Admin\Settings\SubscriptionPlans as AdminSettingsSubscriptionPlans;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Buyer\BlogSubscriptions;
use App\Livewire\Buyer\BuyerDashboard;
use App\Livewire\Buyer\Favourites;
use App\Livewire\Buyer\Inspections as BuyerInspections;
use App\Livewire\Buyer\Notifications;
use App\Livewire\Buyer\Profile;
use App\Livewire\Buyer\PropertyAlerts;
use App\Livewire\Buyer\SavedBlogPosts;
use App\Livewire\Buyer\Security;
use App\Livewire\Guest\About;
use App\Livewire\Guest\BlogPost;
use App\Livewire\Guest\BlogRoll;
use App\Livewire\Guest\CompletedProperty;
use App\Livewire\Guest\Contact;
use App\Livewire\Guest\LandedProperty;
use App\Livewire\Guest\PrivacyPolicy;
use App\Livewire\Guest\RentLease;
use App\Livewire\Guest\ShortLet;
use App\Livewire\Guest\TermsOfService;
use App\Livewire\Guest\UncompletedProperty;
use App\Livewire\Guest\Welcome;
use App\Livewire\Seller\Documents;
use App\Livewire\Seller\ListedProperties;
use App\Livewire\Seller\ListProperty;
use App\Livewire\Seller\Promotions as SellerPromotions;
use App\Livewire\Seller\SellerDashboard;
use App\Livewire\Seller\Settings;
use App\Livewire\Seller\Subscriptions;
use App\Livewire\Seller\Transactions;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});

require __DIR__.'/auth.php';

/* Guest Routes */
Route::get('about', About::class)->name('about');
Route::get('contact', Contact::class)->name('contact');
Route::view('pricing', 'livewire.plan')->name('pricing');
Route::get('privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
Route::get('terms-of-service', TermsOfService::class)->name('terms-of-service');

/* Blog Routes */
Route::get('blog', BlogRoll::class)->name('blog');
Route::get('blog/post', BlogPost::class)->name('post');

/* Properties */
Route::get('landed-properties', LandedProperty::class)->name('landed-properties');
Route::get('uncompleted-properties', UncompletedProperty::class)->name('uncompleted-properties');
Route::get('completed-properties', CompletedProperty::class)->name('completed-properties');
Route::get('rent-lease', RentLease::class)->name('rent-lease');
Route::get('short-lets', ShortLet::class)->name('short-lets');

Route::redirect('admin-dashboard', '/admin/dashboard', 301);

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('notifications', Notifications::class)->name('notifications');
        Route::get('users', Users::class)->name('users');
        Route::get('users/{user}', UserDetails::class)->whereNumber('user')->name('users.show');
        Route::get('subscriptions', AdminSubscriptions::class)->name('subscriptions');
        Route::get('promotions', AdminPromotions::class)->name('promotions');
        Route::get('properties', Properties::class)->name('properties');
        Route::get('properties/{property}', PropertyDetails::class)->whereNumber('property')->name('properties.show');
        Route::get('inspections', AdminInspections::class)->name('inspections');
        Route::get('blog', AdminBlog::class)->name('blog');
        Route::get('payments', Payments::class)->name('payments');
        Route::get('coupons', Coupons::class)->name('coupons');
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('general', AdminSettingsGeneral::class)->name('general');
            Route::get('categories', AdminSettingsCategories::class)->name('categories');
            Route::get('subscription-plans', AdminSettingsSubscriptionPlans::class)->name('subscription-plans');
            Route::get('promotion-plans', AdminSettingsPromotionPlans::class)->name('promotion-plans');
            Route::get('staff', AdminSettingsStaff::class)->name('staff');
            Route::get('roles', AdminSettingsRolesPermissions::class)->name('roles');
            Route::get('countries', AdminSettingsCountries::class)->name('countries');
        });
    });

    Route::get('seller/profile', Profile::class)->name('seller.profile');
    Route::get('seller/notifications', Notifications::class)->name('seller.notifications');
    Route::get('seller/promotions', SellerPromotions::class)->name('seller.promotions');

    Route::get('seller-dashboard', SellerDashboard::class)->name('seller-dashboard');
    Route::get('list-property', ListProperty::class)->name('list-property');
    Route::get('listed-properties', ListedProperties::class)->name('listed-properties');
    Route::get('transactions', Transactions::class)->name('transactions');
    Route::get('subscriptions', Subscriptions::class)->name('subscriptions');
    Route::get('documents', Documents::class)->name('documents');
    Route::get('seller/settings', Settings::class)->name('seller.settings');

    Route::get('buyer-dashboard', BuyerDashboard::class)->name('buyer-dashboard');
    Route::get('profile', Profile::class)->name('profile');
    Route::get('notifications', Notifications::class)->name('notifications');
    Route::get('security', Security::class)->name('security');
    Route::get('favourites', Favourites::class)->name('favourites');
    Route::get('property-alerts', PropertyAlerts::class)->name('property-alerts');
    Route::get('buyer-inspections', BuyerInspections::class)->name('buyer.inspections');
    Route::get('saved-blog-posts', SavedBlogPosts::class)->name('saved-blog-posts');
    Route::get('blog-subscriptions', BlogSubscriptions::class)->name('blog-subscriptions');
});

require __DIR__.'/settings.php';
