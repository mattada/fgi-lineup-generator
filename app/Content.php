<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{


    public function scopeBySlug($query, $slug)
    {
        return $query->where('title_slug', $slug);
    }

    public function scopeArticle($query)
    {
        return $query->where('type', 'article');
    }

    public function scopeBySection($query, $section)
    {
        return $query->where('section', $section);
    }

    public function scopeExpertColumns($query)
    {
        return $query->where('section', 'expert');
    }

    public function scopeStrategyColumns($query)
    {
        return $query->where('section', 'strategy');
    }

    public function scopePreviewArticle($query)
    {
        return $query->where('section', 'preview');
    }

    public function scopeFeaturedVideo($query)
    {
        return $query->where('section', 'featured_video');
    }

    public function scopeFantasyFocus($query)
    {
        return $query->where('section', 'fantasy_focus');
    }

    public function scopeBreakingNews($query)
    {
        return $query->where('section', 'breaking');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function scopeNotFeatured($query)
    {
        return $query->whereNull('featured');
    }

    public function getPublishDateAttribute()
    {
        return $this->created_at;
    }

    public function scopePgaTools($query)
    {
        return $query->where('dropdown_menu', 'pga_tools')->orWhere('dropdown_menu', 'pga_euro');
    }

    public function scopeEuroTools($query)
    {
        return $query->where('dropdown_menu', 'euro_tools')->orWhere('dropdown_menu', 'pga_euro');
    }

    public function scopeGeneralMenu($query)
    {
        return $query->where('dropdown_menu', 'general');
    }

}
