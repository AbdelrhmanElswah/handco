<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('off_plan_projects', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->string('developer');
            $table->string('location');
            $table->string('location_link')->nullable();
            $table->decimal('starting_price', 15, 2)->nullable();
            $table->string('completion_date')->nullable();
            $table->string('development_type')->nullable();
            $table->text('description')->nullable();
            $table->text('overview')->nullable();
            $table->json('key_features')->nullable();
            $table->json('payment_plan')->nullable();
            $table->json('nearby_attractions')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('off_plan_projects');
    }
};
