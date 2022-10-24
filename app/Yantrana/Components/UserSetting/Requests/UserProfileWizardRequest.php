<?php
/*
* UserProfileWizardRequest.php - Request file
*
* This file is part of the User component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\UserSetting\Requests;

use App\Yantrana\Base\BaseRequest;
use Carbon\Carbon;

class UserProfileWizardRequest extends BaseRequest
{
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

    	$date = appTimezone(Carbon::now());

        return [
            'gender'    => 'required',
            'birthday'		=> 'required|validate_age',
            'looking_for'    => 'required',

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
            'birthday.validate_age'    => strtr('Age must be between __min__ and __max__ years', [
            	'__min__' => $ageRestriction['minimum'],
            	'__max__' => $ageRestriction['maximum'],
            ]),
        ];
    }
}
