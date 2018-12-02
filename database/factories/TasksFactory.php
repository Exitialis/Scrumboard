<?php

use Faker\Generator as Faker;
use App\Models\Task;

$factory->define(Task::class, function (Faker $faker) {
  return [
    'name' => $faker->word,
    'description' => $faker->text(200),
    'status' => Task::CREATED,
  ];
});

$factory->state(Task::class, 'done', function (Faker $faker) {
  return [
    'status' => Task::DONE,
  ];
});
