<?php

use Illuminate\Database\Seeder;

class AddFakeHosts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TableHostAccess::class, 50)->create();
    }
}
