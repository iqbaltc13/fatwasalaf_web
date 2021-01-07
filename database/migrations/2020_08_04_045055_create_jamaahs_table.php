<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJamaahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jamaahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama',255)->nullable();
            $table->string('alamat',255)->nullable();
            $table->string('jenis_kelamin',2)->nullable()->comment('L/P');
            $table->string('nomor_ktp',50)->unique();
            $table->string('golongan_darah',3)->nullable();
            $table->integer('umur')->unsigned()->nullable();
            $table->bigInteger('foto_ktp_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('pendaftar_id')->unsigned()->nullable();
            $table->timestamps();


            $table->foreign('foto_ktp_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('pendaftar_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jamaahs');
        
    }
}
