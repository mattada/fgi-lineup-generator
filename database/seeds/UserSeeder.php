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
            'name' => 'juice',
            'email' => 'juice.johnson@gmail.com',
            'password' => bcrypt('juice'),
            'plan_id' => 1,
            'status' => 'active'
        ]);
    }
}
