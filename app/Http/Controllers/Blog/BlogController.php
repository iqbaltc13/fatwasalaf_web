<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostXCategory;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Category;
use App\Models\LogSearch;
use App\User;
use DateTime;
use stdClass;
use DateInterval;
use Auth;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Validator;
use DB;
use DataTables;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->route      ='blog.';
        $this->view       ='blog.';
        $this->sidebar    ='blog';
       
        
    }
    //halaman awal
    public function index(Request $request){
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment'
            ]);
        $datas =$datas->inRandomOrder()->take(3);

        $datas = $datas->get();

        $arrReturn  = [
            'arrData' => $datas,
            
        ];

        return view($this->view.'index',$arrReturn)->with('sidebar', $this->sidebar);

    }
    //halaman detail post
    public function detail(Request $request,$id){
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment'
            ]);
        $datas =$datas->where('id',$id);

        $datas = $datas->first();

        $dataCategories = Category::with([
            'category_x_post',
        
        ]);
    

        $dataCategories = $dataCategories->get();

        

        $arrReturn  = [
            'arrData' => $datas,
            'arrDataCategory' =>$dataCategories
            
        ];

        return view($this->view.'post',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function submitComment(Request $request,$idPost){
        $this->validate($request, [
            
            'comment'            => 'required',
            'name'               => 'required',
            'email'              => 'required|email'
        ]);
        
       
        $arrCreate=[
            

            'comment'             => $request->comment,
            'name'                => $request->name,
            'post_id'             => $idPost,
            'email'               => $request->email,

           
        ];
       

       
        $createComment=Comment::create($arrCreate);
        return $this->success('Berhasil',$createComment);
        
    }
    public function listComment(Request $request,$idPost){
        $datas = Category::with([
                'category_x_post',
            
            ]);
        

        $datas = $datas->get();

        return $this->success('Berhasil',$datas);

    }
    public function data(Request $request){

    }
    public function listCategory(Request $request){
        $datas = Category::with([
            'category_x_post',
            'category_x_post.post',
        
        ]);
        $datas =$datas->where('post_id',$idPost);
        $datas =$datas->orderBy('created_at','DESC');

        $datas = $datas->get();

        return $this->success('Berhasil',$datas);

    }
    //halaman blog
    public function indexBlog(Request $request){
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment'
            ]);
        $datas =$datas->inRandomOrder()->take(4);

        $datas = $datas->get();
        $dataCategories = Category::with([
            'category_x_post',
        
        ]);
    

        $dataCategories = $dataCategories->get();

        

        $arrReturn  = [
            'arrData' => $datas,
            'arrDataCategory' =>$dataCategories
            
        ];

        return view($this->view.'post',$arrReturn)->with('sidebar', $this->sidebar);

    }
    public function search(Request $request){
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment'
            ]);
        $datas =$datas->where('article','LIKE','%'.$request->keyword.'%')->take(4);

        $datas = $datas->get();
        $dataCategories = Category::with([
            'category_x_post',
        
        ]);
    

        $dataCategories = $dataCategories->get();

        

        $arrReturn  = [
            'arrData' => $datas,
            'arrDataCategory' =>$dataCategories
            
        ];

        return view($this->view.'post',$arrReturn)->with('sidebar', $this->sidebar);

    }
    public function latestPost($limit){
        $data = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment'
            ])->orderBy('created_at', 'DESC')->take($limit);

        $data = $data->get();

        return $this->success('Berhasil',$data);
        

    }
}
