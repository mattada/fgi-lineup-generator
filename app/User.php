<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\App;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'cointent_id', 'cointent_passCode', 'status', 'plan_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //--- Relationships ---\\
    //region <--- Show

    public function plan()
    {
        return $this->belongsTo('App\Plan', 'plan_id');
    }

    //endregion


    //--- Accessors ---\\
    //region <--- Show

    public function getCointentUserIdAttribute()
    {
        if (!empty($this->cointent_id)) {

            return $this->cointent_id;

        }

        $cointent = App::make('Cointent');

        $result = $cointent->getUserPasscode($this->email);

        if ($result->status == 'success') {

            $this->cointent_id = $result->queriedUser->userId;

            $this->save();

            return $this->cointent_id;

        }

        return null;
    }

    //endregion

    public function scopeExcludeAdmin($query)
    {
        return $query->where('is_admin', 0);
    }

}
