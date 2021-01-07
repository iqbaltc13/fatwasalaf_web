<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtikelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('artikels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('judul')->nullable();
            $table->text('artikel')->nullable();
            $table->unsignedBigInteger('thumbnail_file_id')->nullable();
            $table->unsignedBigInteger('konten_file_id')->nullable();
            $table->unsignedInteger('is_active')->default(1);
            $table->timestamps();

            $table->foreign('thumbnail_file_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('konten_file_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('artikels');
    }
}
