<?php

namespace App\Http\Controllers\Dashboard\Inspirasi;

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
use App\Models\Inspirasi;
use App\Models\InspirasiComment;
use App\Models\InspirasiLike;
use App\Models\InspirasiShare;
use App\Models\InspirasiView;
use App\Http\Controllers\Helpers\UploadFileController;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->route  ='dashboard.inspirasi.video.';
        $this->view  ='dashboard.inspirasi.video.';
        $this->withArraySelect   = [
            'thumbnail',
            'header_image',
            'audio',
            'video',
            'comments',
            'likes',
            'shares',
            'views',
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
        $newObj      = new Inspirasi();
       
        $datas       = Inspirasi::with($this->withArraySelect)->where('type','video');;
            
        $datas  = $datas->orderByRaw($newObj->getTable().".created_at DESC");  
       

        return DataTables::of($datas)
       
        ->toJson();
    }
    public function edit($id, Request $request){
        $data       = Inspirasi::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'edit',$arrReturn);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
            'title'             => 'required',
            'subtitle'          => 'required',
            'description'       => 'required',
            //'thumbnail'         => 'required',
            'video_url'         => 'required',
            'duration_second'   => 'required',
            'is_active'         => 'required',
        ]);
        DB::beginTransaction();
            $arrUpdate = [
                'title'             => $request->title,
                'subtitle'          => $request->subtitle,
                'description'       => $request->description,
                'type'              => 'video',
                'duration_second'   => $request->duration_second,
                'video_url'         => $request->video_url,
            ];
            if($request->thumbnail){
                $uploadThumbnail             = $this->helper_upload->uploadFile($request,'thumbnail','thumbnail');
                $arrUpdate['thumbnail_id']   = $uploadThumbnail ?$uploadThumbnail->id : NULL;
            }
            $update = Inspirasi::where('id',$id)
                      ->update($arrUpdate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit data inspirasi');
    }
    public function create(Request $request){
        $arrReturn  = [
            'sidebar'      => 'master', 
        ];
                
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
            'title'             => 'required',
            'subtitle'          => 'required',
            'description'       => 'required',
            'thumbnail'         => 'required',
            'video_url'         => 'required',
            'duration_second'   => 'required',
            'is_active'         => 'required',
        ]);
        DB::beginTransaction();
        $arrCreate = [
            
            'title'             => $request->title,
            'subtitle'          => $request->subtitle,
            'description'       => $request->description,
            'type'              => 'video',
            'duration_second'   => $request->duration_second,
            'video_url'         => $request->video_url,
        ];
        if($request->thumbnail){
            $uploadThumbnail             = $this->helper_upload->uploadFile($request,'thumbnail','thumbnail');
            $arrCreate['thumbnail_id']   = $uploadThumbnail ? $uploadThumbnail->id : NULL;
        }
        $create = Inspirasi::create($arrCreate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah data inspirasi');
    }
    public function destroy(Request $request,$id){
        DB::beginTransaction();
       
        $delete     = Inspirasi::where('id',$id)
                      ->delete();
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus data inspirasi');
    }
    public function destroyJson(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);
        DB::beginTransaction();
     
        $delete     = Inspirasi::where('id',$request->id)
                      ->delete();
        DB::commit();
        return $this->success('sukses menghapus data inspirasi',$delete);
       
    }
    public function detail(Request $request,$id){
       
        $data       = Inspirasi::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'detail',$arrReturn);

    }
    public function detailJson(Request $request,$id){
        $data       = Inspirasi::with($this->withArraySelect)
                      ->where('id',$id)->first();
        return $this->success('sukses menampilkan data inspirasi',$data);
    }
}
