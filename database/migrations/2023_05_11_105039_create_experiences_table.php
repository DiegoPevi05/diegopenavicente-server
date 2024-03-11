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
            $table->boolean('is_active')->nullable();
            $table->text('details_es');
            $table->text('details_en');
            $table->text('details_it');
            $table->dateTime('startDate')->nullable();
            $table->dateTime('endDate')->nullable();
            $table->longText('image1')->nullable(false);
            $table->longText('image2')->nullable(true);
            $table->longText('image3')->nullable(true);
            $table->longText('image4')->nullable(true);
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
