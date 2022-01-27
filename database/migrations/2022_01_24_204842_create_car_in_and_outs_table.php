<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarInAndOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_in_and_outs', function (Blueprint $table) {
            $table->increments('cio_id');
            $table->string('code')
                ->references('code')
                ->on('checkouts')
                ->onUpdate('cascade')
                ->onDelete('null');
            $table->integer('car_id')
                ->references('car_id')
                ->on('cars')
                ->onUpdate('cascade')
                ->onDelete('null');
            $table->integer('user_id')
                ->references('user_id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('null');
            $table->integer('booking_id')
                ->references('booking_id')
                ->on('bookings')
                ->onUpdate('cascade')
                ->onDelete('null');
            $table->integer('checkout_id')
                ->references('checkout_id')
                ->on('checkouts')
                ->onUpdate('cascade')
                ->onDelete('null');
            $table->integer('rent_status');
            $table->date('car_out')->nullable();
            $table->date('car_in')->nullable();
            $table->integer('days_rent')->nullable();
            $table->decimal('fine', 14, 2)->nullable();
            $table->integer('fine_status')->nullable();
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
        Schema::dropIfExists('car_in_and_outs');
    }
}
