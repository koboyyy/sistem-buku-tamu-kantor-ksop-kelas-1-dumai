<?php
// ============================================================
// MIGRATION: create_all_tables.php
// Jalankan: php artisan migrate
// ============================================================

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel admin
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('nama_admin', 100);
            $table->enum('role', ['superadmin', 'admin'])->default('admin');
            $table->timestamps();
        });

        // Tabel tamu
        Schema::create('tamu', function (Blueprint $table) {
            $table->id('id_tamu');
            $table->string('nama', 100);
            $table->string('instansi', 100);
            $table->string('no_hp', 15);
            $table->text('alamat');
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->timestamps();
        });

        // Tabel bidang
        Schema::create('bidang', function (Blueprint $table) {
            $table->id('id_bidang');
            $table->string('nama_bidang', 100);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Tabel subbagian
        Schema::create('subbagian', function (Blueprint $table) {
            $table->id('id_subbagian');
            $table->foreignId('id_bidang')->constrained('bidang', 'id_bidang')->onDelete('cascade');
            $table->string('nama_subbagian', 100);
            $table->timestamps();
        });

        // Tabel kunjungan
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id('id_kunjungan');
            $table->foreignId('id_tamu')->constrained('tamu', 'id_tamu')->onDelete('cascade');
            $table->foreignId('id_bidang')->constrained('bidang', 'id_bidang');
            $table->foreignId('id_subbagian')->constrained('subbagian', 'id_subbagian');
            $table->date('tanggal_kunjungan');
            $table->time('jam_masuk');
            $table->time('jam_keluar')->nullable();
            $table->string('nomor_antrian', 50);
            $table->enum('status_kunjungan', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->boolean('is_served')->default(false);
            $table->text('keperluan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel log status
        Schema::create('log_status', function (Blueprint $table) {
            $table->id('id_log');
            $table->foreignId('id_kunjungan')->constrained('kunjungan', 'id_kunjungan')->onDelete('cascade');
            $table->foreignId('id_admin')->constrained('admin', 'id_admin');
            $table->string('status', 50);
            $table->dateTime('waktu_update');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_status');
        Schema::dropIfExists('kunjungan');
        Schema::dropIfExists('subbagian');
        Schema::dropIfExists('bidang');
        Schema::dropIfExists('tamu');
        Schema::dropIfExists('admin');
    }
};
