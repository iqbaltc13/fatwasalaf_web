<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailColumnsOnJamaahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->string('nama_ayah_kandung', 250)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->dateTime('tanggal_lahir')->nullable();
            $table->string('kelurahan_id',255)->nullable();
            $table->string('kecamatan_id',255)->nullable();
            $table->string('kota_id',255)->nullable();
            $table->string('provinsi_id',255)->nullable();
            $table->bigInteger('pekerjaan_id')->nullable()->unsigned();
            $table->bigInteger('pendidikan_id')->nullable()->unsigned();
            $table->integer('is_pernah_haji')->unsigned()->nullable();
            $table->integer('nama_mahram_pendamping')->unsigned()->nullable();
            $table->enum('hubungan_mahram', ['Orang Tua', 'Anak','Suami/Isteri','Mertua','Saudara Kandung'])->nullable();
            $table->string('nomor_pendaftaran_mahram', 100)->nullable();
            $table->enum('status_perkawinan', ['Belum Menikah', 'Menikah','Janda/Duda'])->nullable();
            $table->string('ciri_rambut', 100)->nullable();
            $table->string('ciri_alis', 100)->nullable();
            $table->string('ciri_hidung', 100)->nullable();
            $table->string('ciri_muka', 100)->nullable();
            $table->integer('berat')->unsigned()->nullable()->comment('dalam kilogram');
            $table->integer('tinggi')->unsigned()->nullable()->comment('dalam centimeter');
            $table->bigInteger('foto_id')->nullable()->unsigned();
            

            //foreign key
            $table->foreign('kelurahan_id')->references('id')->on('kelurahan')->onDelete('set null');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('set null');
            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('set null');
            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('set null');
            $table->foreign('pekerjaan_id')->references('id')->on('master_pekerjaan')->onDelete('set null');
            $table->foreign('pendidikan_id')->references('id')->on('master_pendidikan')->onDelete('set null');
            $table->foreign('foto_id')->references('id')->on('files')->onDelete('set null');

        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
