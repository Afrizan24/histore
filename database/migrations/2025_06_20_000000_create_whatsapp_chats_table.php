<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('visitor_ip')->nullable();
            $table->string('visitor_user_agent')->nullable();
            $table->timestamp('chatted_at');
            $table->timestamps();
            
            // Index untuk optimasi query
            $table->index(['sale_id', 'chatted_at']);
            $table->index(['user_id', 'chatted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_chats');
    }
}; 