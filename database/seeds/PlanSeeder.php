<?php

use Illuminate\Database\Seeder;
use App\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create([
            'cointent_id' => 4,
            'title' => 'FGI Monthly',
            'status' => 'active',
            'group' => 'fgi',
            'article_id' => 6279
        ]);

        Plan::create([
            'cointent_id' => 5,
            'title' => 'FGI Annual',
            'status' => 'active',
            'group' => 'fgi',
            'article_id' => 6279
        ]);

        Plan::create([
            'cointent_id' => 11,
            'title' => 'Euro Tour Monthly',
            'status' => 'active',
            'group' => 'euro',
            'article_id' => 6173
        ]);

        Plan::create([
            'cointent_id' => 12,
            'title' => 'Euro Tour Annual',
            'status' => 'active',
            'group' => 'euro',
            'article_id' => 6279
        ]);

        Plan::create([
            'cointent_id' => 13,
            'title' => 'Pro Pack (FGI+Euro+PGADFS) Month',
            'status' => 'active',
            'group' => 'pro',
            'article_id' => 6279
        ]);

        Plan::create([
            'cointent_id' => 13,
            'title' => 'Pro Pack (FGI+Euro+PGADFS) Annual',
            'status' => 'active',
            'group' => 'pro',
            'article_id' => 6279
        ]);
    }
}
