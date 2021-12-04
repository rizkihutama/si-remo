<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('booking_id');
            $table->foreignId('user_id')
                ->constrained('users', 'user_id')
                ->cascadeOnUpdate();
            $table->foreignId('car_id')
                ->constrained('cars', 'car_id')
                ->cascadeOnUpdate();
            $table->smallInteger('with_driver');
            $table->foreignId('driver_id')
                ->nullable()
                ->constrained('drivers', 'driver_id')
                ->cascadeOnUpdate();
            $table->string('code');
            $table->integer('status');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('days');
            $table->text('pickup_location');
            $table->text('dropoff_location');
            $table->time('pickup_time');
            $table->time('dropoff_time');
            $table->decimal('sub_total', 14, 2);
            $table->decimal('total', 14, 2);
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
        Schema::dropIfExists('bookings');
    }
}
