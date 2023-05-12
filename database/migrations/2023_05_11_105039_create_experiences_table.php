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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('job_es',255)->default('N/A');
            $table->string('job_en',255)->default('N/A');
            $table->string('job_it',255)->default('N/A');
            $table->string('company',255)->default('N/A');
            $table->json('details_es');
            $table->json('details_en');
            $table->json('details_it');
            $table->dateTime('startDate')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->longText('image1')->default('N/A');
            $table->longText('image2')->default('N/A');
            $table->longText('image3')->default('N/A');
            $table->longText('image4')->default('N/A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
