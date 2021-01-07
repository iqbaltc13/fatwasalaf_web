<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataRelasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_relasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('relasi')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota_id')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->string('nomor_hp')->nullable();
            $table->string('telp_rumah')->nullable();
            $table->unsignedBigInteger('pekerjaan_id')->nullable();
            $table->timestamps();

            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('set null');
            $table->foreign('pekerjaan_id')->references('id')->on('data_pekerjaans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_relasis');
    }
}
