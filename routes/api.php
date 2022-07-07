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

///// to sove cors blocking issues
header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// unprotected routes
Route::group(['middleware' => 'api'], function ($router) {
    Route::post('login', 'AuthController@login');
    // Route::post('register', 'AuthController@register');
    Route::post('verify_admin_email', 'AdminController@verifyEmail');
    Route::post('staff_register', 'AuthController@register');
    Route::post('verify_staff_email', 'StaffController@verifyEmail');
    Route::post('upload_subscription_passport/{id}', 'SubscriptionController@uploadPicture');

    Route::post('post_subscription_form', 'SubscriptionController@postSubscription');
    Route::get('get_weeks_subscriptions', 'SubscriptionController@getWeeksSubscriptions');
    Route::get('get_all_listings', 'SubscriptionController@getAllListings');
    Route::get('get_subscription_listing/{id}', 'SubscriptionController@getSubscriptionListing');
    // Route::get('download_subscr_form/{id}', 'SubscriptionController@downloadForm');
    Route::get('get_testimonials', 'MiscController@getTestimonials');
    Route::post('post_testimonial', 'MiscController@postTestimonial');
    Route::post('send_password_recovery_email', 'PasswordRecoveryController@passwordRecoveryRequest');
    Route::post('confirm_pswd_reset_req', 'PasswordRecoveryController@confirmPasswordReqToken');
    Route::post('reset_user_password', 'PasswordRecoveryController@resetUserPassword');
    Route::post('send_enquiry', 'MiscController@sendEnquiry');
    Route::get('get_featured_listings', 'ListingController@getFeatured');
    Route::get('get_latest_listings', 'ListingController@getLatest');
    Route::get('get_latest_events', 'MiscController@getLatestEvents');
    Route::get('get_all_events', 'MiscController@getAllEvents');
    Route::get('get_event/{id}', 'MiscController@getEvent');
    Route::get('get_latest_news', 'MiscController@getLatestNewsPosts');
    Route::get('get_all_newsposts', 'MiscController@getAllNewsPosts');
    Route::get('get_news_post/{id}', 'MiscController@getNewsPost');
    Route::get('get_listings', 'MiscController@getAllListings');
    Route::get('get_listing/{id}', 'MiscController@getListing');
    Route::get('get_featured_new_offers', 'MiscController@getFeaturedOffers');
    Route::get('get_feat_testimonials', 'MiscController@getFeaturedTestimonials');
});

// staff (auth user) protected routes
Route::group(['middleware' => 'jwt.auth',  'prefix' => 'auth'], function($router){
    Route::post('logout', 'AuthController@logout');
    Route::get('get_weekly_subscriptions_data', 'UserController@getSubscriptionChartData');
    Route::get('get_properties', 'UserController@getProperties');
    Route::get('get_paginated_properties', 'UserController@getPgntdProperties');
    Route::get('get_property/{id}', 'UserController@getProperty');
    Route::post('staff_del_property_file/{id}', 'UserController@delPropertyFile');
    Route::post('staff_update_property/{id}', 'UserController@updateProperty');
    Route::post('create_property_listing', 'UserController@createProperty');
    Route::post('upload_listing_files/{id}', 'UserController@uploadPropertyFiles');
    Route::post('delete_listing/{id}', 'UserController@delPropertyListing');
    Route::post('search_for_properties', 'UserController@searchForProperties');
    Route::post('create_new_listing_plan/{id}', 'UserController@createListingPlan');
    Route::get('get_listing_plan/{id}', 'UserController@getListingPlan');
    Route::post('update_listing_plan/{id}', 'UserController@updateListingPlan');
    Route::post('delete_listing_plan/{id}', 'UserController@deleteListingPlan');
    Route::get('get_paginated_subscriptions', 'UserController@getPgntdSubscriptions');
    Route::get('get_subscription/{id}', 'UserController@getSubscription');
    Route::post('search_for_subscriptions', 'UserController@searchForSubscription');
    Route::get('get_paginated_events', 'UserController@getPaginatedEvents');
    Route::get('get_event/{id}', 'UserController@getEvent');
    Route::post('delete_event/{id}', 'UserController@deleteEvent');
    Route::post('del_event_file/{id}', 'UserController@delEventFile');
    Route::post('update_event/{id}', 'UserController@updateEvent');
    Route::get('get_paginated_news', 'UserController@getPaginatedNewsPosts');
    Route::get('get_news_post/{id}', 'UserController@getNewsPost');
    Route::post('del_post_file/{id}', 'UserController@delNewsPostFile');
    Route::post('update_news_post_file/{id}', 'UserController@updateNewsPostFile');
    Route::post('delete_news_post/{id}', 'UserController@delNewsPost');
    Route::post('create_news_post', 'UserController@createNewsPost');
    Route::post('update_news_post/{id}', 'UserController@updateNewsPost');
    Route::post('search_for_news_posts', 'UserController@searchForPosts');
    Route::get('get_testimonials', 'UserController@searchForPosts');
    Route::post('create_event', 'UserController@createEvent');
    Route::post('upload_event_files/{id}', 'UserController@uploadEventFiles');
    Route::post('search_for_events', 'UserController@searchForEvents');
    Route::post('update_user_profile', 'UserController@updateUserProfile');
    Route::post('update_user_profile_picture', 'UserController@updateUserProfilePic');
    Route::post('update_user_profile_password', 'UserController@updateUserProfilePswd');
    Route::post('confirm_current_pswd', 'UserController@confirmCurrentPassword');
    Route::get('get_subs_count', 'UserController@getSubscriptionsCount');
    Route::get('get_events_count', 'UserController@getEventsCount');
    Route::get('get_news_count', 'UserController@getNewsCount');
    Route::get('get_paginated_offers', 'UserController@getPgntdOffers');
    Route::post('create_new_offer', 'UserController@createNewOffer');
    Route::get('get_new_offer/{id}', 'UserController@getNewOffer');
    Route::post('update_offer_title/{id}', 'UserController@updateNewOfferTitle');
    Route::post('update_new_offer_flier/{id}', 'UserController@updateNewOfferFlier');
    Route::post('delete_offer_file/{id}', 'UserController@deleteOfferFile');
    Route::post('delete_new_offer/{id}', 'UserController@deleteNewOffer');
});


//admin unprotected routes
Route::group(['middleware' => 'api', 'prefix' => 'auth-admin'], function ($router) {
    Route::post('login', 'AdminAuthController@login');
    // Route::get('all_superusers', 'AdminController@getAllSuperUsers');
});

// admin protected routes
Route::group(['prefix' => 'auth-admin', 'middleware' => ['assign.guard:admin-api', 'jwt.auth']], function($router){
    Route::post('logout', 'AdminAuthController@logout');
    Route::get('all_superusers', 'AdminController@getAllSuperUsers');
    Route::get('all_users', 'AdminController@getAllUsers');
    Route::get('all_properties', 'AdminController@getAllProperties');
    Route::get('all_events', 'AdminController@getAllEvents');
    Route::get('latest_props', 'AdminController@getLatestProperties');
    Route::get('all_admins', 'AdminController@getAllAdmins');
    Route::get('get_super_user/{id}', 'AdminController@getAdmin');
    Route::post('change_superuser_status/{id}', 'AdminController@toggleAdminStatus');
    Route::post('super_user/{id}/update', 'AdminController@updateSuperUser');
    Route::post('change_superuser_password/{id}', 'AdminController@updateSuperUserPassword');
    Route::post('super_user_create', 'AdminController@createSuperUser');
    Route::get('get_admin_creator/{id}', 'AdminController@getAdminCreator');
    Route::get('get_admin_authorizer/{id}', 'AdminController@getAdminAuthorizer');
    Route::post('authorize_admin/{id}', 'AdminController@authorizeAdmin');
    // Route::get('all_users', 'AdminController@getAllUsers');
    Route::post('change_user_status/{id}', 'AdminController@toggleUserStatus');
    Route::get('get_user/{id}', 'AdminController@getUser');
    Route::get('get_user_authorizer/{id}', 'AdminController@getUserAuthorizer');
    Route::post('authorize_user/{id}', 'AdminController@authorizeUser');
    Route::post('user/{id}/update', 'AdminController@updateUser');
    Route::post('change_user_status/{id}', 'AdminController@toggleUserStatus');
    Route::post('update_user_password/{id}', 'AdminController@updateUserPassword');
    Route::post('delete_user/{id}', 'AdminController@deleteuser');
    Route::get('get_paginated_properties', 'AdminController@getPaginatedProps');
    Route::get('get_property/{id}', 'AdminController@getProp');
    Route::post('change_prop_status/{id}', 'AdminController@changePropStatus');
    Route::post('change_prop_approval/{id}', 'AdminController@changePropApproval');
    Route::post('change_prop_feature/{id}', 'AdminController@changePropFeature');
    Route::post('admin_update_property/{id}', 'AdminController@updateProperty');
    Route::post('admin_del_property_file/{id}', 'AdminController@delPropertyFile');
    Route::get('get_paginated_subscriptions', 'AdminController@getPaginatedSubscriptions');
    Route::post('delete_subscription/{id}', 'AdminController@deleteSub');
    Route::get('get_subscription/{id}', 'AdminController@getSubscription');
    Route::get('get_paginated_events', 'AdminController@getPaginatedEvents');
    Route::post('delete_event/{id}', 'AdminController@deleteEvent');
    Route::get('get_event/{id}', 'AdminController@getEvent');
    Route::post('change_event_approval/{id}', 'AdminController@changeEventApproval');
    Route::post('change_event_feature/{id}', 'AdminController@changeEventFeature');
    Route::post('update_event/{id}', 'AdminController@updateEvent');
    Route::get('get_event_files/{id}', 'AdminController@getEventFiles');
    Route::post('del_event_file/{id}', 'AdminController@delEventFile');
    Route::post('search_for_events', 'AdminController@searchForEvents');
    Route::post('search_for_testimonials', 'AdminController@searchForTestimonials');
    Route::get('get_testimonials', 'AdminController@getTestimonials');
    Route::get('get_testimonial/{id}', 'AdminController@getTestimonial');
    Route::post('delete_testimonial/{id}', 'AdminController@deleteTestimonial');
    Route::post('update_testimonial/{id}', 'AdminController@updateTestimonial');
    Route::post('del_testimonial_pic/{id}', 'AdminController@delTestimonialPic');
    Route::post('update_testimonial_pic/{id}', 'AdminController@updateTestimonialPic');
    Route::get('get_paginated_news', 'AdminController@getPgntdNews');
    Route::get('get_news_post/{id}', 'AdminController@getNewsPost');
    Route::post('delete_news_post/{id}', 'AdminController@delNewsPost');
    Route::post('change_news_post_feature/{id}', 'AdminController@changeNewsPostFeature');
    Route::post('change_news_post_approval/{id}', 'AdminController@changeNewsPostApproval');
    Route::post('del_post_file/{id}', 'AdminController@delPostFile');
    Route::post('update_news_post/{id}', 'AdminController@updateNewsPost');
    Route::post('update_news_post_file/{id}', 'AdminController@updateNewsPostFile');
    Route::post('search_for_news', 'AdminController@searchforNewsPost');
    Route::post('update_admin_profile', 'AdminController@updateAdminProfile');
    Route::post('confirm_current_pswd', 'AdminController@confirmCurrentPassword');
    Route::post('update_admin_profile_password', 'AdminController@updateAdminPswd');
    Route::post('update_admin_profile_picture', 'AdminController@updateAdminProfilePic');
    Route::post('search_for_properties', 'AdminController@searchForProperties');
    Route::get('all_subscriptions', 'AdminController@getAllSubscriptions');
    Route::get('get_last_news_posts', 'AdminController@getlatestPosts');
    Route::get('get_previous_weeks_subscriptions', 'AdminController@getPrevWksSubscriptionsData');
    Route::get('get_weekly_subscriptions_data', 'AdminController@getWeeklySubscriptionsData');
    Route::post('del_listing/{id}', 'AdminController@delListing');
    Route::get('get_subs_count', 'AdminController@getSubsCount');
    Route::get('get_events_count', 'AdminController@getEventsCount');
    Route::get('get_news_count', 'AdminController@getNewsCount');
    Route::get('get_sub_stats', 'AdminController@getSubStats');
    Route::post('del_listing_plan/{id}', 'AdminController@deleteListingPlan');
    Route::get('get_listing_plan/{id}', 'AdminController@getListingPlan');
    Route::post('update_listing_plan/{id}', 'AdminController@updateListingPlan');
    Route::post('update_testimonial_feature_status/{id}', 'AdminController@updateTestimonialFeature');
    Route::get('get_pswd_req_resets', 'AdminController@getPswdResetLogs');
    Route::post('del_pswd_req/{id}', 'AdminController@delPswdResetLog');
    Route::get('all_enquiries', 'AdminController@getPaginatedEnquiries');
    Route::get('get_unread_enquiry_count', 'AdminController@getUnreadEnquiriesCount');
    Route::post('admin_del_enquiry/{id}', 'AdminController@delEnquiry');
    Route::get('get_enquiry/{id}', 'AdminController@getEnquiry');
    Route::post('enquiry_was_read/{id}', 'AdminController@enquiryRead');
    Route::get('get_paginated_offers', 'AdminController@getPgntdOffers');
    Route::post('delete_offer/{id}', 'AdminController@deleteOffer');
    Route::get('get_new_offer/{id}', 'AdminController@getNewOffer');
    Route::post('change_new_offer_apprv_status/{id}', 'AdminController@changeNewOfferApprvStatus');
    Route::post('change_new_offer_feat_status/{id}', 'AdminController@changeNewOfferFeatStatus');
    Route::post('search_for_offers', 'AdminController@searchForOffers');
    Route::post('search_for_enquiries', 'AdminController@searchForEnquiries');

});



