<?php

namespace App\Http\Controllers\Api\V1\Profile\Review;

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
use App\Models\Review;

class ReviewController extends Controller{

    public function create(Request $request){
        $rules = [
            'review'                => 'required|string',
            'rate'                  => 'required|integer|in:1,2,3,4,5',
        ];

        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        DB::beginTransaction();
        $user                               = User::find(Auth::id());
        Review::where('user_id',$user->id)->delete();
        $new_data                           = new Review();
        $new_data->user_id                  = $user->id;
        $new_data->review                   = $request->review;
        $new_data->rate                     = $request->rate;
        $new_data->file_id                  = $request->file_id;
        $new_data->save();
        $new_data->refresh();
        DB::commit();
        $datas           = Review::all();
        $datas->load(['user','file','comments','likes']);
        return $this->success(@count($datas).' data berhasil ditampilkan.',$datas);
    }

    public function update(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:reviews,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data                               = Review::find($request->id);
        $payloads                           = $request->all();
        unset($payloads["id"]);
        try { 
          $data->update($payloads);
        } catch(\Illuminate\Database\QueryException $ex){ 
          return $this->failure($ex);
        }
        $new_data    = Review::find($request->id);
        return $this->success('Berhasil diupdate.', $new_data);
    }

    public function delete(Request $request){
        Review::where('user_id',Auth::id())->delete();
        $datas           = Review::all();
        $datas->load(['user','file','comments','likes']);
        return $this->success('Berhasil dihapus.',$datas);
    }

    public function get(Request $request){
        $rules = [
            'id'         => 'required|integer|exists:reviews,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $data           = Review::find($request->id);
        $data->load(['user.file','file','comments.user.file','likes']);
        return $this->success('Berhasil', $data);
    }

    public function all(Request $request){
        $datas           = Review::orderBy('created_at','desc')->get();
        $datas->load(['user.file','file','likes','comments.user.file']);
        return $this->success(@count($datas).' berhasil ditampilkan.', $datas);
    }
}
