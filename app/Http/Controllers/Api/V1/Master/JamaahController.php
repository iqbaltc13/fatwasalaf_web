<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\Models\Jamaah;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;
use App\User;
use App\Notifications\FirebasePushNotif;
use App\Models\Role;
use App\Models\RoleUser;

class JamaahController extends Controller
{
    //
    public function list(Request $request)
    {
        $rules = [
            // 'per_page'              => 'required|integer'
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        if(Auth::user()){
            $jamaahs = Auth::user()->jamaahs;
            $result = [];
            $jamaahs->load('user','pendaftar');
            foreach($jamaahs as $jamaah)
            {
                unset($jamaah->user_id);
                unset($jamaah->pendaftar_id);
                array_push($result,$jamaah);
            }
            return $this->success(@count($result).' data berhasil ditampilkan',$result);
        }
        else{
            return $this->failure('Data pengguna gagal ditampilkan, silahkan melakukan login terlebih dahulu');
        }
    }

    public function detail(Request $request)
    {
        $rules = [
            'jamaah_id'              => 'required|integer'
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $jamaah = Jamaah::find($request->jamaah_id);
        if($jamaah){
            $jamaah->load('user','pendaftar');
            unset($jamaah->user_id);
            unset($jamaah->pendaftar_id);
            return $this->success('data berhasil ditampilkan',$jamaah);
        }
        else{
            return $this->failure('data tidak ditemukan');
        }

    }

    public function create(Request $request)
    {
        $rules = [
            'nama'                  => 'required|string',
            'is_user'               => 'required|integer'
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $inputCreate = $request->except('_method','_token','is_user');
        $pendaftar_id = Auth::id();
        $user_id = null;

        if($request->is_user==1){
            $user_id = Auth::id();
        }
        $inputCreate['user_id']         = $user_id;
        $inputCreate['pendaftar_id']    = $pendaftar_id;
        try {
            $jamaah = Jamaah::create($inputCreate);
        } catch (\Throwable $th) {
            return $this->failure($th->getMessage());
        }
        $jamaah->load('user','pendaftar');
        unset($jamaah->user_id);
        unset($jamaah->pendaftar_id);
        return $this->success('Proses berhasil dilakukan',$jamaah);
    }

    public function update(Request $request)
    {
        $rules = [
            'jamaah_id'             => 'required|integer',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $pendaftar_id = Auth::id();
        $inputUpdate = $request->except('_method','_token','is_user','jamaah_id');
        $user_id = null;
        if(isset($request->is_user)){
            if($request->is_user==1){
                $user_id = Auth::id();
            }
        }
        $inputUpdate['pendaftar_id']    = $pendaftar_id;
        $inputUpdate['user_id']         = $user_id;
        try {
            $jamaah = Jamaah::find($request->jamaah_id);
            $jamaah->update($inputUpdate);
        } catch (\Throwable $th) {
            return $this->failure($th->getMessage());
        }
        $jamaah->load('user','pendaftar');
        unset($jamaah->user_id);
        unset($jamaah->pendaftar_id);
        return $this->success('Proses berhasil dilakukan',$jamaah);
    }

    public function upsert(Request $request)
    {
        $rules = [
            // 'jamaah_id'             => 'required|integer',
            'nama'                  => 'required|string',
            
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }


        try {
            $inputUpsert = $request->except(['_method','_token']);
            $jamaah = Jamaah::where('user_id',Auth::id())->first();
            if(!$jamaah){
                $jamaah = Jamaah::create([
                    'pendaftar_id' => Auth::id(),
                    'user_id'      => Auth::id(),
                ]);
            }
            $jamaah->update($inputUpsert);
        } catch (\Throwable $th) {
            return $this->failure($th->getMessage());
        }
        $jamaah     = Jamaah::where('user_id',Auth::id())->first();
        $jamaah->load('user','pendaftar');
        unset($jamaah->user_id);
        unset($jamaah->pendaftar_id);
        return $this->success('Proses berhasil dilakukan',$jamaah);
    }
}
