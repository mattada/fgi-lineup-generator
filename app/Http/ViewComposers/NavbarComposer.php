<?php
/**
 * Created by PhpStorm.
 * User: daltongibbs
 * Date: 9/16/16
 * Time: 1:57 PM
 */

namespace App\Http\ViewComposers;

use App\Content;
use \Illuminate\View\View;

class NavbarComposer
{
    public function compose(View $view)
    {
        $pgaTools = Content::pgaTools()->get();
        $euroTools = Content::euroTools()->get();
        $generalMenu = Content::generalMenu()->get();

        $view->with('pgaTools', $pgaTools)->with('euroTools', $euroTools)->with('generalMenu', $generalMenu);
    }
}