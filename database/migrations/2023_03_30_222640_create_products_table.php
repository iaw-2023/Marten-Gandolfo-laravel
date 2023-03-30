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
        Schema::create('products', function (Blueprint $table) {
            $table->id();                                   // product_ID
            $table->unsignedBigInteger('category_ID');      // FK
            $table->string('product_name');
            $table->string('product_description');
            $table->string('product_brand');
            $table->float('product_price');
            $table->string('product_oficial_site');
            $table->string('product_image');
            $table->timestamps();

            $table->foreign('category_ID')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
