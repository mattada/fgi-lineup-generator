<?php

namespace App\Jobs;

use App\Plan;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportUser implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $plan = Plan::where('cointent_id', $this->data['plan_id'])->first();

        $userSearch = [
            'email' => $this->data['email']
        ];

        $userData = $userSearch;

        $userData['plan_id'] = $plan->id;
        $userData['password'] = bcrypt($this->data['email']);
        $userData['status'] = 'active';

        User::unguard();
        User::updateOrCreate($userSearch, $userData);
    }
}
