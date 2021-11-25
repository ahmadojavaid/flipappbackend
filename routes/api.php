    <?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => ['json.response']], function () {

    Route::post('login', 'Api\AuthController@login');
    Route::post('signup', 'Api\AuthController@register');
    Route::post('reset-password-email','Api\AuthController@sendPasswordEmail'); 
    Route::get('password-email-verification','Api\AuthController@passwordEmailVerification'); 
    Route::post('reset-password','Api\AuthController@passwordReset');
   
    Route::get('home','Api\HomeController@index');
    Route::get('get-supreme', 'Api\HomeController@getSupreme');
    Route::get('single-product/{id}','Api\HomeController@singleProductDetail');
    Route::get('product-detail-by-size','Api\HomeController@getDataBySize');
    Route::get('get-highest-bid','Api\BidController@allHighestBid');
    Route::get('get-lowest-ask','Api\AskController@getLowestAsk'); 
    Route::get('all-justdrop-product','Api\HomeController@getallJustDroppedProduct'); 
    Route::get('all-latest-product','Api\HomeController@getAllLatestProduct');
    Route::get('all-release-product','Api\HomeController@getAllRelaeseProduct');

    Route::middleware('auth:api')->group(function () {
    	Route::get('code-verification','Api\AuthController@emailVerification'); 
    	Route::get('resend-verification-email','Api\AuthController@resendVerificationEmail');

        /** Portfolio ***/
        Route::get('search-product','Api\AskController@searchProduct'); 
        Route::post('save-product-portfolio','Api\AskController@savProductPortfolio'); 
        Route::get('portfolio-place-ask','Api\AskController@getDetailPlaceAsk');
        Route::post('save-place-ask','Api\AskController@savePlaceAsk'); 
        Route::get('get-seller-asks','Api\AskController@getUserAsk');
        /*** End Portfolio route ***/

        /** Ask **/
        Route::get('seller/get-place-ask-detail','Api\AskController@getPlaceAskDetails');
        Route::post('seller/save-place-ask','Api\AskController@savePlaceAsk');
        Route::get('/seller/get-detail-by-size','Api\AskController@getDataBySize'); 
        Route::post('seller/update-ask','Api\AskController@editAskSave');
        /** End Ask **\

        /** Bid **/
        Route::get('get-place-bid-detail','Api\BidController@getDetailPlaceBid');
        Route::post('save-place-bid','Api\BidController@savePlaceBid');
        Route::get('get-detail-by-size','Api\BidController@getHighestBidBySize'); 
        Route::get('get-all-bids','Api\BidController@getallBids');
        Route::post('update-bid','Api\BidController@editBidSave');
        /** End Bid **\
        
        /** Following **/
        Route::get('search-product-following','Api\FollowingController@searchProduct');
        Route::post('save-product-following','Api\FollowingController@saveProductFollowing');
        Route::get('delete-product-following','Api\FollowingController@deleteProductFollowing'); 
        Route::get('get-product-following','Api\FollowingController@getProductFollowing');
        /** End Following **/

        /** Buy Now **/
        Route::get('buy-now','Api\ProductPaymentController@buyNow');
        Route::post('payment-process','Api\ProductPaymentController@paymentProcess');
        /** End Buy Now **/

        /*** Chat Module ***/
        Route::get('get-chat','Api\ChatController@getChats');
        Route::post('post-chat-message','Api\ChatController@postSellerChat');
        Route::get('get-chat-message','Api\ChatController@getChatMessages'); 
        Route::get('get-buyer-chat','Api\ChatController@getBuyerChats');
        /*** End Chat Module ***\

        /** Discount **/
        Route::get('discount-apply','Api\BidController@discountApply');
        /*** End Discount Routes **/
    	
        /*** Payment method route ***/
    	Route::get('get-payment-methods','Api\PaymentController@getPaymentMethods');
    	Route::post('add-credit-card','Api\PaymentController@addCreditCard'); 
    	Route::get('verified-payment-methods','Api\PaymentController@getUserVerifiedPaymentMethod');
    	Route::post('save-payment-details','Api\PaymentController@savePaymentDetails');
    	/*** end pament route **/

    	/** Setting Routes ***/
        Route::get('get-delivery-address','Api\SettingController@getDeliveryAddress');
    	Route::post('delivery-address','Api\SettingController@deliveryAddress');
        Route::post('edit-profile','Api\SettingController@editProfile'); 
        Route::post('password-change','Api\SettingController@passwordChange');
    	/** End Setting Routes ****/
        Route::get('/logout', 'Api\AuthController@logout')->name('logout');
        
        // Get all buy products
        
          Route::get('get_all_products',  'Api\BuyingController@getallProducts');
           Route::get('get_all_products_history', 'Api\BuyingController@getBuyProductsHistory');
             Route::get('buy-product/{id}','Api\BuyingController@productBuyDetail');
              Route::get('receive-product/{id}','Api\BuyingController@receiveProduct');
              Route::post('rate-seller/{id}','Api\BuyingController@rateSeller');
               Route::get('get-reviews','Api\BuyingController@getReviews');
              
          
           
        //  Get all Sale products
        
        Route::get('get_sale_products', 'Api\SellingController@getSaleProducts');
		Route::get('get_sale_products_history', 'Api\SellingController@getSaleProductsHistory');
		  Route::get('sale-product-detail/{id}','Api\SellingController@SaleDetail');
		  Route::get('deliver-product/{id}','Api\SellingController@deliverProduct');
    });
    
     /** Buying products Routes ***/
  
   

    Route::get('merchent-transaction','Api\PaymentController@paymentMerchent');

});
