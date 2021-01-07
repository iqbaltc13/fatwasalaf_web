<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\File;

class ChangeFullPathToHttpsOnFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model-file:change-full-http-to-https';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = File::with([])->get();
        foreach ($files as $key => $file) {
            if($file->full_path){
                $full_path=str_replace("http:","https:",$file->full_path);
                $file->full_path=str_replace("thumb_","",$full_path);
                
            }
            if($file->full_path_thumbnail){
                $file->full_path_thumbnail=str_replace("http:","https:",$file->full_path_thumbnail);
                
            }
            // if($file->full_path){
            //     $file->full_path=str_replace("//198.167.141.141/","//mobile.myduma.id/",$file->full_path);
                
            // }
            // if($file->full_path_thumbnail){
            //     $file->full_path_thumbnail=str_replace("//198.167.141.141/","//mobile.myduma.id/",$file->full_path_thumbnail);
                
            // }
            $file->save();
        }
    }
}
