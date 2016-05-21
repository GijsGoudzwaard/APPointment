<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftdeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('appointment_types', function(Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('companies', function(Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropcolumn('deleted_at');
        });

        Schema::table('appointment_types', function(Blueprint $table) {
            $table->dropcolumn('deleted_at');
        });

        Schema::table('companies', function(Blueprint $table) {
            $table->dropcolumn('deleted_at');
        });
    }
}
