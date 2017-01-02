<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepeatedAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repeated_appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('start');
            $table->date('end')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->integer('repeated_id')->unsigned()->nullable()->after('appointment_type_id');
            $table->foreign('repeated_id')->references('id')->on('repeated_appointments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('repeated_appointments');

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['repeated_id']);
            $table->dropColumn('repeated_id');
        });
    }
}
