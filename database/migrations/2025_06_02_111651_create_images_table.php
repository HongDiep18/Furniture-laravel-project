<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // title varchar(255)
            $table->string('alt')->nullable(); // alt varchar
            $table->string('image'); // image varchar
            $table->string('description')->nullable(); // description varchar
            $table->string('link')->nullable(); // link varchar
            $table->string('type')->nullable(); // type varchar
            $table->integer('order')->default(1); // order int
            $table->boolean('status')->default(true); // status boolean
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
