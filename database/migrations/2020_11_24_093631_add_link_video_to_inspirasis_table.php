<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLinkVideoToInspirasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspirasis', function (Blueprint $table) {
            if (!Schema::hasColumn('inspirasis', 'video_url')) {
                $table->text('video_url')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspirasis', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
    }
}
