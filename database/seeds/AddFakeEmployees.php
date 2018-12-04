<?php

use Illuminate\Database\Seeder;

class AddFakeEmployees extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Employees::class, 200)->create();
    }
}
