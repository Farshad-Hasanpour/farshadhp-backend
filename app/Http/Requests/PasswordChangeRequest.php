<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class PasswordChangeRequest extends FormRequest{
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
    	return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(){
        return [
            'old_password' => ['required', 'string', 'password'],
			'new_password' => ['required', 'string', 'min:6']
        ];
    }
	
	public function validated(){
		$validated = $this->validator->validated();
		unset($validated['old_password']);
		$validated['new_password'] = password_hash($validated['new_password'], PASSWORD_DEFAULT);
		return $validated;
	}
	
	protected function failedValidation(Validator $validator){
		throw new ValidationException($validator);
	}
}
