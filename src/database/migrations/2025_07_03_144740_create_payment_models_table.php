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
        Schema::create('payments', function (Blueprint $table) {
        
            $table->id();
            $table->string('userName')->nullable(true);
            $table->string('password')->nullable(false);
            $table->integer('orderNumber')->nullable(false);
            $table->integer('amount')->nullable(false);
            $table->integer('currency')->nullable(false);
            $table->string('returnUrl')->nullable(false);
            $table->string('failUrl')->nullable(true);
            $table->string('isConfirmed')->nullable(true)->default(false);
            $table->string('isFailed')->nullable(true)->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_models');
    }
};
