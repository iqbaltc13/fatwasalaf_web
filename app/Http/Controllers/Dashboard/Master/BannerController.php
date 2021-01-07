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
use App\Models\InfoSlider;
use App\Http\Controllers\Helpers\UploadFileController;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->route             ='dashboard.master.info-slider.';
        $this->view              ='dashboard.master.info_slider.';
        $this->withArraySelect   = [
            'image_slide',
            'image_content',
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
        $newObj      = new InfoSlider();
       
        $datas       = InfoSlider::with($this->withArraySelect);
            
        $datas  = $datas->orderByRaw($newObj->getTable().".created_at DESC");  
       

        return DataTables::of($datas)
       
        ->toJson();
    }
    public function edit($id, Request $request){
        $data       = InfoSlider::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'edit',$arrReturn);
    }
    public function update(Request $request,$id){
        $this->validate($request, [
            'title'         => 'required',
           // 'html'          => 'required',
            'position'      => 'required',
            'is_active'     => 'required',
            'image_slide'   => 'required',
            //'image_content' => 'required',
            'order'         => 'required', 
            
        ]);
        DB::beginTransaction();
            $arrUpdate = [
                'title'       => $request->title,
                'html'        => $request->html,
                'position'    => $request->position,
                'is_active'   => $request->is_active,
                'order'       => $request->order,
            ];
            if($request->image_slide){
               
                
                $uploadImageSlide               = $this->helper_upload->uploadFile($request,'image_slide','image_slide');
                $arrUpdate['image_slide_id']    = $uploadImageSlide  ? $uploadImageSlide->id : NULL ;
            }
            if($request->image_content){
               
                
                $uploadImageContent             = $this->helper_upload->uploadFile($request,'image_content','image_content');
                $arrUpdate['image_content_id']  = $uploadImageContent ? $uploadImageContent->id : NULL;
            }
            $update = InfoSlider::where('id',$id)
                      ->update($arrUpdate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit data banner');
    }
    public function create(Request $request){
        $arrReturn  = [
            'sidebar'      => 'master', 
        ];
                
        return view($this->view.'create',$arrReturn);
    }
    public function store(Request $request){
        $this->validate($request, [
            'title'         => 'required',
           // 'html'          => 'required',
            'position'      => 'required',
            'is_active'     => 'required',
            'image_slide'   => 'required',
           // 'image_content' => 'required', 
            'order'         => 'required', 
        ]);
        DB::beginTransaction();
      
        $arrCreate = [
            'title'       => $request->title,
            'html'        => $request->html,
            'position'    => $request->position,
            'is_active'   => $request->is_active,
            'order'       => $request->order,
        ];
        if($request->image_slide){
               
                
            $uploadImageSlide               = $this->helper_upload->uploadFile($request,'image_slide','image_slide');
            $arrCreate['image_slide_id']    = $uploadImageSlide  ? $uploadImageSlide->id : NULL ;
        }
        if($request->image_content){
           
            
            $uploadImageContent             = $this->helper_upload->uploadFile($request,'image_content','image_content');
            $arrCreate['image_content_id']  = $uploadImageContent ? $uploadImageContent->id : NULL;
        }
        $create = InfoSlider::create($arrCreate);
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah data banner');
    }
    public function destroy(Request $request,$id){
        DB::beginTransaction();
       
        $delete     = InfoSlider::where('id',$id)
                      ->delete();
        DB::commit();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus data banner');
    }
    public function destroyJson(Request $request){
        $this->validate($request, [
            'id' => 'required'
        ]);
        DB::beginTransaction();
     
        $delete     = InfoSlider::where('id',$request->id)
                      ->delete();
        DB::commit();
        return $this->success('sukses menghapus data banner',$delete);
       
    }
    public function detail(Request $request,$id){
       
        $data       = InfoSlider::with($this->withArraySelect)
                      ->where('id',$id)->first();
        $arrReturn  = [
            'data' =>$data,
            'sidebar'      => 'master', 
        ];
        return view($this->view.'detail',$arrReturn);

    }
    public function detailJson(Request $request,$id){
        $data       = InfoSlider::with($this->withArraySelect)
                      ->where('id',$id)->first();
        return $this->success('sukses menampilkan data banner',$data);
    }
}
