<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNasabahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->string('kelurahan_id',255)->nullable()->after('alamat');
            $table->string('kecamatan_id',255)->nullable()->after('alamat');
            $table->string('kota_id',255)->nullable()->after('alamat');
            $table->string('provinsi_id',255)->nullable()->after('alamat');
            $table->unsignedBigInteger('foto_ktp_id')->nullable()->after('nomor_ktp');
            $table->unsignedBigInteger('foto_ktp_selfie_id')->nullable()->after('nomor_ktp');

            $table->foreign('kelurahan_id')->references('id')->on('kelurahan')->onDelete('set null');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatan')->onDelete('set null');
            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('set null');
            $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('set null');
            $table->foreign('foto_ktp_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('foto_ktp_selfie_id')->references('id')->on('files')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nasabahs', function (Blueprint $table) {
            $table->dropForeign('nasabahs_kelurahan_id_foreign');
            $table->dropForeign('nasabahs_kecamatan_id_foreign');
            $table->dropForeign('nasabahs_kota_id_foreign');
            $table->dropForeign('nasabahs_provinsi_id_foreign');
            $table->dropForeign('nasabahs_foto_ktp_id_foreign');
            $table->dropForeign('nasabahs_foto_ktp_selfie_id_foreign');

            $table->dropColumn('kelurahan_id');
            $table->dropColumn('kecamatan_id');
            $table->dropColumn('kota_id');
            $table->dropColumn('provinsi_id');
            $table->dropColumn('foto_ktp_id');
            $table->dropColumn('foto_ktp_selfie_id');
        });
    }
}
