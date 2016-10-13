<?php

namespace App\Http\ViewComposers;

use App\Content;
use \Illuminate\View\View;

class ContentRightComposer
{
    public function compose(View $view)
    {
        $rightBarPages = Content::where('homepage_sidebar', 1)->orderBy('updated_at', 'DESC')->get();
        $view->with('rightbar_pages', $rightBarPages);
    }
}