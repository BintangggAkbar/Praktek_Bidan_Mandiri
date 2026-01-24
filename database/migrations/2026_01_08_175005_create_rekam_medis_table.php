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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens')->cascadeOnDelete();
            $table->foreignId('bidan_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('layanan_id')->constrained('layanans')->cascadeOnDelete();

            // Subjective
            $table->text('keluhan_utama');

            // Objective
            $table->string('tekanan_darah');
            $table->integer('nadi');
            $table->integer('frekuensi_pernapasan');
            $table->decimal('berat_badan', 5, 2);
            $table->decimal('suhu_tubuh', 4, 1);
            $table->text('pemeriksaan_fisik')->nullable();

            // Assessment
            $table->text('diagnosis');

            // Plan
            $table->text('tindakan');
            $table->decimal('biaya', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
