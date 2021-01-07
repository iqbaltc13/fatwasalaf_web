<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketHajiMudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_haji_mudas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama')->nullable();
            $table->string('deskripsi')->nullable();
            $table->text('rincian')->nullable();
            $table->double('nominal_dp')->nullable();
            $table->double('nominal_angsuran')->nullable();
            $table->unsignedBigInteger('total_bulan_angsuran')->nullable();
            $table->unsignedBigInteger('is_default')->default(0);
            $table->string('created_by_name')->nullable();
            $table->string('last_updated_by_name')->nullable();
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
        Schema::dropIfExists('paket_haji_mudas');
    }
}
