<?php

namespace App\Http\Controllers\Dashboard;

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

class PostController extends Controller
{
    public function __construct()
    {
        $this->route      ='dashboard.post.';
        $this->view       ='dashboard.post.';
        $this->sidebar    ='post'; 
    }
    public function index(){
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment',
        ])->orderBy('created_at', 'DESC');
        $datas = $datas->get();
        $arrReturn=[
            'arrData' => $datas
        ];
        return view($this->view.'index',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function data(Request $request){
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment',
        ])->orderBy('created_at', 'DESC');
        $datas = $datas->get();
        return $this->success('Permintaan berhasil diproses.',$datas);
    }
    public function datatable(Request $request){
        $datas = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment',
        ]);
        $datas       = $datas->orderBy('created_at','DESC');

        return DataTables::of($datas) 
        ->toJson();
       
    }
    public function edit($id){
        $data =  Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment',
        ])
        ->where('id',$id)->first();
        $categories     = Category::with([
           
        ]);
        $categories     = $categories->orderBy('created_at','DESC');
        $categories     = $categories->get();
        

        $arrReturn  = [
            'data'      => $data,
            'arrDataCategories'      => $categories,
            
        ];
        return view($this->view.'edit',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
           
            'title'    =>'required',
            'article'  =>'required',
           
        ]);
        if(is_null($request->categories)){
            return redirect()->back()->with('failed', 'Kategori belum diisi');
        }
        $arrUpdate=[
            
            'title'           =>$request->title,
            'article'         =>$request->article,
            
            'status'          =>1,
        ];
        $update = Post::where('id',$id)->update($arrUpdate);
        $arrIdCategories=$request->categories;
        foreach ($arrIdCategories as $key => $idCategory) {
            // $getPostXCategory = PostXCategory::with([])
            //                     ->where('post_id' , $id)
            //                     ->where('category_id', $idCategory)
            //                     ->first();
            // if($getPostXCategory){
            //     continue;
            // }
            $arrCreatePostXCategory=[
                'post_id'    => $id,
                'category_id'  => $idCategory,
            ];
            PostXCategory::where('post_id',$id)->update($arrCreatePostXCategory);
            $arrCreatePostXCategory=[];
            $getPostXCategory = NULL;
        }           
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit postingan');
    }
    public function create(Request $request){
        $categories     = Category::with([
           
        ]);
        $categories     = $categories->orderBy('created_at','DESC');
        $categories     = $categories->get();
        $arrReturn  = [
            'arrDataCategories'      => $categories,
           
            
        ];
        return view($this->view.'create',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function store(Request $request){
        $this->validate($request, [
           
            'title'    =>'required',
            'article'  =>'required',
           
        ]);
        if(is_null($request->categories)){
            return redirect()->back()->with('failed', 'Kategori belum diisi');
        }

        $arrCreate=[
            'total_accessed'  =>0,
            'author_id'       =>Auth::id(),
            'title'           =>$request->title,
            'article'         =>$request->article,
            'total_searched'  =>0,
            'status'          =>1,
        ];
        $create= Post::create($arrCreate);
        $arrIdCategories=$request->categories;
        foreach ($arrIdCategories as $key => $idCategory) {
            $arrCreatePostXCategory=[
                'post_id'    => $create->id,
                'category_id'  => $idCategory,
            ];
            PostXCategory::create($arrCreatePostXCategory);
            $arrCreatePostXCategory=[];
        }                
        
       

        
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah postingan');
    }
    public function destroy(Request $request){
        $data = Post::find($id);
        if($data){
            $data->delete();
        }
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus postingan');
    }
    public function destroyJson(Request $request){
        $data = Post::find($id);
        if($data){
            $data=$data->delete();
        }
        return response()->json($data);
    }
    public function detail(Request $request,$id){
        $data = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment',
        ])
        ->where('id',$id)->first();
        $arrReturn  = [
            'data'      => $data,
           
            
        ];
        return view($this->view.'detail',$arrReturn)->with('sidebar', $this->sidebar);

    }
    public function detailJson(Request $request,$id){
        $return = Post::with([
            'post_x_category',
            'post_x_category.category',
            'comment',
        ])
        ->where('id',$id)->first();
    
        return response()->json($return);
    }
}
