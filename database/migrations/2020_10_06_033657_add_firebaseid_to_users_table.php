<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFirebaseidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firebase_uid')->nullable()->after('token_firebase')->unique();
            $table->string('number_id')->nullable()->after('id')->unique();
            DB::statement('ALTER TABLE `users` MODIFY `phone` varchar(50) NULL;');
            DB::statement('ALTER TABLE `users` MODIFY `password` varchar(255) NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('firebase_uid');
            $table->dropColumn('number_id');
        });
    }
}
