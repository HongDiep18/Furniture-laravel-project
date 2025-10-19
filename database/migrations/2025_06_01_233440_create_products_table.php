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
            $table->id();
            $table->string('product_code')->unique(); // mã sản phẩm, duy nhất
            $table->string('name');
            $table->string('alias');
            $table->enum('stock_status', ['instock', 'outstock', 'onbackorder'])->default('instock');

            $table->decimal('price', 15, 0)->default(0);
            $table->decimal('price_sale', 15, 0)->nullable(); 

            $table->string('title_seo')->nullable();
            $table->string('home_image')->nullable();
            $table->longText('description')->nullable();
            $table->text('keywords')->nullable();

            $table->boolean('inhome')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);

            $table->integer('hitstotal')->default(0);
            $table->boolean('status')->default(true);
            $table->integer('order')->default(0);

            // Khóa ngoại
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('type_id');

            $table->timestamps();

            // Khai báo khóa ngoại
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('product_type')->onDelete('cascade');
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
