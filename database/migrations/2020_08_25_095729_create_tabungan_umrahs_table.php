<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabunganUmrahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabungan_umrahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nasabah_id')->nullable();
            $table->unsignedBigInteger('paket_tabungan_umrah_id')->nullable();
            $table->double('biaya_administrasi');
            $table->double('nominal_tabungan');
            $table->integer('tahun_rencana_berangkat')->nullable();
            $table->timestamp('tanggal_berangkat')->nullable();
            $table->unsignedBigInteger('status_tabungan_umrah_id')->nullable();
            $table->string('catatan_customer')->nullable();
            $table->string('catatan_admin')->nullable();
            $table->string('last_updated_by_name')->nullable();
            $table->timestamps();

            $table->foreign('nasabah_id')->references('id')->on('nasabahs')->onDelete('set null');
            $table->foreign('status_tabungan_umrah_id')->references('id')->on('status_tabungan_umrahs')->onDelete('set null');
            $table->foreign('paket_tabungan_umrah_id')->references('id')->on('paket_tabungan_umrahs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabungan_umrahs');
    }
}




