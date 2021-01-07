<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMitraTravelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mitra_travels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('no_izin_kemenag')->nullable();
            $table->unsignedBigInteger('tahun_berdiri')->nullable();
            $table->string('nama_direktur')->nullable();
            $table->string('lokasi_kantor')->nullable();
            $table->string('titik_keberangkatan')->nullable();
            $table->string('telepon')->nullable();
            $table->string('website')->nullable();
            $table->string('social_media')->nullable();
            $table->unsignedBigInteger('order')->nullable();
            $table->unsignedBigInteger('is_active')->nullable();
            $table->unsignedBigInteger('logo_id')->nullable();
            $table->timestamps();

            $table->foreign('logo_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mitra_travels');
    }
}
