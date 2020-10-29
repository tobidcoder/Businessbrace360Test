<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {

    return [
        'title' => $faker->word,
        'description' => $faker->text,
        'responsibility' => $faker->word,
        'qualification' => $faker->word,
        'remuneration' => $faker->word,
        'employment_type' => $faker->word,
        'job_function' => $faker->word,
        'industry' => $faker->word,
        'seniority_level' => $faker->word,
        'pay_range' => $faker->word,
        'jobs_status' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
