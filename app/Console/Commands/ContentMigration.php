<?php

namespace App\Console\Commands;

use App\Jobs\MigratePages;
use App\Jobs\MigratePosts;
use App\Traits\DatabaseRoutingTrait;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class ContentMigration extends Command
{

    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate old content into new system';

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
        $job = new MigratePosts();
//        $this->dispatch($job);
        $job->handle();

        $job = new MigratePages();
//        $this->dispatch($job);
        $job->handle();
    }
}
