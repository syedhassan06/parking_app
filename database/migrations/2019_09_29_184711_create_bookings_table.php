<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('location_id')->unsigned();
            $table->bigInteger('area_id')->unsigned();
            $table->bigInteger('slot_id')->unsigned();
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('booking_status', ['cancelled', 'booked'])->default('booked');
            $table->timestamp('created_at')->default(\Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();

            //Relationship
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('area_id')->references('id')->on('areas');
            $table->foreign('slot_id')->references('id')->on('parking_slots');
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
