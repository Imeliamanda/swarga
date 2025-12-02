<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // tambahkan kolom user_id (relasi ke users)
            $table->foreignId('user_id')
                  ->after('id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // tambahkan kolom isi
            $table->text('isi')->after('user_id');

            // tambahkan kolom status
            $table->string('status')->default('baru')->after('isi');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // urutan drop FK dulu, lalu kolomnya
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'isi', 'status']);
        });
    }
};

