<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            // HAPUS kolom diskon
            $table->dropColumn('diskon');
            // TAMBAH kolom stock
            $table->integer('stock')->default(0)->after('harga');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            // Kembalikan jika rollback
            $table->integer('diskon')->nullable();
            $table->dropColumn('stock');
        });
    }
};