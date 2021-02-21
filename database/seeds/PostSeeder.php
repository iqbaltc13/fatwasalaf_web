<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\PostXCategory;
use App\Models\Category;


class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('disabling foreignkeys check');
        Schema::disableForeignKeyConstraints();
        $this->command->info('truncating tables...');
        DB::table('posts_x_categories')->truncate();
        DB::table('posts')->truncate();
        DB::table('categories')->truncate();
        //Schema::enableForeignKeyConstraints();
        
        //Province
        $this->command->info('adding post , category and posts_x_categories .');
        $rozaan            = array_map('str_getcsv', file(public_path('assets/excel/rozan2.csv')));
        dd($rozaan);
        $sunnahFollower    = array_map('str_getcsv', file(public_path('assets/excel/FATWASALAF_SUNNAH_FOLLOWER.csv')));
        // foreach ($rozaan as $key => $value) {
        //     $checkCategory =  NULL;



        //     $arrCreatePost=[
        //         'total_accessed'  =>0,
        //         'author_id'       =>Auth::id(),
        //         'title'           =>$request->title,
        //         'article'         =>$request->article,
        //         'total_searched'  =>0,
        //         'status'          =>1,
        //     ];
        //     $arrCreatePostXCategory=[
        //             'post_id'    => $create->id,
        //             'category_id'  => $idCategory,
        //         ];


	    //     DB::table('provinsi')->insert(['id' 	=> $value[0],
        //                                     'nama'	=> ucwords($value[1]),
        //                                     'created_at'    => (new DateTime("2018-12-31 13:05:21"))->format("Y-m-d H:i:s"),
        //                                     'updated_at'    => (new DateTime("2018-12-31 13:05:21"))->format("Y-m-d H:i:s")
        //                                 ]);
        // }

    }
}
