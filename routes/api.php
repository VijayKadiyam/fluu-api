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

Route::get('users/masters', 'UsersController@masters');
Route::post('upload_user_image', 'UploadsController@uploadUserImage');
Route::post('upload_psc_inspection_report', 'UploadsController@uploadPscInspectionReport');
Route::resource('users', 'UsersController');


Route::resource('sites', 'SitesController');
Route::resource('site_user', 'siteUserController');

Route::resource('values', 'ValuesController');
Route::get('value_lists/masters', 'ValueListsController@masters');
Route::post('values/{value}/value_lists_multiple', 'ValueListsController@storeMultiple');
Route::resource('values/{value}/value_lists', 'ValueListsController');

// Upload Excell User
Route::get('crude_users', 'CrudeUsersController@index');
Route::post('upload_user', 'CrudeUsersController@uploadUser');
Route::get('process_user', 'CrudeUsersController@processUser');
Route::get('truncate_users', 'CrudeUsersController@truncate');


Route::resource('viq_chapters', 'ViqChaptersController');
Route::get('near_misses/masters', 'NearMissesController@masters');
Route::resource('near_misses', 'NearMissesController');

Route::get('vessels/masters', 'VesselsController@masters');
Route::resource('vessels', 'VesselsController');

Route::post('vessels/{vessel}/psc_inspections/{pscinspection}', 'PscInspectionsController@store');
Route::get('psc_inspections/masters', 'PscInspectionsController@masters');
Route::get('sire_inspections/masters', 'SireInspectionsController@masters');
Route::resource('psc_inspections', 'PscInspectionsController');
Route::resource('vessels/{vessel}/sire_inspections', 'SireInspectionsController');
Route::resource('vessels/{vessel}/psc_inspections', 'PscInspectionsController');
