<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use \Illuminate\Validation\ValidationException;

class PersonalInfoChangeRequest extends FormRequest{
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
    	$socials = ['nullable', 'url', 'max:64'];
        return [
        	'name' => ['nullable', 'string', 'max:64'],
			'gender' => ['nullable', 'in:male,female'],
			'birthday' => ['nullable', 'date_format:y-m-d'],
			'location' => ['nullable', 'string', 'max:128'],
			'website' => ['nullable', 'url', 'max:255'],
			'whatsapp' => ['nullable', 'url', 'max:15'],
			'github' => $socials,
			'telegram' => $socials,
			'linkedin' => $socials,
			'twitter' => $socials,
			'instagram' => $socials,
        ];
    }
	
	protected function failedValidation(Validator $validator){
		throw new ValidationException($validator);
	}
}
