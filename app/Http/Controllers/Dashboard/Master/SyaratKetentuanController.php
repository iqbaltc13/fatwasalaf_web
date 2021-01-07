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
use App\Models\SyaratKetentuan;


class SyaratKetentuanController extends Controller
{
    //
    public function __construct()
    {
        $this->route  ='dashboard.master.syarat-ketentuan.';
        $this->view  ='dashboard.master.syarat_ketentuan.';
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
        $newObj      = new SyaratKetentuan();
       
        $datas       = SyaratKetentuan::with($this->withArraySelect);
            
        $datas  = $datas->orderByRaw($newObj->getTable().".created_at DESC");  
       

        return DataTables::of($datas)
       
        ->toJson();
    }
    public function edit($id, Request $request){
        $data       = SyaratKetentuan::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'edit',$arrReturn);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
            'jenis'       => 'required|unique:syarat_ketentuans,jenis,'.$id,
            'judul'       => 'required',
            'html_konten' => 'required',
        ]);
        DB::beginTransaction();
            $arrUpdate = [
                'jenis'       => $request->jenis,
                'judul'       => $request->judul,
                'html_konten' => $request->html_konten,
            ];
            $update = SyaratKetentuan::where('id',$id)
                      ->update($arrUpdate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit data syarat ketentuan');
    }
    public function create(Request $request){
        $arrReturn  = [
            'sidebar'      => 'master', 
        ];
                
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
            'jenis'       => 'required|unique:syarat_ketentuans,jenis',
            'judul'       => 'required',
            'html_konten' => 'required',
        ]);
        DB::beginTransaction();
        $arrCreate = [
            
            'jenis'       => $request->jenis,
            'judul'       => $request->judul,
            'html_konten' => $request->html_konten,
        ];
        $create = SyaratKetentuan::create($arrCreate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah data syarat ketentuan');
    }
    public function destroy(Request $request,$id){
        DB::beginTransaction();
       
        $delete     = SyaratKetentuan::where('id',$id)
                      ->delete();
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus data syarat ketentuan');
    }
    public function destroyJson(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);
        DB::beginTransaction();
     
        $delete     = SyaratKetentuan::where('id',$request->id)
                      ->delete();
        DB::commit();
        return $this->success('sukses menghapus data syarat ketentuan',$delete);
       
    }
    public function detail(Request $request,$id){
       
        $data       = SyaratKetentuan::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'detail',$arrReturn);

    }
    public function detailJson(Request $request,$id){
        $data       = SyaratKetentuan::with($this->withArraySelect)
                      ->where('id',$id)->first();
        return $this->success('sukses menampilkan data syarat ketentuan',$data);
    }
}
