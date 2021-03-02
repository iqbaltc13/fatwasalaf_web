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
        $latest = $datas->orderBy('created_at', 'DESC')->take(3)->get();
        $datas =$datas->inRandomOrder()->take(3);

        $datas = $datas->get();

        $arrReturn  = [
              'navbar' => 'index',
            'arrData' => $datas,
            'latest' =>$latest
            
        ];
 // dd($latest);
        return view($this->view.'index',$arrReturn)->with('sidebar', $this->sidebar);

    }

    //halaman blog
        public function blog(Request $request){
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment'
            ]);
        $datas =$datas->inRandomOrder()->take(3);

        $datas = $datas->get();

        $arrReturn  = [
              'navbar' => 'blog',
            'arrData' => $datas,
            
        ];
        
        return view($this->view.'blog',$arrReturn)->with('sidebar', $this->sidebar);

    }
    //halaman detail post
    public function detail(Request $request,$id){
        // dd($id);
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment'
            ]);
        $datas =$datas->where('id',$id);

        $datas = $datas->first();

         $prevId = Post::where('id', '<', $datas->id)->max('id');
         $nextId = Post::where('id', '>', $datas->id)->min('id');
         // dd($nextId);
         $prevTitle =Post::where('id',$prevId)->value('title');
         $nextTitle =Post::where('id',$nextId)->value('title');
         // dd($nextTitle);
         // dd($nextTitle);
        $dataCategories = Category::with([
            'category_x_post',
        
        ]);
        $latest = $datas->orderBy('created_at', 'DESC')->take(3)->get();

        $dataCategories = $dataCategories->get();

        

        $arrReturn  = [
            'arrData' => $datas,
            'arrDataCategory' =>$dataCategories,
            'latest'    =>$latest
            
        ];
        
        return view($this->view.'post',$arrReturn)->with('sidebar', $this->sidebar)->with('prevId',$prevId)->with('nextId',$nextId)->with('prevTitle',$prevTitle)->with('nextTitle',$nextTitle);
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
        $latest = $datas->orderBy('created_at', 'DESC')->take(3)->get();
        // dd($latest);
        $datas =$datas->inRandomOrder()->paginate(4);

        // $datas = $datas->get();
        $dataCategories = Category::with([
            'category_x_post',
        
        ]);
    

        $dataCategories = $dataCategories->get();

        // dd($dataCategories);

        $arrReturn  = [
            'arrData' => $datas,
            'arrDataCategory' =>$dataCategories,
            'navbar' => 'index',
            'latest' => $latest
            
        ];

        return view($this->view.'blog',$arrReturn)->with('sidebar', $this->sidebar);

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

    public function insertComment(Request $request){
        $arrCreate=[
            

            'comment'             => $request->comment_content,
            'name'                => $request->comment_name,
            'post_id'             => $request->post_id,
            

           
        ];
        
        $createComment=Comment::create($arrCreate);
        return $this->success('Berhasil',$createComment);
        

    }

    public function loadComment(Request $request){
        
        $comment = Comment::where('post_id',$request->post_id)->get();
        $i=0;
        foreach ($comment as $komen) {

            $output = '
 <div class="comment"><hr>
                  <div class="comment-header d-flex justify-content-between">
                    <div class="user d-flex align-items-center">
                      
                      <div class="title"><strong>'.$komen->name.'</strong><span class="date">'.$komen->created_at->format(' d M Y H.i').' WIB</span></div>
                    </div>
                  </div>
                  <div class="comment-body">
                    <p>'.$komen->comment.'</p>
                  </div>
                </div>
 ';
    echo $output;
        }
        
    }


    public function cariPost(Request $request){


        return redirect()->route('blog.cari-data',['kunci'=>$request['kunci']]);
    }

    public function cariData($kunci){
         $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment'
            ]);
        $latest = $datas->orderBy('created_at', 'DESC')->take(3)->get();
        // dd($latest);
        $datas =$datas->where('title', 'like', "%{$kunci}%")->paginate(4);
        
        // $datas = $datas->get();
        $dataCategories = Category::with([
            'category_x_post',
        
        ]);
    

        $dataCategories = $dataCategories->get();

        // dd($dataCategories);

        $arrReturn  = [
            'arrData' => $datas,
            'arrDataCategory' =>$dataCategories,
            'navbar' => 'index',
            'latest' => $latest
            
        ];

        return view($this->view.'blog',$arrReturn)->with('sidebar', $this->sidebar);
    
    }
}