<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateBookingsTable extends Migration
// {
//   /**
//    * Run the migrations.
//    *
//    * @return void
//    */
//   public function up()
//   {
//     Schema::create('bookings', function (Blueprint $table) {
//       $table->increments('booking_id');
//       $table->foreignId('user_id')
//         ->constrained('users', 'user_id')
//         ->cascadeOnUpdate();
//       $table->foreignId('car_id')
//         ->constrained('cars', 'car_id')
//         ->cascadeOnUpdate();
//       $table->foreignId('driver_id')
//         ->constrained('drivers', 'driver_id')
//         ->cascadeOnUpdate()
//         ->nullable();
//       $table->string('booking_code');
//       $table->date('start_date');
//       $table->date('end_date');
//       $table->integer('days');
//       $table->smallInteger('status');
//       $table->boolean('with_driver')->nullable();
//       $table->text('pick_up_location');
//       $table->time('pick_up_time');
//       $table->decimal('total', 14, 2);
//       $table->integer('created_by');
//       $table->integer('updated_by')->nullable();
//       $table->timestamps();
//     });
//   }

//   /**
//    * Reverse the migrations.
//    *
//    * @return void
//    */
//   public function down()
//   {
//     Schema::dropIfExists('bookings');
//   }
// }
