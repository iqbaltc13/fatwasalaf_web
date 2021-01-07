<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->string('token_firebase', 255)->nullable()->default(NULL);
            $table->boolean('is_active')->default(0);
            $table->boolean('built_in')->default(0);
            $table->timestamp('last_signedin')->nullable();
            $table->timestamp('last_access')->nullable();
            $table->timestamp('last_update_location')->nullable();
            $table->double('latitude')->default(0.0);
            $table->double('longitude')->default(0.0);
            $table->string('device_info')->nullable()->default(NULL);
            $table->string('current_apk_version_name')->nullable()->default(NULL);
            $table->string('current_apk_version_code')->nullable()->default(NULL);
            $table->rememberToken();
            $table->timestamps();
            $table->index(['email', 'phone', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
