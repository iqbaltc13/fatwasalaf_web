<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHajiMudaKotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('haji_muda_kotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kota_id',255)->nullable();
            $table->timestamps();

            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('haji_muda_kotas');
    }
}
