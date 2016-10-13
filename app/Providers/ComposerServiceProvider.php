<?php
/**
 * Created by PhpStorm.
 * User: daltongibbs
 * Date: 9/16/16
 * Time: 2:00 PM
 */

namespace App\Providers;

use App\Http\ViewComposers\ContentRightComposer;
use App\Http\ViewComposers\NavbarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('partials.nav-bar', NavbarComposer::class);
        View::composer('partials.content-right', ContentRightComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}