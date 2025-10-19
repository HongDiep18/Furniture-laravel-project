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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_email');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('subscriber_id')->nullable();
            $table->unsignedBigInteger('template_id')->nullable();
            $table->string('subject');
            $table->text('content');
            $table->enum('status', ['sent', 'failed'])->default('sent');
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->nullOnDelete();
            $table->foreign('subscriber_id')->references('id')->on('subscribers')->nullOnDelete();
            $table->foreign('template_id')->references('id')->on('email_templates')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
