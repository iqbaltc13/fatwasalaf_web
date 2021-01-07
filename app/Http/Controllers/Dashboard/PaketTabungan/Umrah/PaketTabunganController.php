<?php

namespace App\Http\Controllers\Dashboard\PaketTabungan\Umrah;

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
use App\Models\PaketTabunganUmrah;
use App\Models\DetailBiayaUmrah ;
use App\Http\Controllers\Helpers\UploadFileController;

class PaketTabunganController extends Controller
{
    public function __construct()
    {
        $this->route  ='dashboard.paket-tabungan.umrah.';
        $this->view  ='dashboard.paket_tabungan.umrah.';
        $this->withArraySelect   = [
            'detail_biaya',
            'detail_biaya.icon',
           
        ];
        $this->helper_upload     = new UploadFileController();
    }
    public function index(){
        $arrReturn=[
            'sidebar'      => 'master', 
        ];
        return view($this->view.'index',$arrReturn);
    }
    public function datatable(Request $request){
        $newObj      = new PaketTabunganUmrah();
       
        $datas       = PaketTabunganUmrah::with($this->withArraySelect);
            
        $datas  = $datas->orderByRaw($newObj->getTable().".created_at DESC");  
       

        return DataTables::of($datas)
       
        ->toJson();
    }
    public function edit($id, Request $request){
        $data       = PaketTabunganUmrah::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data'         =>  $data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'edit',$arrReturn);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
            'nama'               => 'required',
            'deskripsi'          => 'required',
            'biaya_administrasi' => 'required',
            'is_default'         => 'required',
            'nominal_tabungan'   => 'required',
           
            
        ]);
        DB::beginTransaction();
            $arrUpdate = [
                'nama'                    => $request->nama,
                'deskripsi'               => $request->deskripsi,
                'biaya_administrasi'      => $request->biaya_administrasi,
                'is_default'              => $request->is_default,
                'nominal_tabungan'        => $request->nominal_tabungan,
                'last_updated_by_name'    => Auth::user()->name,
                
            ];
          
            $update = PaketTabunganUmrah::where('id',$id)
                      ->update($arrUpdate);
            

            if($request->detail_biaya_last_id){
                $arrIdDetailBiaya=$request->detail_biaya_last_id;
                DetailBiayaUmrah::where('paket_tabungan_umrah_id',$id)->whereNotIn('id',$arrIdDetailBiaya)->delete();
            }
            else{
                DetailBiayaUmrah::where('paket_tabungan_umrah_id',$id)->delete();
            }   
            
            $createPaketTabunganId = $id;
            
            $detailBiayaNominal    = $request->detail_biaya_nominal;
            $detailBiayaIcon       = $request->detail_biaya_icon;
            if($request->detail_biaya_icon){
                            
                $uploadIcon = $this->helper_upload->uploadFileArray($request,'detail_biaya_icon','Icon');
                
            }
            if( $detailBiayaNominal && $detailBiayaIcon){
                foreach ($detailBiayaIcon as $key => $value) {
                        $arrCreateDetailBiaya=[];
                        $arrCreateDetailBiaya['deskripsi']                  = $request->detail_biaya_deskripsi[$key];
                        $arrCreateDetailBiaya['nominal']                    = $request->detail_biaya_nominal[$key];
                        $arrCreateDetailBiaya['paket_tabungan_umrah_id']    = $createPaketTabunganId;
                        
                        $arrCreateDetailBiaya['icon_file_id']               = $uploadIcon[$key];
                        
                        $create = DetailBiayaUmrah::create( $arrCreateDetailBiaya);
                }
                
            }
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit data paket tabungan umrah');
    }
    public function create(Request $request){
        $arrReturn  = [
            'sidebar'      => 'master', 
        ];
                
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
            'nama'               => 'required',
            'deskripsi'          => 'required',
            'biaya_administrasi' => 'required',
            'is_default'         => 'required',
            'nominal_tabungan'   => 'required',
           
            
        ]);
        DB::beginTransaction();
        $arrCreate = [
            
            'nama'               => $request->nama,
            'deskripsi'          => $request->deskripsi,
            'biaya_administrasi' => $request->biaya_administrasi,
            'is_default'         => $request->is_default,
            'nominal_tabungan'   => $request->nominal_tabungan,
            'created_by_name'    => Auth::user()->name,
        ];
        
        $create = PaketTabunganUmrah::create($arrCreate);
        $createPaketTabunganId =  $create->id;
        
        $detailBiayaNominal    = $request->detail_biaya_nominal;
        $detailBiayaIcon       = $request->detail_biaya_icon;
        if($request->detail_biaya_icon){
                       
            $uploadIcon = $this->helper_upload->uploadFileArray($request,'detail_biaya_icon','Icon');
            
        }
        if($detailBiayaNominal && $detailBiayaIcon){
            foreach ($detailBiayaIcon as $key => $value) {
                    $arrCreateDetailBiaya=[];
                    $arrCreateDetailBiaya['deskripsi']                  = $request->detail_biaya_deskripsi[$key];
                    $arrCreateDetailBiaya['nominal']                    = $request->detail_biaya_nominal[$key];
                    $arrCreateDetailBiaya['paket_tabungan_umrah_id']    = $createPaketTabunganId;
                   
                    $arrCreateDetailBiaya['icon_file_id']               = $uploadIcon[$key];
                    
                    $create = DetailBiayaUmrah::create( $arrCreateDetailBiaya);
            }
           
        }
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah data paket tabungan umrah');
    }
    public function destroy(Request $request,$id){
        DB::beginTransaction();
       
        $delete     = PaketTabunganUmrah::where('id',$id)
                      ->delete();
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus data paket tabungan umrah');
    }
    public function destroyJson(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);
        DB::beginTransaction();
     
        $delete     = PaketTabunganUmrah::where('id',$request->id)
                      ->delete();
        DB::commit();
        return $this->success('sukses menghapus data paket tabungan umrah',$delete);
       
    }
    public function detail(Request $request,$id){
       
        $data       = PaketTabunganUmrah::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'detail',$arrReturn);

    }
    public function detailJson(Request $request,$id){
        $data       = PaketTabunganUmrah::with($this->withArraySelect)
                      ->where('id',$id)->first();
        return $this->success('sukses menampilkan data paket tabungan umrah',$data);
    }
}
