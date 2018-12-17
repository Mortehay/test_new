<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnTableAdditionalDomains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_additional_domains', function (Blueprint $table) {
            $table->renameColumn('additional_damain', 'additional_domain');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_additional_domains', function (Blueprint $table) {
            $table->renameColumn('additional_domain', 'additional_damain');
        });
    }
}
