<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            // Menambahkan kolom waktu setelah kolom tanggal, tipe data time (jam:menit:detik)
            $table->time('waktu')->nullable()->after('tanggal');
        });
    }

    public function down(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropColumn('waktu');
        });
    }
};
