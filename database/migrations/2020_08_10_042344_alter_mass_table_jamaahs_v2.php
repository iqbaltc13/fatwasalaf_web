<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMassTableJamaahsV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('jamaahs', function (Blueprint $table) {
            if (Schema::hasColumn('jamaahs', 'status_perkawinan')) {
                $table->dropColumn('status_perkawinan');
            }
            if (Schema::hasColumn('jamaahs', 'hubungan_mahram')) {
                $table->dropColumn('hubungan_mahram');
            }
        });
        Schema::table('jamaahs', function (Blueprint $table) {
            $table->float('tinggi', 10, 6)->nullable()->change();
            $table->float('berat', 10, 6)->nullable()->change();
            $table->dropForeign('jamaahs_pendidikan_id_foreign');
            $table->dropForeign('jamaahs_pekerjaan_id_foreign');
            $table->dropColumn('pekerjaan_id');
            $table->dropColumn('pendidikan_id');
            $table->string('pendidikan', 100)->nullable()->default('text');
            $table->string('pekerjaan', 100)->nullable()->default('text');
            $table->string('nomor_hp', 100)->nullable();
            $table->string('jenis_kelamin', 20)->nullable()->change();
            $table->string('kode_diagnosis', 100)->nullable();
            $table->string('status_perkawinan', 100)->nullable()->comment("Belum Menikah, Menikah,Janda/Duda");
            $table->string('hubungan_mahram', 100)->nullable()->comment('Orang Tua', 'Anak','Suami/Isteri','Mertua','Saudara Kandung');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
