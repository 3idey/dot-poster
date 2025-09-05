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
        Schema::create('saved_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // 'stripe', 'paypal', etc.
            $table->string('provider_payment_method_id'); // Stripe payment method ID
            $table->string('last_four')->nullable(); // Last 4 digits of card
            $table->string('brand')->nullable(); // visa, mastercard, etc.
            $table->string('exp_month')->nullable();
            $table->string('exp_year')->nullable();
            $table->string('nickname')->nullable(); // User-defined name
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            
            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_payment_methods');
    }
};
