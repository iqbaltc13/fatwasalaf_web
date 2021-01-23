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

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->route      ='dashboard.category.';
        $this->view       ='dashboard.category.';
        $this->sidebar    ='master';
    }
    public function index(){
        $datas = Category::with([
            'category_x_post',
            'category_x_post.post',
        ])->orderBy('cresated_at', 'DESC');
        $datas = $datas->get();
        $arrReturn=[
            'arrData' => $datas
        ];
        return view($this->view.'index',$arrReturn);
    }
    public function data(Request $request){
        $datas = Category::with([
            'category_x_post',
            'category_x_post.post',
        ])->orderBy('created_at', 'DESC');
        $datas = $datas->get(); 
        return $this->success('Permintaan berhasil diproses.',$datas);

    }
    public function datatable(Request $request){
        $datas      = Category::with([
            'category_x_post',
            'category_x_post.post',
        ]);
        $datas       = $datas->orderBy('created_at','DESC');

        return DataTables::of($datas) 
        ->toJson();
       
    }
    public function edit($id){
        $data = Category::with([
            'category_x_post',
            'category_x_post.post',
        ])
        ->where('id',$id)->first();
       
     
        

        $arrReturn  = [
            'data'      => $data,
           
            
        ];
        return view($this->view.'edit',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
            'name' => 'required',
        ]);

        $arrUpdate=[
            'name'        =>$request->name,
            'description' =>'',
            'status'      =>1,
            
        ];
        $update= Category::where('id',$id)->update($arrUpdate);
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit kategori');
    }
    public function create(Request $request){
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
        ]);

        $arrCreate=[
            'name'        =>$request->name,
            'description' =>'',
            'status'      =>1,
            'creator'     =>Auth::id(),
        ];
        $create= Category::create($arrCreate);
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah kategori');
    }
    public function destroy(Request $request){
        $data = Category::find($id);
        if($data){
            $data->delete();
        }
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus kategori');
    }
    public function destroyJson(Request $request){
        $data = Category::find($id);
        if($data){
            $data=$data->delete();
        }
        return response()->json($data);
    }
    public function detail(Request $request,$id){
        $data = Category::with([
            'category_x_post',
            'category_x_post.post',
        ])
        ->where('id',$id)->first();
        $arrReturn  = [
            'data'      => $data,
           
            
        ];
        return view($this->view.'detail',$arrReturn);

    }
    public function detailJson(Request $request,$id){
        $return = Category::with([
            'category_x_post',
            'category_x_post.post',
        ])
        ->where('id',$id)->first();
    
        return response()->json($return);
    }
}
