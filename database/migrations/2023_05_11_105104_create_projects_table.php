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
            $table->string('project',255)->nullable(false);
            $table->longText('logo')->nullable(false);
            $table->longText('description_es')->nullable(false);
            $table->longText('description_en')->nullable(false);
            $table->longText('description_it')->nullable(false);
            $table->longText('link')->nullable(false);
            $table->longText('github')->nullable(true);
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
