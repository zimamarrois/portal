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
        Schema::create('data_pmis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('pra_medical')->nullable();
            $table->string('file_pra_medical')->nullable();
            $table->string('no_id_pmi')->nullable();
            $table->string('file_no_id_pmi')->nullable();
            $table->string('pra_bpjs')->nullable();
            $table->string('file_pra_bpjs')->nullable();
            $table->string('rekom_perpen')->nullable();
            $table->string('file_rekom_perpen')->nullable();
            $table->string('medical_full')->nullable();
            $table->string('file_medical_full')->nullable();
            $table->string('blk')->nullable();
            $table->string('file_blk')->nullable();
            $table->string('validasi_paspor')->nullable();
            $table->string('file_validasi_paspor')->nullable();
            $table->string('ujk')->nullable();
            $table->string('file_ujk')->nullable();
            $table->boolean('job')->default(false);
            // $table->string('job')->nullable();
            $table->string('file_job')->nullable();
            $table->string('ec')->nullable();
            $table->string('file_ec')->nullable();
            $table->string('visa')->nullable();
            $table->string('file_visa')->nullable();
            $table->string('bpjs_purna')->nullable();
            $table->string('file_bpjs_purna')->nullable();
            $table->string('ktkln')->nullable();
            $table->string('file_ktkln')->nullable();
            $table->string('terbang')->nullable();
            $table->string('file_terbang')->nullable();
            $table->string('invoice_toyo')->nullable();
            $table->string('file_invoice_toyo')->nullable();
            $table->string('invoice_agency')->nullable();
            $table->string('file_invoice_agency')->nullable();
            $table->date('tanggal_pra_medical')->nullable();
            $table->date('tanggal_no_id_pmi')->nullable();
            $table->date('tanggal_pra_bpjs')->nullable();
            $table->date('tanggal_rekom_perpen')->nullable();
            $table->date('tanggal_medical_full')->nullable();
            $table->date('tanggal_blk')->nullable();
            $table->date('tanggal_validasi_paspor')->nullable();
            $table->date('tanggal_ujk')->nullable();
            $table->date('tanggal_job')->nullable();
            $table->date('tanggal_ec')->nullable();
            $table->date('tanggal_visa')->nullable();
            $table->date('tanggal_bpjs_purna')->nullable();
            $table->date('tanggal_ktkln')->nullable();
            $table->date('tanggal_terbang')->nullable();
            $table->date('tanggal_invoice_toyo')->nullable();
            $table->date('tanggal_invoice_agency')->nullable();
            $table->boolean('medical_check')->default(false);
            $table->string('telp_siapkerja')->nullable();
            $table->string('email_siapkerja')->nullable();
            $table->string('password_siapkerja')->nullable();
            $table->boolean('siapkerja')->default(false);
            $table->date('tglsiapkerja')->nullable();
            $table->string('file_pp')->nullable();
            $table->boolean('verdata')->default(false);
            $table->boolean('verpp')->default(false);
            $table->boolean('getjob')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pmis');
    }
};
