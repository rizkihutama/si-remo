<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->increments('checkout_id');
            $table->foreignId('booking_id')
                ->constrained('bookings', 'booking_id')
                ->cascadeOnUpdate();
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
            $table->foreignId('bank_id')
                ->nullable()
                ->constrained('banks', 'bank_id')
                ->cascadeOnUpdate();
            $table->string('code')->unique();
            $table->smallInteger('status');
            $table->string('payment_proof')->nullable();
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
        Schema::dropIfExists('checkouts');
    }
}
