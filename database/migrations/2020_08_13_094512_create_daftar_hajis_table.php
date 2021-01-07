<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDaftarHajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_daftar_hajis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('display_name', 100);
            $table->string('note', 250)->nullable();
            $table->timestamps();
        });
        Schema::create('daftar_hajis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('jamaah_id')->nullable();
            $table->unsignedBigInteger('kbih_id')->nullable();
            $table->unsignedBigInteger('status_daftar_haji_id')->nullable();
            $table->unsignedBigInteger('verified_by_id')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->double('nominal_total', 10, 2)->nullable();
            $table->double('nominal_talangan', 10, 2)->nullable();
            $table->double('biaya_administrasi', 10, 2)->nullable();
            $table->timestamp('terakhir_pelunasan_admin')->nullable();
            $table->timestamp('terakhir_pelunasan_talangan')->nullable();
            $table->timestamp('tanggal_setor_bpsbpih')->nullable();
            $table->string('nomor_porsi', 20)->nullable();
            $table->integer('tahun_berangkat')->nullable();
            $table->string('catatan_customer')->nullable();
            $table->string('catatan_admin')->nullable();
            $table->string('catatan_kbih')->nullable();
            $table->timestamps();

            $table->foreign('jamaah_id')->references('id')->on('jamaahs')->onDelete('set null');
            $table->foreign('kbih_id')->references('id')->on('kbihs')->onDelete('set null');
            $table->foreign('verified_by_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('status_daftar_haji_id')->references('id')->on('status_daftar_hajis')->onDelete('set null');
        });
        Schema::create('daftar_haji_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('daftar_haji_id');
            $table->unsignedBigInteger('updated_by_id')->nullable();
            $table->string('updated_by_name');
            $table->unsignedBigInteger('status_daftar_haji_id_before')->nullable();
            $table->unsignedBigInteger('status_daftar_haji_id_after')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('daftar_haji_id')->references('id')->on('daftar_hajis')->onDelete('cascade');
            $table->foreign('updated_by_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('status_daftar_haji_id_before')->references('id')->on('status_daftar_hajis')->onDelete('set null');
            $table->foreign('status_daftar_haji_id_after')->references('id')->on('status_daftar_hajis')->onDelete('set null');
        });
        Schema::create('daftar_haji_lampirans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('daftar_haji_id');
            $table->unsignedBigInteger('file_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('daftar_haji_id')->references('id')->on('daftar_hajis')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            
        });
        Schema::create('jenis_pembayaran_hajis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('display_name', 100);
            $table->string('note', 250)->nullable();
            $table->timestamps();
        });
        Schema::create('pembayaran_hajis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('daftar_haji_id')->nullable();
            $table->unsignedBigInteger('jenis_pembayaran_haji_id')->nullable();
            $table->double('nominal')->default(0.0);
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('daftar_haji_id')->references('id')->on('daftar_hajis')->onDelete('set null');
            $table->foreign('jenis_pembayaran_haji_id')->references('id')->on('jenis_pembayaran_hajis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daftar_haji_logs');
        Schema::dropIfExists('daftar_haji_lampirans');
        Schema::dropIfExists('pembayaran_hajis');
        Schema::dropIfExists('jenis_pembayaran_hajis');
        Schema::dropIfExists('daftar_hajis');
        Schema::dropIfExists('status_daftar_hajis');
    }
}
