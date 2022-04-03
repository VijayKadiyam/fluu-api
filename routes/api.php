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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('me', 'MeController@me');

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/reset_password', 'Auth\ResetPasswordController@reset_password');
Route::post('login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');
Route::get('/logout', 'Auth\LoginController@logout');

Route::resource('roles', 'RolesController');
Route::resource('role_user', 'RoleUserController');

Route::resource('permissions', 'PermissionsController');
Route::resource('permission_role', 'PermissionRoleController');
Route::resource('permission_user', 'PermissionUserController');
Route::resource('assign_permissions', 'AssignPermissionsController');
Route::resource('unassign_permissions', 'UnAssignPermissionsController');

Route::get('users/masters', 'UsersController@masters');
Route::post('upload_user_image', 'UploadsController@uploadUserImage');
Route::post('upload_user_story', 'UploadsController@uploadUserStory');
Route::post('register-user-by-phone', 'UsersController@registerUserByPhone');
Route::resource('users', 'UsersController');


Route::resource('sites', 'SitesController');
Route::resource('site_user', 'siteUserController');

Route::resource('values', 'ValuesController');
Route::get('value_lists/masters', 'ValueListsController@masters');
Route::post('values/{value}/value_lists_multiple', 'ValueListsController@storeMultiple');
Route::resource('values/{value}/value_lists', 'ValueListsController');

// Login Question
Route::resource('login_questions', 'LoginQuestionsController');
Route::post('upload_login_questions', 'UploadsController@uploadLoginQuestionImage');
// User Login Question

Route::get('user_login_questions/masters', 'UserLoginQuestionsController@masters');
Route::resource('user_login_questions', 'UserLoginQuestionsController');

// User Stories
Route::get('user_stories/masters', 'UserStoriesController@masters');
Route::resource('user_stories', 'UserStoriesController');

// User Images
Route::post('upload_user_images', 'UploadsController@uploaduser_images');
Route::get('user_images/masters', 'UserImageController@masters');
Route::resource('user_images', 'UserImageController');

// User Notifications
Route::get('user_notifications/masters', 'UserNotificationsController@masters');
Route::resource('user_notifications', 'UserNotificationsController');



// Setting
Route::get('settings/{id}', 'SettingsController@show');
Route::resource('settings', 'SettingsController');
Route::post('upload_setting_banners', 'UploadsController@uploadBannerImage');
// // Upload Excell User
// Route::get('crude_users', 'CrudeUsersController@index');
// Route::post('upload_user', 'CrudeUsersController@uploadUser');
// Route::get('process_user', 'CrudeUsersController@processUser');
// Route::get('truncate_users', 'CrudeUsersController@truncate');

Route::post('send-otp-sms', 'SendSmsController@sendOtp');

//selfiep_photo_samples	
Route::post('upload_selfie_photo_samples', 'UploadsController@uploadSelfiePhotoSample');
//Route::get('selfie_photo_samples/masters', 'SelfiePhotoSamplesController@masters');
Route::resource('selfie_photo_samples', 'SelfiePhotoSamplesController');

// User SuperLike
Route::get('user_superlikes/masters', 'UserSuperlikesController@masters');
Route::resource('user_superlikes', 'UserSuperlikesController');
// User Swipe
Route::get('user_swipes/masters', 'UserSwipesController@masters');
Route::resource('user_swipes', 'UserSwipesController');
// User Matches
Route::get('user_matches/masters', 'UserMatchesController@masters');
Route::resource('user_matches', 'UserMatchesController');
// User Subscription
Route::get('user_subscriptions/masters', 'UserSubscriptionsController@masters');
Route::resource('user_subscriptions', 'UserSubscriptionsController');
