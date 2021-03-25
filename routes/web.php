<?php

use Illuminate\Support\Facades\Route;
use App\Models\Role;
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
    $roles = Role::withCount('users')->get();
    foreach ($roles as $role) {
        echo $role->name . ' role has ' . $role->users_count . ' users <br>';
    }
});
