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
        Schema::create('product_type', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // name varchar(255)
            $table->string('alias'); // alias varchar(255)
            $table->string('image')->nullable(); // image varchar(255) varchar(255)
            $table->integer('order')->default(0); // order int(11)
            $table->boolean('status')->default(true); // status boolean
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_type');
    }
};
