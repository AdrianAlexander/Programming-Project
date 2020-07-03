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
            $table->unsignedInteger('staff_id');
            $table->foreign('staff_id')
            ->references('id')->on('staff')
            ->onDelete('cascade');
            $table->string('vehicle_name');
            $table->string('vehicle_category');
            $table->string('vehicle_type');
            $table->string('plate_number');
            $table->unsignedInteger('fuel');
            $table->string('description');
            $table->unsignedInteger('price');
            $table->double('longitude');
            $table->double('latitude');
            $table->string('image')->nullable();
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
