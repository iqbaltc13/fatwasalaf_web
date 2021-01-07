<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHajiMudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('haji_mudas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('data_jamaah_id')->nullable();
            $table->unsignedBigInteger('paket_haji_muda_id')->nullable();
            $table->double('nominal_dp')->nullable();
            $table->double('nominal_angsuran')->nullable();
            $table->unsignedBigInteger('total_bulan_angsuran')->nullable();
            $table->string('catatan_admin')->nullable();
            $table->string('catatan_customer')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->string('kota_id')->nullable();
            $table->timestamps();

            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('status_haji_mudas')->onDelete('set null');
            $table->foreign('data_jamaah_id')->references('id')->on('data_jamaahs')->onDelete('set null');
            $table->foreign('paket_haji_muda_id')->references('id')->on('paket_haji_mudas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('haji_mudas');
    }
}
