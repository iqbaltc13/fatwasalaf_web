<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('nasabah_id')->nullable();
            $table->unsignedBigInteger('jenis_layanan_id')->nullable();
            $table->unsignedBigInteger('jenis_pembayaran_id')->nullable();
            $table->morphs('pembayaran');
            $table->double('nominal')->nullable();
            
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by_id')->nullable();
            $table->string('verified_by_name')->nullable();
            $table->enum('verified_result', ['accepted', 'rejected'])->nullable();

            $table->string('catatan_customer')->nullable();
            $table->string('catatan_verifikator')->nullable();
            $table->unsignedBigInteger('file_id')->nullable();
            $table->timestamps();
            $table->foreign('jenis_pembayaran_id')->references('id')->on('jenis_pembayarans')->onDelete('set null');
            $table->foreign('jenis_layanan_id')->references('id')->on('jenis_layanans')->onDelete('set null');
            $table->foreign('verified_by_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('file_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
}
