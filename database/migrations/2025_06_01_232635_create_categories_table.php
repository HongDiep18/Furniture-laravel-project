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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent')->default(0); // parent int(11)
            $table->string('name'); // name varchar(255)
            $table->string('alias'); // alias varchar(255)
            $table->string('image')->nullable(); // image varchar(255)
            $table->string('title_seo')->nullable(); // title_seo varchar(255)
            $table->boolean('inhome')->default(false); // inhome boolean
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
        Schema::dropIfExists('categories');
    }
};
