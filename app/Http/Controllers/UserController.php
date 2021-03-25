<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController{
	
	function index(){
		return null;
	}
	
	function login(Request $request){
		$username = $request->input('username', null);
		$password = $request->input('password', null);

		if(!$username || !$password){
			return ['error' => 'test'];
		}
		
		return new UserResource(User::username($username)->first());
	}
}
