<?php

namespace App\Yantrana\Components\User\Models;

use App\Yantrana\Base\BaseModel;

class LoginAttempt extends BaseModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
	protected $table = 'login_attempts';
	
	/**
     * The generate UID or not
     *
     * @var string
     *----------------------------------------------------------------------- */
    
    protected $isGenerateUID = false;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'attempts' => 'integer',
    ];

}
