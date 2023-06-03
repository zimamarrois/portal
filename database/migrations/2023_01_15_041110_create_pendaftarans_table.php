<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('rtrw')->nullable();
            $table->string('nomor_kk')->nullable();
            $table->string('nomor_telp')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('nomor_telp_wali')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_ktp_wali')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_akta_lahir')->nullable();
            $table->string('file_surat_nikah')->nullable();
            $table->string('file_surat_ijin')->nullable();
            $table->string('file_ijazah')->nullable();
            $table->string('file_tambahan')->nullable();
            $table->boolean('data_lengkap')->default(false);
            $table->boolean('proses')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pendaftarans');
    }
};
