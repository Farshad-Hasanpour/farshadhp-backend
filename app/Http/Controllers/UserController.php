<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterPostRequest;
use App\Http\Requests\LoginRequest;

class UserController{
	
	public function register(RegisterPostRequest $request){
		User::create($request->validated());
		return response()->json([
			'success' => true,
			'message' => __('auth.register'),
			'code' => 201,
		], 201);
	}
	
	public function login(LoginRequest $request){
		if(!$token = $this->guard()->attempt($request->validated())){
			return response()->json([
				'success' => false,
				'message' => __('auth.failed'),
				'code' => 401,
			], 401);
		}
		return $this->respondWithToken($token);
	}
	
	public function profile(){
		return response()->json([
			'success' => true,
			'message' => '',
			'code' => 200,
			'data' => $this->guard()->user()
		], 200);
	}
	
	public function logout(){
		$this->guard()->logout();
		return response()->json([
			'success' => true,
			'message' => __('auth.logout'),
			'code' => 200,
		]);
	}
	
	public function refresh(){
		return $this->respondWithToken($this->guard()->refresh(), __('auth.refresh'));
	}
	
	protected function respondWithToken($token, $message=''){
		if(!$message) $message = __('auth.login');
		return response()->json([
			'success' => true,
			'message' => $message,
			'code' => 200,
			'data' => [
				'access_token' => $token,
				'token_type' => 'bearer',
				'expires_in' => auth()->factory()->getTTL() * 60
			]
		], 200);
	}
	
	protected function guard(){
		return auth('api');
	}
}
