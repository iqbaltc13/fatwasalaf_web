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
use App\Models\MitraTravel;
use App\Http\Controllers\Helpers\UploadFileController;


class MitraTravelController extends Controller
{
    public function __construct()
    {
        $this->route  ='dashboard.master.mitra-travel.';
        $this->view  ='dashboard.master.mitra_travel.';
        $this->withArraySelect   = [
           'logo',
        ];
        $this->helper_upload     = new UploadFileController();
        $this->helper_web        = new WebHelperController();
    }
    public function index(){
        $arrReturn=[
            'sidebar'      => 'master', 
        ];
        return view($this->view.'index',$arrReturn);
    }
    public function datatable(Request $request){
        $newObj      = new MitraTravel();
       
        $datas       = MitraTravel::with($this->withArraySelect);
            
        $datas  = $datas->orderByRaw($newObj->getTable().".created_at DESC");  
       

        return DataTables::of($datas)
       
        ->toJson();
    }
    public function edit($id, Request $request){
        $data       = MitraTravel::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'edit',$arrReturn);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
            'logo'                 => 'required',
            'order'                => 'required',
            'nama'                 => 'required',
            'nama_direktur'        => 'required',
            'lokasi_kantor'        => 'required',
            'titik_keberangkatan'  => 'required',
            'telepon'              => 'required',
            'website'              => 'required',
            'social_media'         => 'required',
            'tahun_berdiri'        => 'required',
            'deskripsi'            => 'required',
            'no_izin_kemenag'      => 'required',
            'is_active'            => 'required',

        ]);
        DB::beginTransaction();
            $arrUpdate = [
                'order'                => $request->order,
                'nama'                 => $request->nama,
                'nama_direktur'        => $request->nama_direktur,
                'lokasi_kantor'        => $request->lokasi_kantor,
                'titik_keberangkatan'  => $request->titik_keberangkatan,
                'telepon'              => $request->telepon,
                'website'              => $request->website,
                'social_media'         => $request->social_media,
                'tahun_berdiri'        => $request->tahun_berdiri,
                'deskripsi'            => $request->deskripsi,
                'no_izin_kemenag'      => $request->no_izin_kemenag,
                'is_active'            => $request->is_active,
            ];
            if($request->logo){
               
                
                $uploadLogo             = $this->helper_upload->uploadFile($request,'logo','logo');
                $arrUpdate['logo_id']  = $uploadLogo    ?  $uploadLogo->id : NULL ;
            }
            $update = MitraTravel::where('id',$id)
                      ->update($arrUpdate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit data mitra-travel');
    }
    public function create(Request $request){
        $arrReturn  = [
            'sidebar'      => 'master', 
        ];
                
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
            // 'logo'                 => 'required',
            'order'                => 'required',
            'nama'                 => 'required',
            'nama_direktur'        => 'required',
            'lokasi_kantor'        => 'required',
            'titik_keberangkatan'  => 'required',
            'telepon'              => 'required',
            'website'              => 'required',
            'social_media'         => 'required',
            'tahun_berdiri'        => 'required',
            'deskripsi'            => 'required',
            'no_izin_kemenag'      => 'required',
            'is_active'            => 'required',
        ]);
        DB::beginTransaction();
        $arrCreate = [
            
            'order'                => $request->order,
            'nama'                 => $request->nama,
            'nama_direktur'        => $request->nama_direktur,
            'lokasi_kantor'        => $request->lokasi_kantor,
            'titik_keberangkatan'  => $request->titik_keberangkatan,
            'telepon'              => $request->telepon,
            'website'              => $request->website,
            'social_media'         => $request->social_media,
            'tahun_berdiri'        => $request->tahun_berdiri,
            'deskripsi'            => $request->deskripsi,
            'no_izin_kemenag'      => $request->no_izin_kemenag,
            'is_active'            => $request->is_active,
        ];
        if($request->logo){
               
                
            $uploadLogo             = $this->helper_upload->uploadFile($request,'logo','logo');
            $arrCreate['logo_id']   = $uploadLogo    ?  $uploadLogo->id : NULL ;
        }
        $create = MitraTravel::create($arrCreate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah data mitra travel');
    }
    public function destroy(Request $request,$id){
        DB::beginTransaction();
       
        $delete     = MitraTravel::where('id',$id)
                      ->delete();
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus data mitra travel');
    }
    public function destroyJson(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);
        DB::beginTransaction();
     
        $delete     = MitraTravel::where('id',$request->id)
                      ->delete();
        DB::commit();
        return $this->success('sukses menghapus data mitra travel',$delete);
       
    }
    public function detail(Request $request,$id){
       
        $data       = MitraTravel::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data'         => $data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'detail',$arrReturn);

    }
    public function detailJson(Request $request,$id){
        $data       = MitraTravel::with($this->withArraySelect)
                      ->where('id',$id)->first();
        return $this->success('sukses menampilkan data mitra travel',$data);
    }
}
