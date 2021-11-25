<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//public routes


//homepage routes




/**************************  Before Login Route ****************************/
Route::group(['middleware' => 'guest'], function () {
	Route::get('/login', 'Web\Homepage\HomepageController@loginSignUp')->name('frontend_login');
	Route::post('/user-login', 'Web\Homepage\AuthController@login')->name('post_login');
	Route::post('/user-signup', 'Web\Homepage\AuthController@register');

	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('post.reset-password');



	// Route::get('forgot-password', 'Web\Homepage\AuthController@forgotPassword')->name('forgot_password');
	// Route::post('forgot-password', 'Web\Homepage\AuthController@postForgotPassword')->name('post_forgot_password');
	/****************  Faceboook SignUp Route  ***********/

	Route::get('/auth/redirect/facebook', 'Web\Homepage\SocialController@redirectFacebook')->name('facebook_signin');
  	Route::get('/callback/facebook', 'Web\Homepage\SocialController@facebookCallback');

  	/***************   End Facebook Route *****************/

  	/****************  Twitter SignUp Route  ***********/

	Route::get('/auth/redirect/twitter', 'Web\Homepage\SocialController@redirectTwitter')->name('twitter_signin');
  	Route::get('/callback/twitter', 'Web\Homepage\SocialController@twitterCallback');

  	/***************   End Twitter Route *****************/
});
/************************* End Before Login route ****************************/

/************ before login and after login route accessable ************/
Route::get('/', 'Web\Homepage\HomepageController@index')->name('home');
Route::get('get_latest', 'Web\Homepage\HomepageController@getLatest')->name('get_latest');
Route::get('get_supreme', 'Web\Homepage\HomepageController@getSupreme')->name('get_supreme');
Route::get('get_popular', 'Web\Homepage\HomepageController@getPopular')->name('get_popular');
Route::get('/faq', 'Web\Homepage\HomepageController@faq');
Route::get('/how-it-works', 'Web\Homepage\HomepageController@howItWorks');
Route::get('/user-reviews', 'Web\Homepage\HomepageController@userReviews');
Route::get('/terms-and-conditions', 'Web\Homepage\HomepageController@termsAndConditions');
Route::get('/contact-us', 'Web\Homepage\HomepageController@contactUs');
Route::get('/get-app', 'Web\Homepage\HomepageController@getOurApp')->name('get_app');
Route::get('/news', 'Web\Homepage\HomepageController@news');
Route::get('brands',[
    'as' => 'brands',
    'uses' => 'Web\Homepage\HomepageController@allBrands'
]);
Route::get('products',[
    'as' => 'products',
    'uses' => 'Web\Homepage\ProductController@allProducts'
]);
Route::get('latest/products',[
    'as' => 'latest_products',
    'uses' => 'Web\Homepage\ProductController@latestProducts'
]);
Route::get('products/lowestask',[
						'as' => 'product_lowest_ask_all',
						'uses' => 'Web\Homepage\ProductController@lowestAskProduct'
					]);
Route::get('products/highestbid',[
						'as' => 'product_highest_bid_all',
						'uses' => 'Web\Homepage\ProductController@highestBidProduct'
					]);
Route::get('products/supreme/lowestask',[
						'as' => 'supreme_product_lowest_ask_all',
						'uses' => 'Web\Homepage\ProductController@lowestAskSupremeProduct'
					]);
Route::get('products/supreme/highestbid',[
						'as' => 'supreme_product_highest_bid_all',
						'uses' => 'Web\Homepage\ProductController@highestBidSupremeProduct'
					]);

Route::get('products/{name}',[
						'as' => 'product_supreme',
						'uses' => 'Web\Homepage\ProductController@supremeProducts'
					]);
Route::get('product/{id}',[
						'as' => 'single_product',
						'uses' => 'Web\Homepage\ProductController@singleProduct'
					]);
Route::post('getLowestAskBid',[
						'as' => 'get_lowest_ask_bid',
						'uses' => 'Web\Homepage\ProductController@getDataBySize'
					]);
Route::post('getLowestAskBidCondition',[
						'as' => 'get_lowest_ask_bid_condition',
						'uses' => 'Web\Homepage\ProductController@getDataByConditionSize'
					]);
Route::post('get_lowest_ask_size',[
						'as' => 'get_lowest_ask_size',
						'uses' => 'Web\Homepage\ProductController@getLowestAskBySize'

					]);
Route::post('get_highest_bid_size',[
						'as' => 'get_highest_bid_size',
						'uses' => 'Web\Homepage\ProductController@getHeighestBidBySize'

					]);
Route::get('set_condition',[
						'as' => 'set_condition',
						'uses' => 'Web\Homepage\ProductController@setSessionCondition'

					]);
Route::get('get-graph-data',[
						'as' => 'get-graph-data',
						'uses' => 'Web\Homepage\ProductController@getMonthGraphData'
					]);
Route::get('get-sales-data',[
						'as' => 'get-sales-data',
						'uses' => 'Web\Homepage\ProductController@getSales'
					]);

/************************** End universal route **********************/

Route::post('logout',function(){
	if(Auth::user()->hasRole('admin')){
		Auth::logout();
		return redirect()->route('admin_login');
	}
	Auth::logout();
	return redirect('login');
});



/****************************** after login verification route *****************************/

Route::get('/verification', [
								'as' => 'verification.notice',
								'uses' => 'Web\Homepage\HomepageController@verificationCode'
							])->middleware('auth');
Route::post('/verification', [
								'as' => 'submit_verification_code',
								'uses' => 'Web\Homepage\HomepageController@verificationCodeSubmit'
							])->middleware('auth');
Route::get('code_verification',[
								'as' => 're_code_verification',
								'uses' => 'Web\Homepage\AuthController@resendVerificationCode'
							   ])->middleware('auth');

/***************************** End Verification Route ***************************************/


/************************************   Seller Dashboard Route **************************************/

Route::group(['prefix' => 'seller', 'as' => 'seller.','middleware' => ['auth','verified']], function () {
	Route::get('dashboard', [
						'as' => 'dashboard',
						'uses' => 'Web\Dashboard\DashboardController@index'
					]);
	Route::group(['prefix' => 'ask', 'as' => 'ask.'], function () {
			Route::get('product/{id}', [
							'as' => 'index',
							'uses' => 'Web\Dashboard\AskController@index'
					]);
			Route::post('ask_save',[
						'as' => 'ask_save',
						'uses' => 'Web\Dashboard\AskController@storeAsk'

					]);
			Route::get('thankyou/{id}', [
						'as' => 'thankyou',
						'uses' => 'Web\Dashboard\AskController@thankYouAsk'
					]);
			Route::get('edit/{id}', [
							'as' => 'edit',
							'uses' => 'Web\Dashboard\AskController@edit'
					]);
			Route::post('update', [
							'as' => 'update',
							'uses' => 'Web\Dashboard\AskController@update'
					]);

		});

	Route::group(['prefix' => 'bid', 'as' => 'bid.'], function () {
			Route::get('product/{id}', [
							'as' => 'index',
							'uses' => 'Web\Dashboard\BidController@index'
					]);
			Route::post('bid_save',[
						'as' => 'bid_save',
						'uses' => 'Web\Dashboard\BidController@storeBid'

					]);
			Route::post('code-verify', [
						'as' => 'code_verification',
						'uses' => 'Web\Dashboard\BidController@codeVerification'
					]);
			Route::get('thankyou/{id}', [
						'as' => 'thankyou',
						'uses' => 'Web\Dashboard\BidController@thankYouBid'
					]);
			Route::get('edit/{id}', [
							'as' => 'edit',
							'uses' => 'Web\Dashboard\BidController@edit'
					]);
			Route::post('update', [
							'as' => 'update',
							'uses' => 'Web\Dashboard\BidController@update'
					]);
		});

	Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
			Route::get('', [
							'as' => 'index',
							'uses' => 'Web\Dashboard\ProfileController@index'
					]);
			Route::post('change_password', [
							'as' => 'change_password',
							'uses' => 'Web\Dashboard\ProfileController@changePassword'
					]);

			Route::get('edit', [
							'as' => 'edit',
							'uses' => 'Web\Dashboard\ProfileController@edit'
					]);
			Route::post('update', [
							'as' => 'update',
							'uses' => 'Web\Dashboard\ProfileController@update'
					]);
			Route::post('delivery_address', [
							'as' => 'delivery_address',
							'uses' => 'Web\Dashboard\ProfileController@deliveryAddress'
			]);
			Route::post('delivery_address_checkout', [
							'as' => 'delivery_address_checkout',
							'uses' => 'Web\Dashboard\ProfileController@deliveryAddressCheckout'
			]);
		});

	Route::group(['prefix' => 'portfolio', 'as' => 'portfolio.'], function () {
			// Route::get('', [
			// 				'as' => 'index',
			// 				'uses' => 'Web\Dashboard\PortfolioController@index'
			// 		]);
			Route::get('asks', [
							'as' => 'asks',
							'uses' => 'Web\Dashboard\PortfolioController@asks'
					]);
			Route::get('bids', [
							'as' => 'bids',
							'uses' => 'Web\Dashboard\PortfolioController@bids'
					]);
			Route::get('get-user-bids', [
							'as' => 'get-user-bids',
							'uses' => 'Web\Dashboard\PortfolioController@getUserBids'
					]);
			Route::get('get-user-asks', [
							'as' => 'get-user-asks',
							'uses' => 'Web\Dashboard\PortfolioController@getUserAsks'
					]);
			Route::get('search-product', [
							'as' => 'search',
							'uses' => 'Web\Dashboard\PortfolioController@search'
					]);
			Route::get('add-product', [
							'as' => 'add',
							'uses' => 'Web\Dashboard\PortfolioController@addproduct'
					]);
			Route::get('get_products', [
							'as' => 'get_products',
							'uses' => 'Web\Dashboard\PortfolioController@getProducts'
					]);
			Route::post('save', [
							'as' => 'save',
							'uses' => 'Web\Dashboard\PortfolioController@savePortfolio'
					]);
                Route::get('preview', [
							'as' => 'preview',
							'uses' => 'Web\Dashboard\PortfolioController@preview'
					]);
			Route::get('place-ask', [
							'as' => 'place_ask',
							'uses' => 'Web\Dashboard\PortfolioController@placeAsk'
					]);
			Route::post('save-place-ask', [
							'as' => 'save_place_ask',
							'uses' => 'Web\Dashboard\PortfolioController@savePlaceAsk'
					]);
			// Route::get('bid/edit/{id}', [
			// 				'as' => 'bid_edit',
			// 				'uses' => 'Web\Dashboard\BidController@edit'
			// 		]);
			// Route::get('ask/edit/{id}', [
			// 				'as' => 'edit',
			// 				'uses' => 'Web\Dashboard\AskController@edit'
			// 		]);
		});

	Route::group(['prefix' => 'following', 'as' => 'following.'], function () {
			Route::get('', [
							'as' => 'index',
							'uses' => 'Web\Dashboard\FollowingController@index'
					]);
			Route::get('getFollowingProduct', [
							'as' => 'getFollowingProduct',
							'uses' => 'Web\Dashboard\FollowingController@getFollowingProduct'
					]);
			Route::post('save', [
							'as' => 'save',
							'uses' => 'Web\Dashboard\FollowingController@save'
					]);
			Route::get('delete/{id}', [
							'as' => 'delete',
							'uses' => 'Web\Dashboard\FollowingController@delete'
					]);
		});

	Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
			Route::get('', [
							'as' => 'index',
							'uses' => 'Web\Dashboard\SettingController@index'
					]);
			Route::get('delivery-address', [
							'as' => 'delivery_address',
							'uses' => 'Web\Dashboard\SettingController@deliveryAddress'
					]);
		});

	Route::group(['prefix' => 'paypal', 'as' => 'paypal.'], function () {
			Route::get('verification', ['as' => 'verification', 'uses' => 'Web\Dashboard\PaypalController@accountVerification']);

			Route::get('confirm_deposit', ['as' => 'confirm_deposit', 'uses' => 'Web\Dashboard\PaypalController@confirmAccountVerification']);

			Route::get('checkout-verification/{id}', ['as' => 'checket_verification', 'uses' => 'Web\Dashboard\PaypalController@accountVerificationCheckOut']);

			Route::get('checkout-confirm_deposit', ['as' => 'checkout_confirm_deposit', 'uses' => 'Web\Dashboard\PaypalController@confirmAccountVerificationCheckOut']);

			Route::get('sell-checkout-verification/{id}', ['as' => 'checket_verification_sell', 'uses' => 'Web\Dashboard\PaypalController@accountVerificationCheckOutSell']);

			Route::get('sell-checkout-confirm_deposit', ['as' => 'checkout_confirm_deposit_sell', 'uses' => 'Web\Dashboard\PaypalController@confirmAccountVerificationCheckOutSell']);

		});

	Route::group(['prefix' => 'credit', 'as' => 'credit.'], function () {
			Route::post('verification', ['as' => 'verification', 'uses' => 'Web\Dashboard\CreditCardController@verification']);
			Route::post('verification-checkout', ['as' => 'verification_checkout', 'uses' => 'Web\Dashboard\CreditCardController@verificationCheckOut']);
			Route::get('pp', ['as' => 'pp', 'uses' => 'Web\Dashboard\CreditCardController@testTransaction']);
		});

	Route::group(['prefix' => 'buy', 'as' => 'buy.'], function () {
			Route::get('product/{product_id}', ['as' => 'product_size', 'uses' => 'Web\Dashboard\ProductPaymentController@buyNow']);
			Route::post('payment_process', ['as' => 'payment_process', 'uses' => 'Web\Dashboard\ProductPaymentController@paymentProcess']);
			Route::get('confirm_paypal', ['as' => 'confirm_paypal', 'uses' => 'Web\Dashboard\ProductPaymentController@confirmPaypalProcess']);
		});

	Route::group(['prefix' => 'sell', 'as' => 'sell.'], function () {
			Route::get('product/{product_id}', ['as' => 'product_size', 'uses' => 'Web\Dashboard\ProductPaymentController@sellNow']);
			Route::post('payment_process', ['as' => 'payment_process', 'uses' => 'Web\Dashboard\ProductPaymentController@paymentProcessSell']);
			Route::get('confirm_paypal', ['as' => 'confirm_paypal', 'uses' => 'Web\Dashboard\ProductPaymentController@confirmPaypalProcessSell']);
		});
	Route::group(['prefix' => 'transaction'],function(){
		Route::get('',[
			'as' 	=> 'transaction.index',
			'uses' 	=> 'Web\Dashboard\SellingController@transaction'
		]);
		Route::group(['prefix' => 'selling', 'as' => 'selling.'],function(){
				Route::get('', ['as' => 'index', 'uses' => 'Web\Dashboard\SellingController@index']);

				Route::get('product/{id}',['as' => 'product_sale_detail', 'uses' => 'Web\Dashboard\SellingController@productSaleDetail']);

				Route::get('get_sale_products', ['as' => 'get_sale_products', 'uses' => 'Web\Dashboard\SellingController@getSaleProducts']);
				Route::get('get_sale_products_history', ['as' => 'get_sale_products_history', 'uses' => 'Web\Dashboard\SellingController@getSaleProductsHistory']);
				Route::get('deliver_product/{id}', ['as' => 'deliver_product', 'uses' => 'Web\Dashboard\SellingController@deliverProduct']);
			});
		Route::group(['prefix' => 'buying', 'as' => 'buying.'],function(){
				Route::get('', ['as' => 'index', 'uses' => 'Web\Dashboard\BuyingController@index']);

				Route::get('product/{id}',['as' => 'product_buy_detail', 'uses' => 'Web\Dashboard\BuyingController@productBuyDetail']);
				Route::post('seller_rate/{id}',['as' => 'seller_rate', 'uses' => 'Web\Dashboard\BuyingController@rateSeller']);

				Route::get('get_buy_products', ['as' => 'get_buy_products', 'uses' => 'Web\Dashboard\BuyingController@getBuyProducts']);
				Route::get('get_buy_products_history', ['as' => 'get_buy_products_history', 'uses' => 'Web\Dashboard\BuyingController@getBuyProductsHistory']);
				Route::get('receive-product/{id}', ['as' => 'receive_product', 'uses' => 'Web\Dashboard\BuyingController@receiveProduct']);
			});
	});


});



/*********************************  End Seller Dashboard *********************************************/


/*====================================== ADMIN ROUTES   =============================================*/
Route::get('admin/login',[
    'as' => 'admin_login',
    'uses' => 'Auth\LoginController@showLoginForm'
])->middleware('guest');
Route::post('admin/login',[
    'as' => 'post_admin_login',
    'uses' => 'Auth\LoginController@login'
])->middleware('guest');
Route::group(['prefix' => 'admin', 'as' => 'admin.','middleware' => ['auth']], function () {
    Route::get('dashboard', [
        'as' => 'dashboard',
        'uses' => 'Admin\DashboardController@index'
    ]);
    Route::group(['prefix' => 'brands', 'as' => 'brand.'], function () {
        Route::get('', [
            'as' => 'index',
            'uses' => 'Admin\BrandController@index'
        ]);
        Route::get('add', [
            'as' => 'add',
            'uses' => 'Admin\BrandController@create'
        ]);
        Route::post('save', [
            'as' => 'save',
            'uses' => 'Admin\BrandController@save'
        ]);
        Route::get('edit/{id}', [
            'as' => 'edit',
            'uses' => 'Admin\BrandController@edit'
        ]);
        Route::post('update', [
            'as' => 'update',
            'uses' => 'Admin\BrandController@update'
        ]);
    });
    Route::group(['prefix' => 'products', 'as' => 'product.'], function () {
        Route::get('', [
            'as' => 'index',
            'uses' => 'Admin\ProductController@index'
        ]);
        Route::get('get_products', [
            'as' => 'get_products',
            'uses' => 'Admin\ProductController@getProducts'
        ]);

        Route::get('create', [
            'as' => 'create',
            'uses' => 'Admin\ProductController@create'
        ]);
        Route::post('store', [
            'as' => 'store',
            'uses' => 'Admin\ProductController@store'
        ]);
        Route::get('edit/{id}', [
            'as' => 'edit',
            'uses' => 'Admin\ProductController@edit'
        ]);
        Route::post('update', [
            'as' => 'update',
            'uses' => 'Admin\ProductController@update'
        ]);
        Route::post('delete', [
            'as' => 'delete',
            'uses' => 'Admin\ProductController@delete'
        ]);
    });


    Route::group(['prefix' => 'release/products', 'as' => 'release_product.'], function () {
        Route::get('', [
            'as' => 'index',
            'uses' => 'Admin\ReleaseProductController@index'
        ]);
        Route::get('get_products', [
            'as' => 'get_products',
            'uses' => 'Admin\ReleaseProductController@getProducts'
        ]);
        Route::get('create', [
            'as' => 'create',
            'uses' => 'Admin\ReleaseProductController@create'
        ]);
        Route::post('store', [
            'as' => 'store',
            'uses' => 'Admin\ReleaseProductController@store'
        ]);
        Route::get('edit/{id}', [
            'as' => 'edit',
            'uses' => 'Admin\ReleaseProductController@edit'
        ]);
        Route::post('update', [
            'as' => 'update',
            'uses' => 'Admin\ReleaseProductController@update'
        ]);
        Route::post('delete', [
            'as' => 'delete',
            'uses' => 'Admin\ReleaseProductController@delete'
        ]);


    });

    Route::group(['prefix' => '', 'as' => 'bids_asks.'], function () {
        Route::get('product-by-size', [
            'as' => 'product_by_size',
            'uses' => 'Admin\ProductBidsAskController@productBySize'
        ]);
        Route::get('get_product_by_size', [
            'as' => 'get_product_by_size',
            'uses' => 'Admin\ProductBidsAskController@getProductBySize'
        ]);
        Route::get('product/size/{size_id}/asks_bids', [
            'as' => 'index',
            'uses' => 'Admin\ProductBidsAskController@productBySizeAsks'
        ]);
        Route::get('get_asks/{size_id}', [
            'as' => 'get_asks',
            'uses' => 'Admin\ProductBidsAskController@getProductBySizeAsks'
        ]);

        Route::get('get_bids/{size_id}', [
            'as' => 'get_bids',
            'uses' => 'Admin\ProductBidsAskController@getProductBySizeBids'
        ]);
    });





    Route::group(['prefix' => 'coupons', 'as' => 'coupon.'], function () {
        Route::get('', [
            'as' => 'index',
            'uses' => 'Admin\CouponController@index'
        ]);
        Route::get('get_coupons', [
            'as' => 'get_coupons',
            'uses' => 'Admin\CouponController@getCoupons'
        ]);
        Route::get('create', [
            'as' => 'create',
            'uses' => 'Admin\CouponController@create'
        ]);
        Route::post('store', [
            'as' => 'store',
            'uses' => 'Admin\CouponController@store'
        ]);

        Route::get('edit/{id}', [
            'as' => 'edit',
            'uses' => 'Admin\CouponController@edit'
        ]);
        Route::post('update', [
            'as' => 'update',
            'uses' => 'Admin\CouponController@update'
        ]);
        Route::get('delete/{id}', [
            'as' => 'delete',
            'uses' => 'Admin\CouponController@delete'
        ]);


    });
    Route::group(['prefix' => 'settings', 'as' => 'setting.'], function () {
        Route::get('paypal', [
            'as' => 'paypal',
            'uses' => 'Admin\SettingController@paypal'
        ]);
        Route::post('save_paypal', [
            'as' => 'save_paypal',
            'uses' => 'Admin\SettingController@savePaypal'
        ]);
        Route::get('shipment-fee', [
            'as' => 'shipment',
            'uses' => 'Admin\SettingController@shipmentFee'
        ]);
        Route::post('shipment_fee', [
            'as' => 'save_shipment',
            'uses' => 'Admin\SettingController@shipmentFeeSave'
        ]);
    });

    Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
        Route::get('', [
            'as' => 'index',
            'uses' => 'Admin\UserController@index'
        ]);
        Route::get('get_users', [
            'as' => 'get_users',
            'uses' => 'Admin\UserController@getUsers'
        ]);
        Route::get('profile/{id}', [
            'as' => 'profile',
            'uses' => 'Admin\UserController@userProfile'
        ]);
        Route::get('page/{type}/{id}',[
            'as' => 'page',
            'uses' => 'Admin\UserController@pageRender'
        ]);
        Route::get('get_user_bids/{id}', [
            'as' => 'get_user_bids',
            'uses' => 'Admin\UserController@getUserBids'
        ]);
        Route::get('get_user_asks/{id}', [
            'as' => 'get_user_asks',
            'uses' => 'Admin\UserController@getUserAsks'
        ]);
        Route::get('get_user_asks/{id}', [
            'as' => 'get_user_asks',
            'uses' => 'Admin\UserController@getUserAsks'
        ]);
        Route::get('get_user_buying/{id}', [
            'as' => 'get_user_buying',
            'uses' => 'Admin\UserController@getUserBuying'
        ]);
        Route::get('get_user_selling/{id}', [
            'as' => 'get_user_selling',
            'uses' => 'Admin\UserController@getUserSelling'
        ]);
        Route::get('delete/ask/{id}', [
            'as' => 'ask.delete',
            'uses' => 'Admin\UserController@deleteAsk'
        ]);
        Route::get('delete/bid/{id}', [
            'as' => 'bid.delete',
            'uses' => 'Admin\UserController@deleteBid'
        ]);
        Route::post('update', [
            'as' => 'update',
            'uses' => 'Admin\UserController@update'
        ]);
    });


});

/*===================================== END ADMIN ROUTES ============================================*/
