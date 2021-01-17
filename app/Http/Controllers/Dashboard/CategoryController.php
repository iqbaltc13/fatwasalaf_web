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
        $this->route='dashboard.user.';
        $this->view='dashboard.user.';
    }
    public function index(){
        $arrReturn=[];
        return view($this->view.'index',$arrReturn);
    }
    public function data(Request $request){
    }
    public function edit($id){
        return view($this->view.'edit',$arrReturn);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
        ]);
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit instansi');
    }
    public function create(Request $request){
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
        ]);
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah instansi');
    }
    public function destroy(Request $request){
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus instansi');
    }
    public function destroyJson(Request $request){
        return response()->json($return);
    }
    public function detail(Request $request,$id){
        return view($this->view.'detail',$arrReturn);

    }
    public function detailJson(Request $request,$id){
        return response()->json($return);
    }
}
