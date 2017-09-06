<?php

use Illuminate\Database\Seeder;
use App\Slate;

class SlateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Slate::create([
        //   'name' => "PGA"
        // ]);

        // Slate::create([
        //   'name' => "Euro"
        // ]);

        // Slate::create([
        //   'name' => "FD"
        // ]);

        Slate::create([
          'name' => "DK NFL Main"
        ]);

        Slate::create([
          'name' => "DK NFL THU-MON"
        ]);

        Slate::create([
          'name' => "FD NFL Main"
        ]);

        Slate::create([
          'name' => "FD NFL THU-MON"
        ]);
    }
}