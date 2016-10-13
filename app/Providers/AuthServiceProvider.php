<?php

namespace App\Providers;

use App\Article;
use App\Content;
use App\Policies\ArticlePolicy;
use App\Policies\ContentPolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Content::class => ContentPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        Gate::define('view-page', function($user, $page) {

            if (!empty($user->plan_id) and $user->plan->group == 'pro') {

                return true;

            }

            switch ($page) {
                case 'ownership-percentage-predictions':

                    if (!empty($user->plan) and $user->plan->group == 'fgi') {
                        return true;
                    }

                    break;

                case 'lineup-generator':

                    if (!empty($user->plan) and $user->plan->group == 'fgi') {
                        return true;
                    }

                    break;
            }

            return false;
        });
    }
}
