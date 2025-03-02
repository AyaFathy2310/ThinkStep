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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade'); // المرسل
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade'); // المستقبل
            $table->foreignId('communication_id')->constrained()->onDelete('cascade'); // نوع الرسالة
            $table->text('content'); // محتوى الرسالة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
