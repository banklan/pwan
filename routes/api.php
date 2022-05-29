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
    // Route::get('download_subscr_form/{id}', 'SubscriptionController@downloadForm');
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

});



