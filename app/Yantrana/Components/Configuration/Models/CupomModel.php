<?php
/*
* CupomModel.php - Model file
*
* This file is part of the Cupom component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\Configuration\Models;

use App\Yantrana\Base\BaseModel;

class CupomModel extends BaseModel 
{ 
    /**
     * @var  string $table - The database table used by the model.
     */
    protected $table = "cupom";
   
    /**
     * @var  array $fillable - The attributes that are mass assignable.
     */
    protected $fillable = [
    	'name', 'percentage', 'plan'
    ];
}