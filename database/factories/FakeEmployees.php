<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;
use App\Companies;


$factory->define(App\Employees::class, function (Faker $faker) {
    $employeesIds = Companies::where('id' ,'>' ,0)->pluck('id')->toArray();

    $randomId = array_rand($employeesIds );

    return [
       'first_name' =>$faker->name,
        'last_name' =>$faker->lastName,
        'company_id' =>$employeesIds[$randomId],
        'email' =>$faker->email,
        'phone' =>$faker->phoneNumber
    ];
});
