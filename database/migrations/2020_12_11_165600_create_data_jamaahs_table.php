<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataJamaahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_jamaahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nasabah_id')->nullable();
            //Data Pemohon
            $table->string('nomor_npwp')->nullable();
            $table->string('alamat_domisili')->nullable();
            $table->string('kota_domisili_id')->nullable();
            $table->string('telp_rumah')->nullable();
            $table->string('status_rumah')->nullable();
            $table->string('nomor_kk')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('status_perkawinan')->nullable();
            $table->unsignedBigInteger('data_pasangan_id')->nullable();
            $table->unsignedBigInteger('data_sosmed_id')->nullable();
            $table->unsignedBigInteger('data_pekerjaan_id')->nullable();
            $table->unsignedBigInteger('data_keluarga_id')->nullable();
            $table->unsignedBigInteger('data_keuangan_id')->nullable();
            $table->timestamps();

            $table->foreign('nasabah_id')->references('id')->on('nasabahs')->onDelete('set null');
            $table->foreign('kota_domisili_id')->references('id')->on('kota')->onDelete('set null');
            $table->foreign('data_pasangan_id')->references('id')->on('data_relasis')->onDelete('set null');
            $table->foreign('data_keluarga_id')->references('id')->on('data_relasis')->onDelete('set null');
            $table->foreign('data_sosmed_id')->references('id')->on('data_sosmeds')->onDelete('set null');
            $table->foreign('data_pekerjaan_id')->references('id')->on('data_pekerjaans')->onDelete('set null');
            $table->foreign('data_keuangan_id')->references('id')->on('data_keuangans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_jamaahs');
    }
}
