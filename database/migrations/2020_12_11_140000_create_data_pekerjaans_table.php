<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPekerjaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pekerjaans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipe_pekerjaan')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('bidang_usaha')->nullable();
            $table->string('jabatan')->nullable();
            $table->unsignedBigInteger('masa_kerja_bulan')->nullable();
            $table->string('alamat_perusahaan')->nullable();
            $table->string('kota_perusahaan_id')->nullable();
            $table->string('telp_kantor')->nullable();
            $table->string('website')->nullable();
            $table->string('jumlah_karyawan')->nullable();
            $table->string('kepemilikan_tempat_usaha')->nullable();
            $table->timestamps();

            $table->foreign('kota_perusahaan_id')->references('id')->on('kota')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_pekerjaans');
    }
}
