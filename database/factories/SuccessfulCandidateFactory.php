<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SuccessfulCandidate;
use Faker\Generator as Faker;

$factory->define(SuccessfulCandidate::class, function (Faker $faker) {

    return [
        'job_id' => $faker->word,
        'candidate_id' => $faker->word,
        'pass_mark' => $faker->word,
        'employed' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
