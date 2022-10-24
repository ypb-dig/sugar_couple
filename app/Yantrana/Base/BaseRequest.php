<?php 
namespace App\Yantrana\Base;

use App\Yantrana\__Laraware\Core\CoreRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

abstract class BaseRequest extends CoreRequest
{

 	protected function failedValidation(Validator $validator)
    {
    
        $response = [
            "success" => false,
            "message" => "Dados inválidos!",
            "errors" => $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }

}
