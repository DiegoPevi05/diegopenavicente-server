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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',255)->default('N/A');
            $table->string('author',255)->default('N/A');
            $table->longText('content_es')->default('N/A');
            $table->longText('content_en')->default('N/A');
            $table->longText('content_it')->default('N/A');
            $table->longText('href')->default('N/A');
            $table->longText('img')->default('N/A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
