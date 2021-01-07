<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspirasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspirasis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('description')->nullable();
            $table->text('html')->nullable();
            $table->double('duration_second')->default(0.0);
            $table->string('duration_string')->nullable();
            $table->unsignedBigInteger('thumbnail_id')->nullable();
            $table->unsignedBigInteger('header_image_id')->nullable();
            $table->unsignedBigInteger('audio_id')->nullable();
            $table->unsignedBigInteger('video_id')->nullable();
            $table->string('uploader_name')->nullable();
            $table->unsignedInteger('is_active')->default(1);
            $table->timestamps();

            $table->foreign('thumbnail_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('header_image_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('audio_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('video_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspirasis');
    }
}
