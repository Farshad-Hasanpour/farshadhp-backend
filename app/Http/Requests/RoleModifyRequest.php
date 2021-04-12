<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class RoleModifyRequest extends FormRequest{
	/**
	 * Indicates if the validator should stop on the first rule failure.
	 *
	 * @var bool
	 */
	protected $stopOnFirstFailure = true;
	
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
    	$boolean_privilege = ['nullable', 'boolean'];
        return [
			'name' => ['nullable', 'string', 'between:3,32'],
			'articles_modify' => $boolean_privilege,
			'articles_submit' => $boolean_privilege,
			'articles_modify_others' => $boolean_privilege,
        ];
    }
	
	protected function failedValidation(Validator $validator){
		throw new ValidationException($validator);
	}
}
