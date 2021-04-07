<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
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
	Route::get('logout', [UserController::class, 'logout']);
	Route::get('refresh', [UserController::class, 'refresh']);
	Route::get('profile', [UserController::class, 'profile']);
	// Role
	Route::get('roles/{role?}', [RoleController::class, 'find']);
	Route::post('roles', [RoleController::class, 'create']);
	Route::patch('roles/{role}', [RoleController::class, 'modify']);
	Route::delete('roles/{role}', [RoleController::class, 'delete']);
});
