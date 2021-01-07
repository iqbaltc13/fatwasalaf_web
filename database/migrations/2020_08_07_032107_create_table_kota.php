<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKota extends Migration
{
    public function __construct()
    {
        $this->table_name = 'kota';
    }
    public function up()
    {
        if (!Schema::hasTable($this->table_name)) {
            Schema::create($this->table_name, function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('provinsi_id')->nullable();
                $table->string('nama')->nullable();
                $table->timestamps();

                $table->foreign('provinsi_id')->references('id')->on('provinsi')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kota');
    }
}
