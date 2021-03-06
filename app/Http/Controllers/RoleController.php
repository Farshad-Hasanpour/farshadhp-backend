<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewRoleRequest;
use App\Http\Requests\RoleModifyRequest;
use App\Models\Role;

class RoleController{
	public function create(NewRoleRequest $request){
		$role = Role::create($request->validated());
		return api_response(201, __('role.create'), ['id' => $role->id]);
	}
	
	public function modify(RoleModifyRequest $request, Role $role){
		$validated = $request->validated();
		$fillable = [
			'name' => 'name',
			'articles_modify' => 'articles_modify',
			'articles_submit' => 'articles_submit',
			'articles_modify_others' => 'articles_modify_others',
		];
		foreach($fillable as $field => $db_attribute ){
			if(!array_key_exists($field, $validated)) continue; // skip if field is not fillable
			$value = $validated[$field];
			if($value == '') $value = null;
			$role[$db_attribute] = $value;
		}
		$role->save();
		return api_response(200, __('role.modify'));
	}
	
	public function find(Role $role){
		$user_role = $this->guard()->user()->role;
		if( !( $user_role && $user_role->is_administrator() ) ) abort(403, __('auth.unauthorized'));
		return api_response(200, '',
			[
				'roles' => $role->id ? [$role->toArray()] : Role::all()->toArray()
			]
		);
	}
	
	public function delete(Role $role){
		$user_role = $this->guard()->user()->role;
		if( !( $user_role && $user_role->is_administrator() ) ) abort(403, __('auth.unauthorized'));
		$role->delete();
		return api_response(200, __('role.delete'));
	}
}
