<?php

use App\Http\Controllers\MobileApi\CartsController;
use App\Http\Controllers\MobileApi\CompareListsController;
use App\Http\Controllers\MobileApi\OrdersController;
use App\Http\Controllers\MobileApi\RatingReviewsController;
use App\Http\Controllers\MobileApi\UserFollowStoreController;
use App\Http\Controllers\MobileApi\UsersController;
use App\Http\Controllers\MobileApi\UserWishlistsController;
use App\Http\Controllers\MobileApi\VouchersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobileApi\MobileApiController;
use App\Http\Controllers\MobileApi\CategoryController;
use App\Http\Controllers\MobileApi\CancellationsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([
    'prefix' => 'v1'
], function (){

    Route::get('common', [MobileApiController::class, 'common']);
    Route::get('home', [MobileApiController::class, 'home']);
    Route::get('products', [MobileApiController::class, 'products']);
    Route::get('categories', [MobileApiController::class, 'categories']);
    Route::get('mobile-categories', [CategoryController::class , 'index']);
    Route::get('all', [MobileApiController::class, 'all']);
    Route::get('brands', [MobileApiController::class, 'brands']);
    Route::get('search', [MobileApiController::class, 'search']);
    Route::get('product/{id}', [MobileApiController::class, 'product']);
    Route::get('flash-sale/{id?}', [MobileApiController::class, 'flashSale']);
    Route::get('reviews/{id}', [MobileApiController::class, 'reviews']);
    Route::get('suggested-products/{id}', [MobileApiController::class, 'productSuggestion']);
    Route::get('page/{slug}', [MobileApiController::class, 'page']);
    Route::post('contact', [MobileApiController::class, 'contactUs']);
    Route::get('track-order', [MobileApiController::class, "trackOrder"]);
    Route::get('store', [MobileApiController::class, "store"]);
    Route::get('payment-gateway', [MobileApiController::class, "paymentGateway"]);
    Route::get('localization', [MobileApiController::class, "localization"]);
    Route::get('countries-phones', [MobileApiController::class, "countriesPhones"]);


    Route::group([
        'prefix' => 'cart',
    ], function (){
        Route::get('by-user', [CartsController::class, "byUser"]);
        Route::post('action', [CartsController::class, "action"]);
        Route::post('buy-now', [CartsController::class, "buyNow"]);
        Route::delete('delete/{id}', [CartsController::class, 'delete']);
        Route::post('change', [CartsController::class, 'changeSelected']);
        Route::post('update-shipping', [CartsController::class, 'updateShipping']);
    });


    Route::group([
        'prefix' => 'cancellation',
    ], function (){
        Route::post('cancel-order', [CancellationsController::class, 'cancelOrder']);
        Route::get('find/{orderId}', [CancellationsController::class, 'findCancellation']);
    });



    Route::group([
        'prefix' => 'voucher',
    ], function (){
        Route::post('validity', [VouchersController::class, 'validity']);
    });


    Route::group([
        'prefix' => 'rating-review',
    ], function (){
        Route::post('action', [RatingReviewsController::class, "action"]);
        Route::get('find/{productId}', [RatingReviewsController::class, "find"]);
    });


    Route::group([
        'prefix' => 'order',
    ], function (){
        Route::post('by-user', [OrdersController::class, "byUser"]);
        Route::post('action', [OrdersController::class, "action"]);
        Route::post('payment-done', [OrdersController::class, 'paymentDone']);
        Route::get('send-order-email/{id}', [OrdersController::class, 'sendOrderEmail']);
    });



    Route::group([
        'prefix' => 'user'
    ], function (){


        Route::group([
            'prefix' => 'address',
        ], function (){
            Route::get('all', [UsersController::class, "addresses"]);
            Route::post('action', [UsersController::class, "addressAction"]);
            Route::delete('delete/{id}', [UsersController::class, "deleteAddress"]);
        });


        Route::get('profile', [UsersController::class, "profile"]);

        Route::group([

            'prefix' => 'social-login',
            'middleware' => ['social', 'web']

        ], function () {
            Route::get('redirect/{service}',  [UsersController::class, 'redirectToProvider']);
            Route::get('callback/{service}',  [UsersController::class, 'handleProviderCallback']);
        });

        Route::post('signin', [UsersController::class, 'login']);
        Route::post('signup', [UsersController::class, 'signup']);
        Route::post('verify', [UsersController::class, 'verify']);
        Route::post('forgot-password', [UsersController::class, 'forgotPassword']);
        Route::post('update-password', [UsersController::class, 'updatePassword']);

        Route::get('user-vouchers', [UsersController::class, "vouchers"]);


        Route::group([
            'middleware' =>  ['auth:user', 'scope:user']
        ], function () {
            Route::get('logout', [UsersController::class, "logout"]);


            Route::post('update-profile', [UsersController::class, "updateProfile"]);
            Route::post('update-user-password', [UsersController::class, "updateUserPassword"]);


            Route::group([
                'prefix' => 'compare-list',
            ], function (){
                Route::get('all', [CompareListsController::class, "all"]);
                Route::post('action', [CompareListsController::class, "action"]);
            });


            Route::group([
                'prefix' => 'store',
            ], function (){
                Route::post('follow', [UserFollowStoreController::class, 'action']);
                Route::get('following-list', [UserFollowStoreController::class, 'all']);
            });

            Route::group([
                'prefix' => 'wishlist',
            ], function (){
                Route::get('all', [UserWishlistsController::class, "wishlists"]);
                Route::post('action', [UserWishlistsController::class, "wishlistAction"]);
            });



        });
    });
});
