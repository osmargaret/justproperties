<?php

use App\Exports\PropertyBulkTemplateExport;
use App\Livewire\Admin\AdminAdvertisements;
use App\Livewire\Admin\AdminBlog;
use App\Livewire\Admin\AdminBlogPostCreate;
use App\Livewire\Admin\AdminBlogPostEdit;
use App\Livewire\Admin\AdminBlogPostShow;
use App\Livewire\Admin\AdminCouponCreate;
use App\Livewire\Admin\AdminCouponEdit;
use App\Livewire\Admin\AdminCoupons;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\AdminFaqs;
use App\Livewire\Admin\AdminModerations;
use App\Livewire\Admin\AdminPayments;
use App\Livewire\Admin\AdminPromotions;
use App\Livewire\Admin\AdminProperties;
use App\Livewire\Admin\AdminPropertyDetails;
use App\Livewire\Admin\AdminUserDetails;
use App\Livewire\Admin\AdminUsers;
use App\Livewire\Admin\Settings\AdminCategories;
use App\Livewire\Admin\Settings\AdminCountries;
use App\Livewire\Admin\Settings\AdminGeneral;
use App\Livewire\Admin\Settings\AdminAdvertisementSettings;
use App\Livewire\Admin\Settings\AdminCurrencies;
use App\Livewire\Admin\Settings\AdminPromotionPlans;
use App\Livewire\Admin\Settings\AdminRolesPermissions;
use App\Livewire\Admin\Settings\AdminStaff;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\SwitchActiveRole;
use App\Livewire\Buyer\Profile;
use App\Livewire\Guest\About;
use App\Livewire\Guest\Advertise;
use App\Livewire\Guest\BlogPost;
use App\Livewire\Guest\BlogRoll;
use App\Livewire\Guest\CompletedProperty;
use App\Livewire\Guest\Contact;
use App\Livewire\Guest\Facilities;
use App\Livewire\Guest\LandedProperty;
use App\Livewire\Guest\Pricing;
use App\Livewire\Guest\PrivacyPolicy;
use App\Livewire\Guest\PropertyShow;
use App\Livewire\Guest\RentLease;
use App\Livewire\Guest\ShortLet;
use App\Livewire\Guest\TermsOfService;
use App\Livewire\Guest\UncompletedProperty;
use App\Livewire\Guest\Welcome;
use App\Livewire\Member\Bookmarks;
use App\Livewire\Member\Dashboard as MemberDashboard;
use App\Livewire\Member\Notifications as MemberNotifications;
use App\Livewire\Member\Promotions as MemberPromotions;
use App\Livewire\Seller\Checkout as SellerCheckout;
use App\Livewire\Seller\Documents;
use App\Livewire\Seller\ListedProperties;
use App\Livewire\Seller\ListProperty;
use App\Livewire\Seller\PaymentCallback;
use App\Livewire\Seller\PropertyDetails as SellerPropertyDetails;
use Illuminate\Support\Facades\Route;
use Ixudra\Curl\Facades\Curl;
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
Route::get('advertise', Advertise::class)->name('advertise');
Route::get('pricing', Pricing::class)->name('pricing');
Route::get('privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
Route::get('terms-of-service', TermsOfService::class)->name('terms-of-service');

/* Blog Routes */
Route::get('blog', BlogRoll::class)->name('blog');
Route::get('blog/post/{post}', BlogPost::class)->name('post');

/* Properties */
Route::get('landed-properties', LandedProperty::class)->name('landed-properties');
Route::get('uncompleted-properties', UncompletedProperty::class)->name('uncompleted-properties');
Route::get('completed-properties', CompletedProperty::class)->name('completed-properties');
Route::get('facilities', Facilities::class)->name('facilities');
Route::get('rent-lease', RentLease::class)->name('rent-lease');
Route::get('short-lets', ShortLet::class)->name('short-lets');

Route::redirect('admin-dashboard', '/admin/dashboard', 301);

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('account/switch-role', SwitchActiveRole::class)->name('role.switch');
    Route::get('list-property', ListProperty::class)->name('list-property');

    Route::middleware(['admin', 'role.selected'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('moderations', AdminModerations::class)->name('moderations');
        Route::get('users', AdminUsers::class)->name('users');
        Route::get('users/{user}', AdminUserDetails::class)->whereNumber('user')->name('users.show');
        Route::get('promotions', AdminPromotions::class)->name('promotions');
        Route::get('properties', AdminProperties::class)->name('properties');
        Route::get('properties/{property}', AdminPropertyDetails::class)->whereNumber('property')->name('properties.show');
        Route::get('blog', AdminBlog::class)->name('blog');
        Route::get('blog/create', AdminBlogPostCreate::class)->name('blog.create');
        Route::get('blog/{post}', AdminBlogPostShow::class)->whereNumber('post')->name('blog.show');
        Route::get('blog/{post}/edit', AdminBlogPostEdit::class)->whereNumber('post')->name('blog.edit');
        Route::get('payments', AdminPayments::class)->name('payments');
        Route::get('coupons', AdminCoupons::class)->name('coupons');
        Route::get('coupons/create', AdminCouponCreate::class)->name('coupons.create');
        Route::get('coupons/{coupon}/edit', AdminCouponEdit::class)->whereNumber('coupon')->name('coupons.edit');
        Route::get('faqs', AdminFaqs::class)->name('faqs');
        Route::get('advertisements', AdminAdvertisements::class)->name('advertisements');
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('general', AdminGeneral::class)->name('general');
            Route::get('categories', AdminCategories::class)->name('categories');
            Route::get('currencies', AdminCurrencies::class)->name('currencies');
            Route::get('advertising', AdminAdvertisementSettings::class)->name('advertising');
            Route::get('promotion-plans', AdminPromotionPlans::class)->name('promotion-plans');
            Route::get('staff', AdminStaff::class)->name('staff');
            Route::get('roles', AdminRolesPermissions::class)->name('roles');
            Route::get('countries', AdminCountries::class)->name('countries');

        });
    });

    Route::middleware(['role.selected'])->prefix('account')->name('account.')->group(function () {
        Route::get('dashboard', MemberDashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('bookmarks', Bookmarks::class)->name('bookmarks');
        Route::get('notifications', MemberNotifications::class)->name('notifications');
        Route::get('promotions', MemberPromotions::class)->name('promotions');
    });

    Route::middleware(['role.selected'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('dashboard', MemberDashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('listed-properties', ListedProperties::class)->name('listed-properties');
        Route::get('properties/{property}', SellerPropertyDetails::class)->whereNumber('property')->name('properties.show');
        Route::get('checkout/{payment}', SellerCheckout::class)->whereNumber('payment')->name('checkout');
        Route::get('payment/callback', PaymentCallback::class)->name('payment.callback');
        Route::get('bulk-template', fn () => Excel::download(new PropertyBulkTemplateExport, 'property-listings-template.xlsx'))->name('bulk-template.download');
        Route::get('documents', Documents::class)->name('documents');
    });

    Route::middleware(['role.selected'])->prefix('buyer')->name('buyer.')->group(function () {
        Route::get('dashboard', MemberDashboard::class)->name('dashboard');
        Route::get('profile', Profile::class)->name('profile');
        Route::get('favourites', fn () => redirect()->route('account.bookmarks'))->name('favourites');
        Route::get('security', fn () => redirect()->route('account.profile', ['tab' => 'security']))->name('security');
        Route::get('property-alerts', fn () => redirect()->route('account.profile', ['tab' => 'notifications']))->name('property-alerts');
        Route::get('blog-subscriptions', fn () => redirect()->route('account.profile', ['tab' => 'notifications']))->name('blog-subscriptions');
        Route::get('saved-blog-posts', fn () => redirect()->route('account.dashboard'))->name('saved-blog-posts');
    });

    Route::middleware(['role.selected'])->prefix('seller')->name('seller.')->group(function () {
        Route::get('subscriptions', fn () => redirect()->route('account.promotions'))->name('subscriptions');
        Route::get('transactions', fn () => redirect()->route('account.promotions'))->name('transactions');
    });

    Route::post('properties/{property}/bookmark', \App\Http\Controllers\TogglePropertyBookmark::class)
        ->name('properties.bookmark.toggle');
});

require __DIR__.'/settings.php';

Route::get('/property/{property:slug}', PropertyShow::class)->name('property.show');
Route::get('/property-hero-preview', function () {
    return view('preview.property-hero-preview-copy');
})->name('property.hero.preview');

Route::get('/advertise/rate-card', function () {
    return view('guest.advertise-rate-card-pdf', [
        'advertisementPlans' => \App\Models\AdvertisementPlan::query()
            ->with(['spaces', 'prices.currency'])
            ->where('is_active', true)
            ->whereHas('prices')
            ->orderBy('name')
            ->get(),
    ]);
})->name('advertise.rate-card');

Route::get('fetchstate',function(){
    $response = Curl::to('https://api.countrystatecity.in/v1/countries/NG/states')
                ->withHeaders(['X-CSCAPI-KEY' => config('services.countrystatecity', '')])
                ->asJson()
                ->get();
    dd($response);
});
