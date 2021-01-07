<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVideoUrlToInspirasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inspirasis', function (Blueprint $table) {
           
            if(!Schema::hasColumn('inspirasis', 'video_url')) 
            {
                $table->string('video_url')->nullable()->after('video_id');
            }
            if(!Schema::hasColumn('inspirasis', 'audio_url')) 
            {
                $table->string('audio_url')->nullable()->after('audio_id');
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
            $table->dropColumn('audio_url');
        });
    }
}
