<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CarParkTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('cars_parks')) {
            Schema::create('cars_parks', function (Blueprint $table) {
                $table->bigIncrements("id");
                $table->string("title", 50);
                $table->string("address", 80);
                $table->string("time_work", 100);
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
        Schema::dropIfExists('cars_parks');
    }
}
