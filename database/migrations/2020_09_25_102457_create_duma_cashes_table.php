<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDumaCashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duma_cashes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('in')->nullable();
            $table->double('out')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('nasabah_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('nasabah_id')->references('id')->on('nasabahs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('duma_cashes');
    }
}
