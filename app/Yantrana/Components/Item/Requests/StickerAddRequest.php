<?php
/*
* StickerAddRequest.php - Request file
*
* This file is part of the Item component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Item\Requests;

use App\Yantrana\Base\BaseRequest;

class StickerAddRequest extends BaseRequest
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
     * Get the validation rules that apply to the add author client post request.
     *
     * @return bool
     *-----------------------------------------------------------------------*/
    public function rules()
    {
        $inputData = $this->all();

		$rules = [
			'title' 		=> 'required|min:3|max:150',
			'premium_price'	=> 'required|integer',
			'sticker_image' => 'required'
        ];
        
        // check if only for premium user checkbox checked
        if (!__ifIsset($inputData['is_for_premium_user'])) {
            $rules['normal_price'] = 'required|integer|gte:premium_price';
        }
		
        return $rules;
    }
}
