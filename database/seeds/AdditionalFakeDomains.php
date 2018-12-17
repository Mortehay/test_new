<?php

use Illuminate\Database\Seeder;

class AdditionalFakeDomains extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TableAdditionalDomains::class, 100)->create();
    }
}
