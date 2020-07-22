<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CarParkTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('car_parks')) {
            Schema::create('car_parks', function (Blueprint $table) {
                $table->bigIncrements("id");
                $table->string("title", 50);
                $table->string("address", 80);
                $table->string("time_work", 100);
                $table->timestamp("created_at");
                $table->timestamp("updated_at")->useCurrent();
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
        Schema::dropIfExists('car_parks');
    }
}
