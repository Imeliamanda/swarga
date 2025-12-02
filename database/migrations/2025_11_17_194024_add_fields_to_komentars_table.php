<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('komentars', function (Blueprint $table) {
            // jika tabel komentars sebelumnya hanya punya id, created_at, updated_at,
            // kita tambahkan kolom berikut:

            $table->foreignId('pengaduan_id')
                  ->after('id')
                  ->constrained('pengaduans')
                  ->onDelete('cascade');

            $table->foreignId('user_id')
                  ->after('pengaduan_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->text('isi')->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('komentars', function (Blueprint $table) {
            $table->dropForeign(['pengaduan_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['pengaduan_id', 'user_id', 'isi']);
        });
    }
};
