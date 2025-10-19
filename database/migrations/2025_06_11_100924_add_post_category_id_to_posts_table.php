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
        Schema::table('posts', function (Blueprint $table) {
            $table->unsignedBigInteger('post_category_id')->nullable()->after('id');

            $table->foreign('post_category_id')
                ->references('id')
                ->on('post_categories')
                ->nullOnDelete(); // Khi xóa category, trường này sẽ set null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropForeign(['post_category_id']);
                $table->dropColumn('post_category_id');
            });
        });
    }
};
