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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent')->default(0); // parent int (tham chiếu đến chính nó nếu cần)
            $table->string('alias')->unique();
            $table->enum('position', ['main', 'footer'])->default('main'); // enum
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
        Schema::dropIfExists('menu');
    }
};
