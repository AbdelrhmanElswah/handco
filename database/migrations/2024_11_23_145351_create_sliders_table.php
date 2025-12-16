<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('sliders')) {
            Schema::create('sliders', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('subtitle')->nullable();
                $table->text('description')->nullable();
                $table->string('button_text')->nullable();
                $table->string('button_link')->nullable();
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
}

