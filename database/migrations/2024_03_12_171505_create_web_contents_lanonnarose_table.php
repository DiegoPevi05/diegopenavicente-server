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
        Schema::create('web_contents_lanonnarose', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable(false);
            $table->text('content_es')->nullable(false);
            $table->text('content_en')->nullable(false);
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
        Schema::dropIfExists('web_contents_lanonnarose');
    }
};
