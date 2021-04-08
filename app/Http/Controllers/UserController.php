<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Http\Requests\RegisterPostRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\EmailChangeRequest;
use App\Http\Requests\PersonalInfoChangeRequest;
use App\Http\Requests\AvatarPutRequest;

use Cloudinary\Api\Upload\UploadApi;

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
		if(!$token = $this->guard()->attempt($request->validated())) api_response(401, __('auth.failed'));
		$this->guard()->user()->abortIfSuspended();
		return api_response(200, __('auth.login'), [
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => $this->guard()->factory()->getTTL() * 60
		]);
	}
	
	public function profile(){
		return api_response(200, __('auth.logout'), [
			$this->guard()->user()
		]);
	}
	
	public function logout(){
		$this->guard()->logout();
		return api_response(200, __('auth.logout'));
	}
	
	public function refresh(){
		$this->guard()->user()->abortIfSuspended();
		return api_response(200, __('auth.refresh'), [
			'access_token' => $this->guard()->refresh(),
			'token_type' => 'bearer',
			'expires_in' => $this->guard()->factory()->getTTL() * 60
		]);
	}
	
	public function find(User $user){
		$user_role = $this->guard()->user()->role;
		if( !( $user_role && $user_role->is_administrator() ) ) abort(403, __('auth.unauthorized'));
		return api_response(200, '',
			[
				'users' => $user->id ? [$user->toArray()] : User::all()->toArray()
			]
		);
		
	}
	
	public function change_password(PasswordChangeRequest $request){
		$validated = $request->validated();
		$user = $this->guard()->user();
		$user->password = $validated['new_password'];
		$user->save();
		return api_response(200, __('passwords.change'));
	}
	
	public function suspend(User $user){
		$user_role = $this->guard()->user()->role;
		if( !( $user_role && $user_role->is_administrator() ) ) abort(403, __('auth.unauthorized'));
		$user->suspended = true;
		$user->save();
		return api_response(200, __('user.suspend'));
	}
	public function unsuspend(User $user){
		$user_role = $this->guard()->user()->role;
		if( !( $user_role && $user_role->is_administrator() ) ) abort(403, __('auth.unauthorized'));
		$user->suspended = false;
		$user->save();
		return api_response(200, __('user.unsuspend'));
	}
	
	public function change_email(EmailChangeRequest $request){
		$validated = $request->validated();
		$user = $this->guard()->user();
		$user->email = $validated['email'];
		$user->save();
		return api_response(200, __('user.email_change'));
	}
	
	public function change_personal_info(PersonalInfoChangeRequest $request){
		$validated = $request->validated();
		$user = $this->guard()->user();
		$fillable = [
			'name' => 'name',
			'gender' => 'gender',
			'location' => 'location',
			'birthday' => 'birthday',
			'website' => 'website',
			'bio' => 'bio',
			'github' => 'social_github',
			'whatsapp' => 'social_whatsapp',
			'telegram' => 'social_telegram',
			'twitter' => 'social_twitter',
			'linkedin' => 'social_linkedin',
			'instagram' => 'social_instagram'
		];
		foreach($fillable as $field => $db_attribute ){
			if(!array_key_exists($field, $validated)) continue; // skip if field is not fillable
			$value = $validated[$field];
			if($value == '') $value = null;
			$user[$db_attribute] = $value;
		}
		$user->save();
		return api_response(200, __('user.personal_info_change'));
	}
	
	public function put_avatar(AvatarPutRequest $request, UploadApi $cloudinary){
		// Maximum size is 500Kb in validator
		$base64 = ($request->validated())['avatar'];
		$result = $cloudinary->upload($base64, [
			"public_id" => $this->avatar_public_id(),
			"resource_type" => "image",
			'format' => 'jpg',
			'allowed_formats' => ['jpg'],
			'overwrite' => true,
			'transformation' => 'ar_1.0,q_auto:good,c_crop,g_face'// aspect ratio 1, crop face,
		]);
		if(!$result['url']) abort(424, __('user.avatar.upload_unsuccessful'));
		$user = $this->guard()->user();
		$user->avatar = $result['url'];
		$user->save();
		return api_response(200, __('user.avatar.upload_successful'));
	}
	
	public function delete_avatar(UploadApi $cloudinary){
		$user = $this->guard()->user();
		if(!$user->avatar) return api_response(200, __('user.avatar.delete_successful'));
		$result = $cloudinary->destroy($this->avatar_public_id());
		if(!$result->result == 'ok') abort(424, __('user.avatar.delete_unsuccessful'));
		return api_response(200, __('user.avatar.delete_successful'));
	}
	
	protected function guard(){
		return auth('api');
	}
	
	protected function avatar_public_id(){
		return 'avatars/' . $this->guard()->user()->username;
	}
}
