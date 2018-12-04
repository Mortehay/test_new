<?php

use Faker\Generator as Faker;

$factory->define(App\Companies::class, function (Faker $faker) {
    return [
        'name' =>$faker->company,
        'email' =>$faker->companyEmail,
        'logo' =>$faker->randomNumber(5, true) . '.jpg'
    ];
});
