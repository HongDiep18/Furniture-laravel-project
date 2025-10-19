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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // title varchar
            $table->string('alias'); // alias varchar
            $table->string('link')->nullable();
            $table->string('image')->nullable();
            $table->string('description')->nullable(); // description varchar
            $table->longText('content')->nullable(); // content longtext
            $table->boolean('is_featured')->default(false); // is_featured boolean
            $table->boolean('inhome')->default(false); // inhome boolean
            $table->string('title_seo')->nullable(); // title_seo varchar
            $table->integer('histotal')->default(0); // histotal int
            $table->integer('order')->default(0); // order int
            $table->boolean('status')->default(true); // status boolean
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
