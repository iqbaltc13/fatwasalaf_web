<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->unsignedBigInteger('duma_point_id')->nullable()->after('file_id');
            $table->unsignedBigInteger('duma_cash_id')->nullable()->after('file_id');

            $table->foreign('duma_point_id')->references('id')->on('duma_points')->onDelete('set null');
            $table->foreign('duma_cash_id')->references('id')->on('duma_cashes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropForeign('pembayarans_duma_point_id_foreign');
            $table->dropForeign('pembayarans_duma_cash_id_foreign');

            $table->dropColumn('duma_point_id');
            $table->dropColumn('duma_cash_id');
        });
    }
}
