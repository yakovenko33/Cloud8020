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
        if (!Schema::hasTable('cars_parks_cars')) {
            Schema::create('cars_parks_cars', function (Blueprint $table) {
                $table->bigIncrements("id");
                $table->unsignedBigInteger('cars_parks_id');
                $table->unsignedBigInteger('cars_id');

                $table->foreign('cars_parks_id')->references('id')->on('cars_parks')->onDelete('cascade');
                $table->foreign('cars_id')->references('id')->on('cars')->onDelete('cascade');
                //$table->primary(['cars_parks_id','cars_id']);
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
        Schema::dropIfExists('cars_parks_cars');
    }
}
