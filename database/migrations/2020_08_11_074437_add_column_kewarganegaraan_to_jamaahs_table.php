<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKewarganegaraanToJamaahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jamaahs', function (Blueprint $table) {
            //
            $table->string('kewarganegaraan', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jamaahs', function (Blueprint $table) {
            //
            if (Schema::hasColumn('jamaahs', 'kewarganegaraan')) {
                $table->dropColumn('kewarganegaraan');
            }
        });
    }
}
