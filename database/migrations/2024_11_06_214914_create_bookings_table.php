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
            $table->id();
            $table->unsignedBigInteger('project_id'); // Foreign key for project
            $table->string('name'); // Name of the person making the booking
            $table->string('email'); // Email of the person making the booking
            $table->string('phone_number'); // Phone number
            $table->text('message')->nullable(); // Optional message from the person
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
