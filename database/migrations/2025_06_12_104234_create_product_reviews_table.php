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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id(); // id int [PK]
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->tinyInteger('rating')->unsigned();
            $table->string('comment')->nullable();
            $table->boolean('verified_purchase')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
