<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FirstUserTableSeeder::class);
        $this->call(AddFakeCompanies::class);
        $this->call(FirstUserTableSeeder::class);
    }
}
