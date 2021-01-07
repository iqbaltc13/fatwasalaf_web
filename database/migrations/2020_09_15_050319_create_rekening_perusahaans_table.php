<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekeningPerusahaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening_perusahaans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor_rekening');
            $table->string('atas_nama');
            $table->string('nama_bank');
            $table->string('keterangan')->nullable();
            $table->boolean('status_aktif')->default(false);
            $table->unsignedBigInteger('logo_bank_id')->nullable();
            $table->timestamps();

            $table->foreign('logo_bank_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekening_perusahaans');
    }
}