<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->bigIncrements('id')->comment("primary key");
            $table->string('name', 255)->comment('The name of the room type, ie Double Queen, etc.');
            $table->text('description')->comment('The full text description of the room type.');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The primary key for the table.');
            $table->integer('number')->unique('number')->comment('The room number, unique');
            $table->unsignedBigInteger('room_type_id')->index('room_type_id')->comment('Corresponding room type.');
            $table->timestamps();

            $table->foreign('room_type_id')->references('id')->on('room_types');
        });

        Schema::create('discounts', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The Primary Key for the table.');
            $table->string('name', 255);
            $table->string('code', 50)->comment('The code someone would expect to enter at checkout');
            $table->unsignedInteger('discount')->comment('The discount in whole cents for a room.');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rates', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('Primary key');
            $table->unsignedInteger('value')->comment('The rate for the whole room in whole cents');
            $table->unsignedBigInteger('room_type_id')->index('room_type_id')->comment('The corresponding room type.');
            $table->boolean('is_weekend')->default(false)->comment('if this is the weekend rate or not');
            $table->timestamps();

            $table->unique(['room_type_id', 'is_weekend']);
            $table->foreign('room_type_id')->references('id')->on('room_types');
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The Primary Key for the table.');
            $table->unsignedBigInteger('room_id')->index('room_id')->comment('The corresponding room');
            $table->date('start')->comment('the Start date of booking');
            $table->date('end')->comment('the end date of booking');
            $table->boolean('is_reservation')->default(false)->comment('If this booking has a reservation');
            $table->boolean('is_paid')->default(false)->comment('if this booking was paid');
            $table->text('notes')->nullable()->comment('Any notes for the reservation');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('room_id')->references('id')->on('rooms');
        });

        Schema::create('bookings_users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The primary key');
            $table->unsignedBigInteger('booking_id')->index('booking_id')->comment('The corresponding booking');
            $table->unsignedBigInteger('user_id')->index('user_id')->comment('The corresponding user.');
            $table->timestamps();

            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_users');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('rates');
        Schema::dropIfExists('discounts');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('room_types');
    }
}
