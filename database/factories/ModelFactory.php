<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Player::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'salary' => $faker->numberBetween(0,15000),
        'draft_kings_id' => $faker->numberBetween(10000,99999),
        'zach_prediction' => $faker->numberBetween(0, 100),
        'jeff_prediction' => $faker->numberBetween(0, 100)
    ];
});

$factory->define(\App\Content::class, function (Faker\Generator $faker) {
    return [
        'title' => implode(" ", $faker->words(3)),
        'preview' => $faker->sentence(15, true),
        'content' => $faker->paragraphs(5, true),
    ];
});

$factory->defineAs(\App\Content::class, 'article', function($faker) use ($factory){
    $content = $factory->raw(\App\Content::class);

    $article = array(
        'type' => 'article',
        'subscription_group' => $faker->randomElement(['fgi', 'euro', 'pro']),
        'section' => 'expert',
        'featured' => $faker->boolean(1)
    );

    return array_merge($content, $article);
});

$factory->defineAs(\App\Contact::class, 'page', function($faker) use($factory){
    $content = $factory->raw(\App\Content::class);

    $page = array(
        'type' => 'page'
    );

    return array_merge($content, $page);
});