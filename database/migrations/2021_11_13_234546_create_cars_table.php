<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('car_id');
            $table->string('name');
            $table->integer('brand_id')
                ->references('brand_id')
                ->on('car_brands')
                ->onUpdate('cascade')
                ->onDelete('null');
            $table->integer('model_id')
                ->references('model_id')
                ->on('car_models')
                ->onUpdate('cascade')
                ->onDelete('null');
            $table->integer('status');
            $table->integer('year');
            $table->string('image')->nullable();
            $table->integer('seats');
            $table->integer('luggage');
            $table->integer('cc');
            $table->string('number_plates');
            $table->decimal('price', 14, 2);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
