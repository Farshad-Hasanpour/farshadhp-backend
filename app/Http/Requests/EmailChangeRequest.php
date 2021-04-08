<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class EmailChangeRequest extends FormRequest{
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
            'email' => ['required', 'email', 'unique:App\Models\User,email']
        ];
    }
	
	protected function failedValidation(Validator $validator){
		throw new ValidationException($validator);
	}
}
