<?php

use Faker\Generator as Faker;
use App\Models\Task;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'name' => $faker->jobTitle,
        'description' => $faker->text(200),
        'status' => Task::CREATED,
    ];
});
