<?php

use Illuminate\Database\Seeder;
use App\Slate;

class SeedSlates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slate::create([
          'name' => "PGA"
        ]);

        Slate::create([
          'name' => "Euro"
        ]);
    }
}
