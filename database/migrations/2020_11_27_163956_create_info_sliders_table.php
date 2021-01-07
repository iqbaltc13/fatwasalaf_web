<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_sliders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('description')->nullable();
            $table->string('position')->nullable();
            $table->text('html')->nullable();
            $table->unsignedBigInteger('order')->nullable();
            $table->unsignedBigInteger('is_active')->nullable();
            $table->unsignedBigInteger('image_slide_id')->nullable();
            $table->unsignedBigInteger('image_content_id')->nullable();
            $table->timestamps();

            $table->foreign('image_slide_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('image_content_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_sliders');
    }
}
