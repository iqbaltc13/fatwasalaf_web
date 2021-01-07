<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('activity');
            $table->enum('device', ['android','ios','web','postman','other']);
            $table->string('notes')->nullable();
            $table->string('url')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->mediumInteger('execution_time')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'activity', 'url']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_records');
    }
}
