<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Sprint::class, function (Faker $faker) {
    return [
        'name' => $faker->domainName,
    ];
});
