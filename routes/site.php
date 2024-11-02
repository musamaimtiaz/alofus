<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 07-11-2021
 *
 * @modified 19-12-2021
 */

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Affiliate\AffiliateManagmentController;
use App\Http\Controllers\Site\CityController;
/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// homepage
Route::group(['middleware' => ['locale']], function () {
    Route::get('/', 'SiteController@index')->name('site.index');
    Route::post('review/pagination/fetch', 'SiteController@fetch')->name('fetch.review');
    Route::post('change-language', 'DashboardController@switchLanguage')->middleware(['checkForDemoMode']);

    Route::get('shop/{alias}', 'SellerController@index')->name('site.shop');
    Route::get('shop/profile/{alias}', 'SellerController@vendorProfile')->name('site.shop.profile');

    // login register
    Route::get('login', 'LoginController@login');
    Route::get('user/login', 'LoginController@login')->name('site.login');
    Route::post('authenticate', 'LoginController@authenticate')->name('site.authenticate');
    Route::get('user-verify/{token}/{from?}', 'LoginController@verification')->name('site.verify');
    Route::get('user-verification/{otp}', 'LoginController@verifyByOtp');
    Route::post('sign-up-store', 'LoginController@signUp')->name('site.signUpStore');
    Route::get('user/logout', 'LoginController@logout')->name('site.logout');
    Route::get('check-email-existence/{email}', 'LoginController@checkEmailExistence');
    Route::get('sign-up-email', 'LoginController@emailSignup')->name('site.emailSignup');
    Route::post('sign-up-email/store', 'LoginController@emailStore')->name('site.emailStore');
    Route::post('resend-verification-code', 'LoginController@resendUserVerificationCode');

    // Password reset
    Route::get('password/resets/{token}', 'LoginController@showResetForm')->name('site.password.reset');
    Route::post('password/resets', 'LoginController@setPassword')->name('site.password.resets');
    Route::post('password/email', 'LoginController@sendResetLinkEmail')->name('site.login.sendResetLink');
    Route::get('password/reset-otp/{token}', 'LoginController@resetOtp')->name('site.reset.otp');
    Route::get('verification/otp', 'LoginController@verificationOtp')->name('site.verification.otp');
    // Check valid mail
    Route::get('valid-mail/{mail}', 'LoginController@validMail')->name('site.valid_mail');

    // Seller register
    Route::get('seller/sign-up', 'RegisteredSellerController@showSignUpForm')->name('site.seller.signUp');
    Route::post('seller/sign-up-store', 'RegisteredSellerController@signUp')->name('site.seller.signUpStore');
    Route::get('seller/otp', 'RegisteredSellerController@otpForm')->name('site.seller.otp');
    Route::get('seller/resend-otp/{email?}', 'RegisteredSellerController@resendVerificationCode')->name('site.seller.resend-otp');
    Route::get('seller-verify/{token}', 'RegisteredSellerController@verification')->name('site.seller.verify');
    Route::post('seller-verify/otp', 'RegisteredSellerController@otpVerification')->name('site.seller.otpVerify');

    // Review
    Route::post('site/review/filter', 'SiteController@filterReview');
    Route::post('site/review/search', 'SellerController@searchReview');

    // product
    Route::get('products/{slug}', 'SiteController@productDetails')->name('site.productDetails');

    // Blog
    Route::get('blogs/{value?}', 'SiteController@allBlogs')->name('blog.all');
    Route::get('blog/search', 'SiteController@blogSearch')->name('blog.search');
    Route::get('blog/details/{slug}', 'SiteController@blogDetails')->name('blog.details');
    Route::get('blog-category/{id}', 'SiteController@blogCategory')->name('blog.category');

    // Brands
    Route::get('brand/{id}/products', 'SiteController@brandProducts')->name('site.brandProducts');

    // cart
    Route::get('carts', 'CartController@index')->name('site.cart');
    Route::post('cart-store', 'CartController@store')->name('site.addCart');
    Route::post('cart-reduce-qty', 'CartController@reduceQuantity')->name('site.cartReduceQuantity');
    Route::post('cart-delete', 'CartController@destroy')->name('site.delete');
    Route::post('cart-selected-delete', 'CartController@destroySelected');
    Route::post('cart-selected-store', 'CartController@storeSelected');
    Route::post('cart-all-delete', 'CartController@destroyAll');
    Route::post('cart-select-shipping', 'CartController@selectShipping');

    // Order
    Route::post('order', 'OrderController@store')->middleware(['checkGuest'])->name('site.orderStore');
    Route::get('order-confirm/{reference}', 'OrderController@confirmation')->name('site.orderConfirm');
    Route::get('order-paid', 'OrderController@orderPaid')->name('site.orderpaid');
    Route::post('order-get-shipping-tax', 'OrderController@getShippingTax')->name('site.orderTaxShipping');

    // Check Out
    Route::get('checkout', 'OrderController@checkOut')->middleware(['checkGuest'])->name('site.checkOut');

    // check coupon
    Route::post('check-coupon', 'CartController@checkCoupon')->name('site.checkCoupon');
    Route::post('delete-coupon', 'CartController@deleteCoupon')->name('site.deleteCoupon');

    // search
    Route::get('search-products', 'SiteController@search')->name('site.productSearch');

    // userSearch
    Route::post('get-search-data', 'SiteController@getSearchData')->name('site.searchData');

    // compare
    Route::get('/compare', 'CompareController@index')->name('site.compare');
    Route::post('/compare-store', 'CompareController@store')->name('site.addCompare');
    Route::post('/compare-delete', 'CompareController@destroy')->name('site.compareDestroy');

    // Track order
    Route::get('/track-order', 'OrderController@track')->name('site.trackOrder');

    // Quick View
    Route::get('product/quick-view/{id}', 'SiteController@quickView')->name('quickView');

    // Notification
    Route::group(['as' => 'site.', 'prefix' => 'user'], function () {
        Route::get('notifications', 'NotificationController@index')->name('notifications.index');
        Route::delete('notifications/{id}', 'NotificationController@destroy')->name('notifications.destroy');
        Route::get('notifications/mark-as-read', 'NotificationController@markAsReadAll')->name('notifications.mark_read_all');
        Route::patch('notifications/mark-as-read/{id}', 'NotificationController@markAsRead')->name('notifications.mark_read');
        Route::patch('notifications/mark-as-unread/{id}', 'NotificationController@markAsUnread')->name('notifications.mark_unread');
        Route::get('notifications/ajax-loading', 'NotificationController@headerNotification')->name('notifications.ajax-loading');
        Route::get('notifications/view/{id}', 'NotificationController@view')->name('notifications.view');
    });

    Route::get('user/order-manage', 'OrderController@orderManage')->name('site.orderManage');
    // be a seller
    Route::get('seller/be-a-seller', 'beASellerController@beSeller');
    Route::get('seller/seller-registration', 'beASellerController@sellerRegistration')->name('site.seller-registration');

    // coupon
    Route::get('/coupon', 'SiteController@coupon')->name('site.coupon');

    // shipping
    Route::get('/get-shipping', 'SiteController@getShipping');

    //downloadable link
    Route::get('/download', 'SiteController@download')->name('site.downloadProduct');

    // Pages
    Route::get('page/{slug}', 'SiteController@page')->name('site.page');

    Route::get('/get-component-product', 'SiteController@getComponentProduct')->name('ajax-product');

    //all categories
    Route::get('/categories', 'SiteController@allCategories')->name('all.categories');
});

// login or register by google
Route::get('login/google', 'LoginController@redirectToGoogle')->name('login.google');
Route::get('login/google/callback', 'LoginController@handelGoogleCallback')->name('google');

// login or register by facebook
Route::get('login/facebook', 'LoginController@redirectToFacebook')->name('login.facebook');
Route::get('login/facebook/callback', 'LoginController@handelFacebookCallback')->name('facebook');

Route::group(['middleware' => ['site.auth', 'locale', 'permission']], function () {

    // dashboard
    Route::get('user/dashboard', 'DashboardController@index')->name('site.dashboard');
    Route::get('user/hide-welcome-message', 'DashboardController@removeWelcome');
    // user
    Route::get('user/activity', 'UserController@activity')->name('site.userActivity');
    Route::get('user/profile', 'UserController@edit')->name('site.userProfile');
    Route::post('user/profile/update', 'UserController@update')->name('site.userProfileUpdate');
    Route::get('user/profile/edit-password', 'UserController@editPassword')->name('site.userProfileEditPassword');
    Route::post('user/profile/update-password', 'UserController@updatePassword')->name('site.userProfileUpdatePassword');
    Route::get('user/setting', 'UserController@setting')->name('site.userSetting');
    Route::post('user/delete/', 'UserController@destroy')->name('site.userDelete');
    Route::get('user/orders', 'OrderController@index')->name('site.order');
    Route::get('user/order-details/{reference}', 'OrderController@orderDetails')->name('site.orderDetails');
    Route::get('user/payment/{reference}', 'OrderController@payment')->name('site.orderPayment');
    Route::get('user/profile/remove-image', 'UserController@removeImage')->name('site.userProfileDelete');
    Route::get('user/invoice/print/{id}', 'OrderController@invoicePrint')->name('site.invoice.print');

    // Wishlist
    Route::get('user/wishlists', 'WishlistController@index')->name('site.wishlist');
    Route::post('user/wishlist/store', 'WishlistController@store')->name('site.wishlistStore');
    Route::post('user/wishlist/delete/{id}', 'WishlistController@destroy')->name('wishlist.destroy');

    // Address
    Route::get('user/addresses', 'AddressController@index')->name('site.address');
    Route::get('user/address/create', 'AddressController@create')->name('site.addressCreate');
    Route::post('user/address/store', 'AddressController@store')->name('site.addressStore');
    Route::get('user/address/edit/{id}', 'AddressController@edit')->name('site.addressEdit');
    Route::post('user/address/update/{id}', 'AddressController@update')->name('site.addressUpdate');
    Route::post('user/address/delete/{id}', 'AddressController@destroy')->name('site.addressDelete');
    Route::post('user/check-default-address', 'AddressController@checkDefault');
    Route::get('user/make-default-address/{id}', 'AddressController@makeDefault')->name('address.makeDefault');

    Route::get('user/downloads', 'DownloadController@index')->name('site.download');

    // review
    Route::post('/site/review/update', 'SiteController@updateReview');
    Route::post('/user/review-store', 'SiteController@reviewStore')->name('site.reviewStore');
    Route::get('/user/reviews', 'ReviewController@index')->name('site.review');
    Route::post('/user/review/delete/{id}', 'ReviewController@destroy')->name('site.review.destroy');
    Route::post('/site/review/destroy', 'SiteController@deleteReview');

    // be a seller request
    Route::get('/user/seller/request-form', 'RegisteredSellerController@showRequestForm')->name('site.seller.request-form');
    Route::post('/seller/request-store', 'RegisteredSellerController@sellerRequestStore')->name('site.seller.requestStore');
});

Route::get('/reset-data', 'ResetDataController@reset');

Route::get('guest/payment/{reference}', 'OrderController@payment')->name('site.orderPayment.guest');
Route::get('guest/order-paid', 'OrderController@orderPaid')->name('site.orderpaid.guest');
Route::get('guest/order-confirm/{reference}', 'OrderController@confirmation')->name('site.orderConfirm.guest');
Route::get('guest/invoice/print/{id}', 'OrderController@invoicePrint')->name('site.invoice.print.guest');

Route::group(['prefix' => 'affiliate',], function () {

    Route::get('/management',[AffiliateManagmentController::class, 'index'])->name('affiliate.management');
    Route::get('network',[AffiliateManagmentController::class, 'affiliateNetwork'])->name('affiliate.network');
    Route::post('child/network',[AffiliateManagmentController::class, 'childNetwork'])->name('child.network');
    Route::get('order',[AffiliateManagmentController::class, 'childOrder'])->name('affiliate.order');
    Route::get('subscription',[AffiliateManagmentController::class, 'affliateSubscription'])->name('affiliate.subscription');
    Route::get('profile',[AffiliateManagmentController::class, 'affliateProfile'])->name('affiliate.profile');
});

Route::get('/Affilates', [AffiliateManagmentController::class, 'Affilates'])->name('Affilates');
Route::get('affiliate/register/form/{link?}/{id?}',[AffiliateManagmentController::class,'affiliateRegisterForm'])->name('affiliate.register.form');
Route::post('affiliate/register',[AffiliateManagmentController::class,'affiliateRegister'])->name('affiliate.register');
Route::post('affiliate/mail/check',[AffiliateManagmentController::class,'affiliateMailCheck'])->name('affiliate.mail.check');
Route::get('affiliate/login',[AffiliateManagmentController::class,'affiliateLogin'])->name('affiliate.login');
Route::post('affiliate/login',[AffiliateManagmentController::class,'affiliateLoginStore'])->name('affiliate.login');

Route::get('/get-cities/{id}', [CityController::class, 'getCitiesByCountry'])->name('get.cities.byCountry');

Route::get('/product/{slug}/show/{code?}', [ProductLeftThumbnailController::class, 'singlepage'])->name('single.products.show');