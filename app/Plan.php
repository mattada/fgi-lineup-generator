<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{


    //--- Relationships ---\\
    //region <--- Show

    public function User()
    {
        return $this->hasMany('App\User');
    }

    //endregion

}
