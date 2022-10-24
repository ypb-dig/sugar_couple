<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotoComments extends Model
{
    public function owner_user()
	{
	    return $this->hasOne('App\User', "_id",  "owner");
	}

	 public function by_user()
	{
	    return $this->hasOne('App\User', "_id", "by");
	}
}
