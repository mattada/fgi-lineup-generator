<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $guarded = [];

    protected $appends = ['weight', 'combined_prediction'];

    public function getWeightAttribute(){
        return 0;
    }

    public function getCombinedPredictionAttribute()
    {
        $avg = ($this->zach_prediction + $this->jeff_prediction) / 2;

        return $avg;
    }

}
