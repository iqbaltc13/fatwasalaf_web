<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogEmailNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_email_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->mediumText('data')->nullable();
            $table->string('receiver_email', 255)->nullable();
            $table->string('sender_email', 255)->nullable();
            $table->mediumText('subject')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_email_notifications');
    }
}
