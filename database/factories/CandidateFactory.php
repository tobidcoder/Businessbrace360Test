<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Candidate;
use Faker\Generator as Faker;

$factory->define(Candidate::class, function (Faker $faker) {

    return [
        'email' => $faker->word,
        'username' => $faker->word,
        'first_name' => $faker->word,
        'last_name' => $faker->word,
        'password' => $faker->word,
        'address' => $faker->word,
        'phone_number' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
