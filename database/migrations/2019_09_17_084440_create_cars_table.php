<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('car_name');
            $table->string('car_type');
            $table->string('plate_number');
            $table->unsignedInteger('fuel');
            $table->string('description');
            $table->unsignedInteger('price');
            $table->double('longitude');
            $table->double('latitude');
            $table->string('image');
            $table->boolean('taken')->default(false);
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
        Schema::dropIfExists('cars');
    }
}
