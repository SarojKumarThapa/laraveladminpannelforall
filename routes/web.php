<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
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
Route::get('/', function () {
    return view('welcome');

});

// Auth::routes();

Route::prefix('/admin')->namespace('Admin')->group(function() {
	//All the admin routes will be defined here :-

	Route::match(['get', 'post'], '/', [AdminController::class, 'login']);
	Route::group(['middleware'=>['admin']], function(){
		Route::get('dashboard', [AdminController::class, 'dashboard']);
		Route::get('settings', [AdminController::class, 'settings']);
		Route::get('logout', [AdminController::class, 'logout']);
		Route::post('check-current-pwd', [AdminController::class, 'chkCurrentPassword']);
		Route::post('update-current-pwd', [AdminController::class, 'updateCurrentPassword']);
		Route::match(['get', 'post'], 'update-admin-details', [AdminController::class, 'updateAdminDetails']);
	});
});

