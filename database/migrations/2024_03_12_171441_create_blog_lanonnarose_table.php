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
        Schema::create('blog_lanonnarose', function (Blueprint $table) {
            $table->id();
            $table->string('title_es', 255)->defualt('N/A');
            $table->string('title_en', 255)->defualt('N/A');
            $table->string('subTitle_es', 255)->defualt('N/A');
            $table->string('subTitle_en', 255)->defualt('N/A');
            $table->text('description_es');
            $table->text('description_en');
            $table->longText('image1')->nullable(false);
            $table->longText('image2')->nullable(true);
            $table->longText('image3')->nullable(true);
            $table->longText('image4')->nullable(true);
            $table->text('bulletpoints_es');
            $table->text('bulletpoints_en');
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
        Schema::dropIfExists('blog_lanonnarose');
    }
};
