<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Article;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Article $article)
    {
        if (!empty($user->plan_id)) {

            if ($user->plan->group == 'pro')
            {
                return true;
            }

            if ($article->subscription_group == 'fgi_euro') {

                if (in_array($user->plan->group, ['fgi', 'euro'])) {
                    return true;
                }

            }

            if ($user->plan->group == $article->subscription_group) {
                return true;
            }

        }

        return false;
    }

}
