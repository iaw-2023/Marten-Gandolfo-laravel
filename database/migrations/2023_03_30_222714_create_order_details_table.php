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
        Schema::create('order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('order_ID');     // FK
            $table->unsignedBigInteger('product_ID');   // FK
            $table->integer('units');
            $table->timestamps();

            $table->foreign('order_ID')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_ID')->references('id')->on('products')->onDelete('cascade');
            $table->primary(['order_ID', 'product_ID']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
