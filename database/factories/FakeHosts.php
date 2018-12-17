<?php

use Faker\Generator as Faker;

$factory->define(App\TableHostAccess::class, function (Faker $faker) {
    $hosting_type = ['hosting', 'domain' ,'hosting+domain'];
    $randomId = array_rand($hosting_type );

    return [
        'main_name' =>$faker->company,
        'main_name_link' =>$faker->url,
        'hosting_name' =>$faker->url,
        'hosting_link' =>$faker->url,
        'hosting_type' =>$hosting_type[$randomId],
        'hosting_login' =>$faker->name,
        'hosting_pass' =>$faker->password,
        'comment' =>$faker->text(200),
    ];
});