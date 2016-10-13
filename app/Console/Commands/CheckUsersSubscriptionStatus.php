<?php

namespace App\Console\Commands;

use App\Jobs\CheckUserSubscriptionStatus;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;

class CheckUsersSubscriptionStatus extends Command
{

    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:check-status {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the subscription status of users.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($userId = $this->argument('user')) {
            
            $this->dispatch(new CheckUserSubscriptionStatus($userId));

            $this->info("Queued User: {$userId}");

            return;
            
        }

        $users = DB::table('users')->select('id')->where('is_admin', 0)->get();

        $this->output->progressStart(count($users));

        foreach ($users as $user) {

            $this->dispatch(new CheckUserSubscriptionStatus($user->id));

            $this->output->progressAdvance();

        }

        $this->output->progressFinish();
    }
}
