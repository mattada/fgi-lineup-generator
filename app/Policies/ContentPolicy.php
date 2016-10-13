<?php

namespace App\Policies;

use App\Content;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        $test = true;
    }

    public function view(User $user, Content $content)
    {
        if (!empty($user->plan_id)) {

            if ($user->plan->group == 'pro')
            {
                return true;
            }

            if ($content->subscription_group == 'fgi_euro') {

                if (in_array($user->plan->group, ['fgi', 'euro'])) {
                    return true;
                }

            }

            if ($user->plan->group == $content->subscription_group) {
                return true;
            }

        }

        return false;
    }

    public function viewAny(User $user)
    {
        return true;
    }
}
