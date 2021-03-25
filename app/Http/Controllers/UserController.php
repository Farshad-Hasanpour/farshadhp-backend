<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class UserController{
	
	public function register(Request $request){
		$validator = Validator::make($request->all(), [
			'name' => ['required', 'string', 'between:2, 32'],
			'email' => ['required', 'email', 'unique:users'],
			'password' => ['required', 'confirmed', 'min:6']
		]);
		
		if($validator->stopOnFirstFailure()->fails()){
			return response()->json($validator->errors(), 422);
		}
		
		$user = User::create(array_merge(
			$validator.validated(),
			['password' => password_hash($request->password, PASSWORD_DEFAULT)]
		));
		
		return response()->json(['message' => 'User created successfully'], 201);
	}
	
	public function login(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'email'],
			'password' => ['required', 'string', 'min:6']
		]);
		if($validator->stopOnFirstFailure()->fails()){
			return response()->json($validator->errors(), 400);
		}
		
		if(!$token = $this->guard()->attempt($validator->validated())){
			return response()->json(['error' => 'unauthorized'], 401);
		}
		
		return $this->respondWithToken($token);
	}
	
	public function profile(){
		$user = $this->guard()->user();
		return response()->json([
			'success' => true,
			'message' => '',
			'code' => 200,
			'data' => $user
		], 200);
	}
	
	public function logout(){
		$this->guard()->logout();
		return response()->json([
			'success' => true,
			'message' => 'Successfully logged out',
			'code' => 200,
		]);
	}
	
	public function refresh(){
		return $this->respondWithToken($this->guard()->refresh());
	}
	
	protected function respondWithToken($token){
		return response()->json([
			'success' => true,
			'message' => 'logged in',
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
