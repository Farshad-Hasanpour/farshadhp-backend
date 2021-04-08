<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
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
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'username' => ['required_without:email', 'string', 'exists:App\Models\User,username'],
			'email' => ['required_without:username', 'email', 'exists:App\Models\User,email'],
			'password' => ['required', 'string']
		];
    }
    
    public function validated(){
    	$validated = $this->validator->validated();
    	if(array_key_exists('username', $validated) && array_key_exists('email', $validated)){
    		unset($validated['email']);
		}
    	$validated['suspended'] = false;
    	return $validated;
	}
	
	protected function failedValidation(Validator $validator){
		throw new ValidationException($validator);
	}
}
