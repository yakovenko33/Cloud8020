<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CarsParksCars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('car_parks_cars')) {
            Schema::create('car_parks_cars', function (Blueprint $table) {
                $table->bigIncrements("id");
                $table->unsignedBigInteger('car_park_id');
                $table->unsignedBigInteger('car_id');

                $table->foreign('car_park_id')->references('id')->on('car_parks')->onDelete('cascade');
                $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_parks_cars');
    }
}
