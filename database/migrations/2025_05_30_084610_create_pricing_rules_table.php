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
        Schema::create('pricing_rules', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->json('days')->nullable();
            $table->json('discounts')->nullable();
            $table->integer('min_quantity')->nullable();
            $table->decimal('quantity_discount', 10, 2)->nullable();
            $table->integer('precedence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};