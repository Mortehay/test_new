<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAddittionalDomains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_addittional_domains', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('main_id');
            $table->foreign('main_id')->references('id')->on('table_host_access')
                ->onDelete('cascade');
            $table->string('additional_damain',200)->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_addittional_domains');
    }
}
