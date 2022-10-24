<?php
/*
* UserItemModel.php - Model file
*
* This file is part of the Item component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Item\Models;

use App\Yantrana\Base\BaseModel;

class UserItemModel extends BaseModel
{
    /**
     * @var string - The database table used by the model.
     */
    protected $table = 'user_items';

    /**
     * @var array - The attributes that should be casted to native types..
     */
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'type' => 'integer',
        'users__id' => 'integer',
        'users__id' => 'items__id',
        'price' => 'float'
    ];

    /**
     * @var array - The attributes that are mass assignable.
     */
    protected $fillable = [];
}
