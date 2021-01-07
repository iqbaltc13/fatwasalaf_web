<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketTabunganUmrahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paket_tabungan_umrahs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama')->unique();
            $table->string('deskripsi')->nullable();
            $table->double('biaya_administrasi')->default(0.0);
            $table->double('nominal_tabungan')->default(0.0);
            $table->boolean('is_default')->default(false);
            $table->string('created_by_name');
            $table->string('last_updated_by_name')->nullable();
            $table->unsignedBigInteger('banner_file_id')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->timestamps();
            $table->foreign('banner_file_id')
                ->references('id')
                ->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paket_tabungan_umrahs');
    }
}