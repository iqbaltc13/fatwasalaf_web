<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspirasiCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspirasi_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inspirasi_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('inspirasi_id')->references('id')->on('inspirasis')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspirasi_comments');
    }
}
