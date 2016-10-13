<?php

namespace App\Console\Commands;

use App\Plan;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportUsersFromCointentCSV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:import {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Users from Cointent CSV';

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
        if (($handle = fopen($this->argument('filepath'), 'r')) !== false) {
            $this->line('Reading data from file...');

            //--- Get first row
            $headers = fgetcsv($handle, 1000, ',');

            $keys = [];
            foreach ($headers as $header) {

                if ($header == 'Active') {

                    $keys[] = 'status';
                    continue;

                }

                $keys[] = Str::snake($header);

            }

            $count = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $line = array_combine($keys, $data);

                $plan = Plan::where('cointent_id', $line['plan_id'])->first();

                try {
                    User::create([
                        'email' => $line['email'],
                        'password' => bcrypt($line['email']),
                        'plan_id' => $plan->id
                    ]);
                } catch (\Exception $e) {
                    continue;
                }

                $count++;
            }

            $this->info("{$count} users imported");
        } else {
            $this->error('Cannot read file...');
        }
    }
}
