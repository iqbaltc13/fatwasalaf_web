<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingNominalHajiMudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_nominal_haji_mudas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('nominal_talangan', 10, 2)->nullable();
            $table->double('biaya_administrasi', 10, 2)->nullable();
            $table->double('minimal_tabungan',10, 2)->unsigned()->nullable()->comment('dalam bulan');
            $table->integer('jangka_waktu_pelunasan')->unsigned()->nullable()->comment('dalam bulan');
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
        Schema::dropIfExists('setting_nominal_haji_mudas');
    }
}
