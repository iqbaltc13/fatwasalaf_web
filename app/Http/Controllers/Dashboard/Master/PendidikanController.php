<?php

namespace App\Http\Controllers\Dashboard\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPendidikan;
use Auth;
use stdClass;
use DateTime;
use DateInterval;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Validator;
use DB;
use DataTables;

class PendidikanController extends Controller
{
    public function __construct()
    {
        $this->route      ='dashboard.master.pendidikan.';
        $this->view       ='dashboard.master.pendidikan.';
        $this->sidebar    ='master';
       
        
    }
   
    public function index(Request $request){
        $datas      = MasterPendidikan::query()
        ->get(); 
        $arrReturn  = [
            'arrData' => $datas,
            
        ];
        return view($this->view.'index',$arrReturn)->with('sidebar', $this->sidebar);;
    }
    public function data(Request $request){
        $datas      = MasterPendidikan::query()
        ->get(); 
        return $this->success('Permintaan berhasil diproses.',$datas);

    }
    public function datatable(Request $request){
        $datas      = MasterPendidikan::query();
        
        
        
        $datas            = $datas->orderBy('created_at','DESC');

        return DataTables::of($datas)
        //  ->addColumn('link_gambar', function(PromoBanner $banner) {
        //     $link = asset("images/product-not-found.png");
        //     if($banner->gambar){
        //         $link=asset($banner->gambar->path_thumbnail);
        //     }
            
        //     return $link;
        // })
        
        ->toJson();

       
    }
    public function detailJson(Request $request,$id){
        $data = MasterPendidikan::query()
        ->where('id',$id)->first();
        
     
        
        return $this->success('Permintaan berhasil diproses.',$data);
        
    }
    

    
    public function edit(Request $request,$id){
       
        $data = MasterPendidikan::query()
        ->where('id',$id)->first();
       
     
        

        $arrReturn  = [
            'data'      => $data,
           
            
        ];
        return view($this->view.'edit',$arrReturn)->with('sidebar', $this->sidebar);

    }
    public function destroy(Request $request,$id){
        $data = MasterPendidikan::find($id);
        if($data){
            $data->delete();
        }
        return $this->success("berhasil dihapus");
    }
    public function update(Request $request,$id){
        //dd($request->all());
        $this->validate($request, [
            
            'nama'                     =>'required',
            'is_active'             =>'required',
           
           
            
            
        ]);
        
       
        $arrUpdate=[
            
            'nama'                     =>$request->nama,
            'is_active'                =>$request->is_active,
            
           
        ];
        

       
        $updateBanner=MasterPendidikan::where('id',$id)
        ->update($arrUpdate);
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit data permission');
    }

    public function store(Request $request){
        $this->validate($request, [
            
            'nama'                     =>'required',
            'is_active'             =>'required',
           
           
           
            
            
        ]);
        
       
        $arrCreate=[
            

            'nama'                     =>$request->nama,
            'is_active'                =>$request->is_active,
           
        ];
       

       
        $createBanner=MasterPendidikan::create($arrCreate);
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah data permission');
    }
    public function create(Request $request){
      
        

        $arrReturn  = [
            
            //'arrKategori'  => $kategori,
            
        ];
        return view($this->view.'create',$arrReturn)->with('sidebar', $this->sidebar);
    }
}
