<?php
/*
* CreditPackage.php - Model file
*
* This file is part of the CreditPackage component.
*-----------------------------------------------------------------------------*/

namespace App\Yantrana\Components\CreditPackage\Models;

use App\Yantrana\Base\BaseModel;

class CreditPackageModel extends BaseModel 
{ 
    /**
     * @var  string $table - The database table used by the model.
     */
    protected $table = "credit_packages";
    
    /**
     * @var  array $casts - The attributes that should be casted to native types.
     */
    protected $casts = [
    ];

    /**
     * @var  array $fillable - The attributes that are mass assignable.
     */
    protected $fillable = [
    ];

}