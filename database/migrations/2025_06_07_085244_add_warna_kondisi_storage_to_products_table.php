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
        Schema::table('products', function (Blueprint $table) {
            $table->string('warna')->nullable()->after('category_id');
            $table->enum('kondisi', ['baru', 'bekas'])->default('baru')->after('warna');
            $table->string('storage')->nullable()->after('kondisi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['warna', 'kondisi', 'storage']);
        });
    }
};
