<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use App\TableAdditionalDomains;

$factory->define(App\TableAdditionalDomains::class, function (Faker $faker) {
    $hostIds = \App\TableHostAccess::where('id' ,'>' ,0)->pluck('id')->toArray();

    $randomId = array_rand($hostIds );

    return [
        'main_id' =>$hostIds[$randomId],
        'additional_domain' =>$faker->url,

    ];
});