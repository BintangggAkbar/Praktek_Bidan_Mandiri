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
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->text('dosis');
            $table->enum('kategori_obat', ['analgesik', 'antibiotik', 'vitamin', 'suplemen', 'obat luar', 'lainnya']);
            $table->enum('bentuk_sediaan', ['tablet', 'kapsul', 'sirup', 'salep', 'injeksi']);
            $table->integer('stok');
            $table->string('satuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
