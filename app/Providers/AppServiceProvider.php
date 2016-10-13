<?php

namespace App\Providers;

use App\Content;
use App\Services\Cointent;
use Illuminate\Http\Middleware\FrameGuard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Cointent
        $this->app->singleton('Cointent', Cointent::class);

        // Create title slug
        Content::saving(function($content){
            $content->title_slug = Str::slug($content->title);
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){ }
}
