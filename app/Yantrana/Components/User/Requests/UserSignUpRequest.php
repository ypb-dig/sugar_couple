<?php
/*
* UserSignUpRequest.php - Request file
*
* This file is part of the User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\User\Requests;

use App\Yantrana\Base\BaseRequest;
use Carbon\Carbon;

class UserSignUpRequest extends BaseRequest
{
	/**
     * Secure form.
     *------------------------------------------------------------------------ */
	protected $securedForm = true;

	/**
     * Unsecured/Unencrypted form fields.
     *------------------------------------------------------------------------ */
    protected $unsecuredFields = ['first_name', 'last_name'];
	
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the user register request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function rules()
    {
        return [
            'first_name'        => 'nullable|min:3|max:45',
            'last_name'         => 'nullable|min:3|max:45',
            'username'          => 'required|min:3|max:45|unique:users,username',
            'mobile_number'     => 'required|max:15|unique:users,mobile_number',
            'email'             => 'required|email|unique:users,email',
            'repeat_email'      => 'required|email|same:email',
            'password'          => 'required|min:6|max:30',
            'gender'          	=> 'required',
            'repeat_password'   => 'required|min:6|max:30|same:password',
            'dob'				=> 'sometimes|validate_age',
            'accepted_terms' 	=> 'required'
        ];
    }

    /**
     * Get the validation rules that apply to the user register request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function messages()
    {
    	$ageRestriction = configItem('age_restriction');

        return [
            'dob.validate_age'    => strtr('Você deve ter mais de 18 anos para se cadastrar', [
            	'__min__' => $ageRestriction['minimum'],
            	'__max__' => $ageRestriction['maximum'],
            ]),
            'accepted_terms.required' => "Por favor, leia e aceite os termos de condições antes de continuar.",
            'mobile_number.unique' => "Este número já esta sendo utilizado.",
            'username.unique' => "Este nome de usuário já esta sendo utilizado.",
            'email.unique' => "Este email já esta sendo utilizado.",
            'repeat_password.same' => "Senha não confere com a digitada no campo anterior.",
            'repeat_email.same' => "Email não confere com o digitado no campo anterior. ",
            'repeat_email.required' => "Email não confere com o digitado no campo anterior. "

        ];
    }

}
