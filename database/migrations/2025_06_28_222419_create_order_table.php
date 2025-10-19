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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('user')
                ->nullOnDelete(); // Nếu user bị xóa thì user_id = null
            $table->string('name');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->string('note')->nullable(); // note có thể rỗng

            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->string('address_detail')->nullable();

            $table->decimal('total_amount', 15, 0);

            $table->unsignedBigInteger('status_id');

            $table->foreign('status_id')->references('id')->on('status_order')->onDelete('restrict');
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
