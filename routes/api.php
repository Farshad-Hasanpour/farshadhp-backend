<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\FileController;

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

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {
	// User
	Route::get('logout', [UserController::class, 'logout']);	// TODO:http method??
	Route::get('refresh', [UserController::class, 'refresh']);	// TODO:http method??
	Route::get('profile', [UserController::class, 'profile']);
	Route::patch('password', [UserController::class, 'change_password']);
	Route::patch('email', [UserController::class, 'change_email']);
	Route::get('suspend/{user}', [UserController::class, 'suspend']); 	// TODO:http method??
	Route::get('unsuspend/{user}', [UserController::class, 'unsuspend']);	// TODO:http method??
	Route::patch('personal_info', [UserController::class, 'change_personal_info']);
	Route::put('avatar', [UserController::class, 'put_avatar']);
	Route::delete('avatar', [UserController::class, 'delete_avatar']);
	// Role
	Route::get('roles/{role?}', [RoleController::class, 'find']);
	Route::post('roles', [RoleController::class, 'create']);
	Route::patch('roles/{role}', [RoleController::class, 'modify']);
	Route::delete('roles/{role}', [RoleController::class, 'delete']);
	// Files
//	Route::get('files/{file?}', [FileController::class, 'find']);
//	Route::post('files', [RoleController::class, 'create']);
//	Route::patch('files/{file}', [RoleController::class, 'modify']);
//	Route::delete('files/{file}', [RoleController::class, 'delete']);

});
