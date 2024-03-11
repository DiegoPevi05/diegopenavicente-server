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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('recover_token_time')->nullable();
            $table->enum('role', ['ADMIN','CLIENT'])->default('CLIENT')->nullable(false);
            $table->enum('billing_cycle', ['MONTHLY','YEARLY','ONE_TIME'])->default('MONTHLY')->nullable(true);
            $table->integer('billing_day')->nullable(true);
            $table->integer('billing_month')->nullable(true);
            $table->decimal('gross_amount', 8, 2)->nullable(true);
            $table->string('package')->nullable(false);
            $table->string('password');
            $table->decimal('unique_payment', 8, 2)->nullable(true);
            $table->string('logo')->nullable(true);
            $table->string('website')->nullable(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
