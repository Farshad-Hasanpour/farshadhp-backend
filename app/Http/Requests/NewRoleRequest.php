<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class NewRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
    	$role = auth()->user()->role;
    	return $role && $role->is_administrator();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
        	'name' => ['required', 'string', 'between:3,32', 'unique:App\Models\Role,name'],
        ];
    }
	
	protected function failedValidation(Validator $validator){
		throw new ValidationException($validator);
	}
}
