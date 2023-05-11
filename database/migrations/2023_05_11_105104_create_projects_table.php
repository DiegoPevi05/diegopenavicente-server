<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('project',255)->default('N/A');
            $table->longText('logo')->default('N/A');
            $table->longText('description_es')->default('N/A');
            $table->longText('description_en')->default('N/A');
            $table->longText('description_it')->default('N/A');
            $table->longText('link')->default('N/A');
            $table->json('languages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
