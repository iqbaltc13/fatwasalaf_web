<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCallbackLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_callback_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider')->nullable();//bms
            $table->string('nomor_va')->nullable();
            $table->string('kode_bank')->nullable();
            $table->timestamp('waktu_proses')->nullable();
            $table->double('nominal')->nullable();
            $table->double('admin')->nullable();
            $table->unsignedInteger('status_code')->default();
            $table->string('status_string')->nullable();
            $table->text('raw_input')->nullable();
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
        Schema::dropIfExists('payment_callback_logs');
    }
}
