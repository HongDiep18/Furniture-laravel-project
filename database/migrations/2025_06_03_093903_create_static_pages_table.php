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
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();
            $table->string('alias')->unique(); // alias varchar
            $table->string('title')->nullable(); // title varchar
            $table->longText('content')->nullable(); // content longtext
            $table->unsignedBigInteger('menu_id'); // menu_id int (foreign key)
            $table->boolean('status')->default(true); // status boolean
            $table->timestamps();

            // Khóa ngoại liên kết đến bảng menu
            $table->foreign('menu_id')->references('id')->on('menu')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('static_pages');
    }
};
