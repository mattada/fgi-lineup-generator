<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PlanSeeder::class);
        // $this->call(UserSeeder::class);
        // $this->call(ContentSeeder::class);
        // $this->call(PlayerSeeder::class);
        $this->call(SlateSeeder::class);
    }
}
