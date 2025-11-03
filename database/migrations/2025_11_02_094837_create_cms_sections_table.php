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
        Schema::create('cms_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // e.g., 'main_services', 'hero_section', etc.
            $table->string('section_name'); // Display name for admin
            $table->text('title')->nullable(); // Main title/heading
            $table->text('subtitle')->nullable(); // Subtitle if needed
            $table->text('content')->nullable(); // Main content/description
            $table->json('list_items')->nullable(); // For lists like services
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
        Schema::dropIfExists('cms_sections');
    }
};
