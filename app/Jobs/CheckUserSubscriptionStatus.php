<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;

class CheckUserSubscriptionStatus extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $userId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cointent = App::make('Cointent');

        $user = User::find($this->userId);

        if ($user) {

            $result = $cointent->checkUnlockStatus($user->plan->article_id, $user->email);
            
            if ($result->gating->access) {

                $user->update(['status' => 'active']);

            } else {

                $user->update(['status' => 'inactive']);

            }

        }
    }
}
