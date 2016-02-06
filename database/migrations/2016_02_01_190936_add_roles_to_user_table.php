<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRolesToUserTable extends Migration
{
	/**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('users', function ($table) {
			$table->boolean('role')->after('remember_token')->default(0);
			$table->integer('environment_id')->after('role');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('users', function ($table) {
		    $table->dropColumn('environment_id');
			$table->dropColumn('role');
		});
    }
}
