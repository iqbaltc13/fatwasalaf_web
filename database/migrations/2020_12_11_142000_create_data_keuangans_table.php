<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataKeuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_keuangans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('penghasilan_pribadi_nominal')->nullable();
            $table->string('penghasilan_pribadi_sumber')->nullable();
            $table->double('penghasilan_pasangan_nominal')->nullable();
            $table->string('penghasilan_pasangan_sumber')->nullable();
            $table->double('penghasilan_lain_nominal')->nullable();
            $table->string('penghasilan_lain_sumber')->nullable();
            $table->string('pengeluaran_nominal')->nullable();
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
        Schema::dropIfExists('data_keuangans');
    }
}
