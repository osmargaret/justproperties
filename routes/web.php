<?php

use App\Exports\PropertyBulkTemplateExport;
use App\Livewire\Admin\AdminBlog;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\BlogPostCreate;
use App\Livewire\Admin\BlogPostEdit;
use App\Livewire\Admin\BlogPostShow;
use App\Livewire\Admin\CouponCreate;
use App\Livewire\Admin\CouponEdit;
use App\Livewire\Admin\Coupons;
use App\Livewire\Admin\Payments;
use App\Livewire\Admin\Promotions as AdminPromotions;
use App\Livewire\Admin\Properties;
use App\Livewire\Admin\PropertyDetails;
use App\Livewire\Admin\Settings\Categories as AdminSettingsCategories;
use App\Livewire\Admin\Settings\Countries as AdminSettingsCountries;
use App\Livewire\Admin\Settings\CountryConfig as AdminSettingsCountryConfig;
use App\Livewire\Admin\Settings\Currencies as AdminSettingsCurrencies;
use App\Livewire\Admin\Settings\General as AdminSettingsGeneral;
use App\Livewire\Admin\Settings\PromotionPlans as AdminSettingsPromotionPlans;
use App\Livewire\Admin\Settings\RolesPermissions as AdminSettingsRolesPermissions;
use App\Livewire\Admin\Settings\Staff as AdminSettingsStaff;
use App\Livewire\Admin\Settings\SubscriptionPlans as AdminSettingsSubscriptionPlans;
use App\Livewire\Admin\Subscriptions as AdminSubscriptions;
use App\Livewire\Admin\UserDetails;
use App\Livewire\Admin\Users;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\SwitchActiveRole;
use App\Livewire\Buyer\BlogSubscriptions;
use App\Livewire\Buyer\BuyerDashboard;
use App\Livewire\Buyer\Favourites;
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
use App\Livewire\Seller\Checkout as SellerCheckout;
use App\Livewire\Seller\Documents;
use App\Livewire\Seller\ListedProperties;
use App\Livewire\Seller\ListProperty;
use App\Livewire\Seller\Promotions as SellerPromotions;
use App\Livewire\Seller\PropertyDetails as SellerPropertyDetails;
use App\Livewire\Seller\SellerDashboard;
use App\Livewire\Seller\Settings;
use App\Livewire\Seller\Subscriptions;
use App\Livewire\Seller\Transactions;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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
    Route::get('account/switch-role', SwitchActiveRole::class)->name('role.switch');
    Route::get('list-property', ListProperty::class)->name('list-property');

    Route::middleware(['admin', 'role.selected'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('notifications', Notifications::class)->name('notifications');
        Route::get('users', Users::class)->name('users');
        Route::get('users/{user}', UserDetails::class)->whereNumber('user')->name('users.show');
        Route::get('subscriptions', AdminSubscriptions::class)->name('subscriptions');
        Route::get('promotions', AdminPromotions::class)->name('promotions');
        Route::get('properties', Properties::class)->name('properties');
        Route::get('properties/{property}', PropertyDetails::class)->whereNumber('property')->name('properties.show');
        Route::get('blog', AdminBlog::class)->name('blog');
        Route::get('blog/create', BlogPostCreate::class)->name('blog.create');
        Route::get('blog/{post}', BlogPostShow::class)->whereNumber('post')->name('blog.show');
        Route::get('blog/{post}/edit', BlogPostEdit::class)->whereNumber('post')->name('blog.edit');
        Route::get('payments', Payments::class)->name('payments');
        Route::get('coupons', Coupons::class)->name('coupons');
        Route::get('coupons/create', CouponCreate::class)->name('coupons.create');
        Route::get('coupons/{coupon}/edit', CouponEdit::class)->whereNumber('coupon')->name('coupons.edit');
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('general', AdminSettingsGeneral::class)->name('general');
            Route::get('categories', AdminSettingsCategories::class)->name('categories');
            Route::get('subscription-plans', AdminSettingsSubscriptionPlans::class)->name('subscription-plans');
            Route::get('promotion-plans', AdminSettingsPromotionPlans::class)->name('promotion-plans');
            Route::get('staff', AdminSettingsStaff::class)->name('staff');
            Route::get('roles', AdminSettingsRolesPermissions::class)->name('roles');
            Route::get('currencies', AdminSettingsCurrencies::class)->name('currencies');
            Route::get('countries', AdminSettingsCountries::class)->name('countries');
            Route::get('countries/{country}/config', AdminSettingsCountryConfig::class)->whereNumber('country')->name('countries.config');
        });
    });

    Route::middleware(['role.selected'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('dashboard', SellerDashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('notifications', Notifications::class)->name('notifications');
        Route::get('promotions', SellerPromotions::class)->name('promotions');
        Route::get('listed-properties', ListedProperties::class)->name('listed-properties');
        Route::get('properties/{property}', SellerPropertyDetails::class)->whereNumber('property')->name('properties.show');
        Route::get('checkout/{payment}', SellerCheckout::class)->whereNumber('payment')->name('checkout');
        Route::get('bulk-template', fn () => Excel::download(new PropertyBulkTemplateExport, 'property-listings-template.xlsx'))->name('bulk-template.download');
        Route::get('transactions', Transactions::class)->name('transactions');
        Route::get('subscriptions', Subscriptions::class)->name('subscriptions');
        Route::get('documents', Documents::class)->name('documents');
        Route::get('settings', Settings::class)->name('settings');
    });

    Route::middleware(['role.selected'])->prefix('buyer')->name('buyer.')->group(function () {
        Route::get('dashboard', BuyerDashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('notifications', Notifications::class)->name('notifications');
        Route::get('security', Security::class)->name('security');
        Route::get('favourites', Favourites::class)->name('favourites');
        Route::get('property-alerts', PropertyAlerts::class)->name('property-alerts');
        Route::get('saved-blog-posts', SavedBlogPosts::class)->name('saved-blog-posts');
        Route::get('blog-subscriptions', BlogSubscriptions::class)->name('blog-subscriptions');
    });
});

require __DIR__.'/settings.php';
