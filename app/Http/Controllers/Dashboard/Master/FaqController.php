<?php

namespace App\Http\Controllers\Dashboard\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use stdClass;
use DateTime;
use DateInterval;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Validator;
use DB;
use DataTables;
use App\User;
use App\Http\Controllers\Helpers\WebHelperController;
use App\Models\Faq;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->route  ='dashboard.master.faq.';
        $this->view  ='dashboard.master.faq.';
        $this->withArraySelect   = [
            
        ];
    }
    public function index(){
        $arrReturn=[
            'sidebar'      => 'master', 
        ];
        return view($this->view.'index',$arrReturn);
    }
    public function datatable(Request $request){
        $newObj      = new Faq();
       
        $datas       = Faq::with($this->withArraySelect);
            
        $datas  = $datas->orderByRaw($newObj->getTable().".created_at DESC");  
       

        return DataTables::of($datas)
       
        ->toJson();
    }
    public function edit($id, Request $request){
        $data       = Faq::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'edit',$arrReturn);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
            'nomor'       => 'required|unique:faqs,nomor,'.$id,
            'judul'       => 'required',
            'konten'      => 'required',
        ]);
        DB::beginTransaction();
            $arrUpdate = [
                'nomor'       => $request->nomor,
                'judul'       => $request->judul,
                'konten'      => $request->konten,
            ];
            $update = Faq::where('id',$id)
                      ->update($arrUpdate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit data faq');
    }
    public function create(Request $request){
        $arrReturn  = [
            'sidebar'      => 'master', 
        ];
                
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
            'nomor'       => 'required|unique:faqs',
            'judul'       => 'required',
            'konten'      => 'required',
        ]);
        DB::beginTransaction();
        $arrCreate = [
            
            'nomor'       => $request->nomor,
            'judul'       => $request->judul,
            'konten'      => $request->konten,
        ];
        $create = Faq::create($arrCreate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah data faq');
    }
    public function destroy(Request $request,$id){
        DB::beginTransaction();
       
        $delete     = Faq::where('id',$id)
                      ->delete();
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus data faq');
    }
    public function destroyJson(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);
        DB::beginTransaction();
     
        $delete     = Faq::where('id',$request->id)
                      ->delete();
        DB::commit();
        return $this->success('sukses menghapus data faq',$delete);
       
    }
    public function detail(Request $request,$id){
       
        $data       = Faq::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'detail',$arrReturn);

    }
    public function detailJson(Request $request,$id){
        $data       = Faq::with($this->withArraySelect)
                      ->where('id',$id)->first();
        return $this->success('sukses menampilkan data faq',$data);
    }
}
