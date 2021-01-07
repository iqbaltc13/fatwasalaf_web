<?php

namespace App\Http\Controllers\Api\V1\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use App\Models\Jamaah;
use App\Models\DaftarHaji;
use App\Models\DaftarHajiLog;
use App\Models\PembayaranHaji;
use App\Models\Kbih;
use App\Models\SettingNominalHajiMuda;
use Auth;
use App\Models\PaketTabunganUmrah;
use App\Models\TabunganUmrah;
use App\Helpers\VirtualAccount;
use App\Models\Nasabah;
use DB;
use App\Models\SettingBms;
use App\Models\InfoSlider;

class InfoSliderController extends Controller{
    public function upsert(Request $request){
        $rules = [
            'title'             => 'required|string',
            'position'          => 'required|string',
            'image_slide_id'    => 'required|string',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        if(isset($request->id)){
            $data                        = InfoSlider::find($request->id);
            if($data){
                $this->failure('Info Slider tidak ditemukan');
            }
        }else{
            $data                           = new InfoSlider();
        }
        
        $data->title                        = $request->title;
        $data->subtitle                     = $request->subtitle;
        $data->description                  = $request->description;
        $data->position                     = $request->position;
        $data->html                         = $request->html;
        $data->order                        = $request->order;
        $data->is_active                    = $request->is_active?$request->is_active:true;
        $data->image_slide_id               = $request->image_slide_id;
        $data->image_content_id             = $request->image_content_id;
        $data->save();
        $data->refresh();
        DB::commit();
        return $this->success('Berhasil',$data);
    }

    public function delete(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:info_sliders,id',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data    = InfoSlider::find($request->id);
        $data->delete();
        return $this->success('Berhasil dihapus.');
    }

    public function detail(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:info_sliders,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = InfoSlider::find($request->id);
        $data->load(['image_slide','image_content']);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $rules = [
            'position'         => 'required|string',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $datas    = InfoSlider::select('id','title','subtitle','description','position','image_slide_id','order','html','created_at')
        ->orderBy('order')
        ->where('position',$request->position)
        ->get();
        $datas->load(['image_slide']);
        foreach($datas as $data){
            if($data->html){
                $data->html = "exists";
            }
        }
        return $this->success(@count($datas).' datax berhasil ditampilkan', $datas);
    }
}
