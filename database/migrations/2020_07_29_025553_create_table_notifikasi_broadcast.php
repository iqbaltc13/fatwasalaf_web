<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNotifikasiBroadcast extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifikasi_broadcast', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pengirim_id')->nullable();
            $table->text('penerima_id')->nullable();
            $table->string('judul')->nullable();
            $table->string('pesan')->nullable();
            $table->text('data_json')->nullable();
            $table->text('penerima_roles')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifikasi_broadcast');
    }
}
