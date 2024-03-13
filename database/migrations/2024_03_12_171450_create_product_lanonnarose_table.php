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
        Schema::create('product_lanonnarose', function (Blueprint $table) {
            $table->id();
            $table->string('section_es', 255)->defualt('N/A');
            $table->string('section_en', 255)->defualt('N/A');
            $table->string('title_es', 255)->defualt('N/A');
            $table->string('title_en', 255)->defualt('N/A');
            $table->string('name', 255)->defualt('N/A');
            $table->text('shortDescription_es');
            $table->text('shortDescription_en');
            $table->text('description_es');
            $table->text('description_en');
            $table->longText('imageUrl')->nullable(true);
            $table->boolean('isImportant')->nullable();
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
        Schema::dropIfExists('product_lanonnarose');
    }
};
