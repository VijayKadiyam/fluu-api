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
Route::post('upload_psc_inspection_report', 'UploadsController@uploadPscInspectionReport');
Route::post('upload_sire_inspection_attachment', 'UploadsController@uploadSireInspectionAttachment');
Route::post('upload_terminal_inspection_report', 'UploadsController@uploadTerminalInspectionReport');
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
Route::post('vessels/{vessel}/sire_inspections/{sireinspection}', 'SireInspectionsController@store');
Route::get('psc_inspections/masters', 'PscInspectionsController@masters');
Route::get('sire_inspections/masters', 'SireInspectionsController@masters');
Route::resource('psc_inspections', 'PscInspectionsController');
Route::resource('vessels/{vessel}/sire_inspections', 'SireInspectionsController');
Route::resource('vessels/{vessel}/psc_inspections', 'PscInspectionsController');
Route::get('ports/masters', 'PortsController@masters');
Route::resource('ports', 'PortsController');
Route::get('terminal_inspections/masters', 'TerminalInspectionsController@masters');
Route::resource('vessels/{vessel}/terminal_inspections', 'TerminalInspectionsController');
Route::resource('terminal_inspections', 'TerminalInspectionsController');

// FSC Inspections Routes
Route::post('upload_fsc_inspection_report', 'UploadsController@uploadFscInspectionReport');
Route::post('vessels/{vessel}/fsc_inspections/{fscinspection}', 'FscInspectionsController@store');
Route::get('fsc_inspections/masters', 'FscInspectionsController@masters');
Route::resource('fsc_inspections', 'FscInspectionsController');
Route::resource('vessels/{vessel}/fsc_inspections', 'FscInspectionsController');

// Near Miss Inspections Routes
// Route::post('upload_near_misses_report', 'UploadsController@uploadFscInspectionReport');
Route::post('vessels/{vessel}/near_misses/{nearmiss}', 'NearMissesController@store');
Route::get('near_misses/masters', 'NearMissesController@masters');
Route::resource('near_misses', 'NearMissesController');
Route::resource('vessels/{vessel}/near_misses', 'NearMissesController');