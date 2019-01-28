<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('location');
            $table->integer('client_type_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->foreign('client_type_id')->references('id')->on('client_types');
            $table->foreign('location_id')->references('id')->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('client_type_id');
            $table->dropColumn('location_id');
            $table->string('type');
            $table->string('location')->nullable();
        });
    }
}
