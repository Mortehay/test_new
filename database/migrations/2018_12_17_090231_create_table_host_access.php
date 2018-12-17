<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHostAccess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_host_access', function (Blueprint $table) {
            $table->increments('id');
            $table->string('main_name', 200)->nullable();;
            $table->string('main_name_link', 200)->nullable();;
            $table->string('hosting_name', 200)->nullable();;
            $table->string('hosting_link', 200)->nullable();;
            $table->string('hosting_type', 200)->nullable();;
            $table->string('hosting_login', 200)->nullable();;
            $table->string('hosting_pass', 200)->nullable();;
            $table->string('comment', 512)->nullable();;
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
        Schema::dropIfExists('table_host_access');
    }
}
