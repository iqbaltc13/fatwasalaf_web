<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnLatitudeLongitudeKotaIdToKbihsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kbihs', function (Blueprint $table) {
            //
            $table->string('kota_id')->nullable();
            $table->float('latitude',10,4)->nullable()->default();
            $table->float('longitude',10,4)->nullable()->default();
            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kbihs', function (Blueprint $table) {
            //
            if (Schema::hasColumn('kbihs', 'kota_id')) {
                $table->dropColumn('kota_id');
            }
            if (Schema::hasColumn('kbihs', 'latitude')) {
                $table->dropColumn('latitude');
            }
            if (Schema::hasColumn('kbihs', 'longitude')) {
                $table->dropColumn('longitude');
            }
            $table->dropForeign('kbihs_kota_id_foreign');
        });
    }
}
