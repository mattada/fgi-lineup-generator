<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Dalton',
            'email' => 'dalton@activelogiclabs.com',
            'password' => bcrypt('dalton'),
            'plan_id' => 1,
            'status' => 'inactive'
        ]);
        
        User::create([
            'name' => 'Robert',
            'email'=> 'robert@activelogiclabs.com',
            'password' => bcrypt('robert'),
            'plan_id' => 2,
            'status' => 'inactive'
        ]);
    }
}
