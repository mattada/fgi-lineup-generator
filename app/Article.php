<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{


    public function scopeBySlug($query, $slug)
    {
        return $query->where('title_slug', $slug);
    }
}
