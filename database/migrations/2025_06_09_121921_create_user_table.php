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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password');
            $table->unsignedBigInteger('role');
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->timestamps();
            $table->foreign('role')->references('id')->on('role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};
