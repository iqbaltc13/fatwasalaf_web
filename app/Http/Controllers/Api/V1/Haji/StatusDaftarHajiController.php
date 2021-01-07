<?php

namespace App\Http\Controllers\Api\V1\Haji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusDaftarHaji;
use App\Models\DaftarHaji;
use App\Models\DaftarHajiLog;
use App\User;
use Auth;

class StatusDaftarHajiController extends Controller
{
    public function all(Request $request){
    	$datas = StatusDaftarHaji::all();
        return $this->success(@count($datas)." data berhasil ditampilkan",$datas);
    }

    public function logs(Request $request){
        $rules = [
            'daftar_haji_id'    => 'required|integer|exists:daftar_hajis,id',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $daftar_haji        = DaftarHaji::find($request->daftar_haji_id);
        $datas              = DaftarHajiLog::where('daftar_haji_id',$daftar_haji->id)->get();
        $datas->load(['status_daftar_haji_before','status_daftar_haji_after']);
        return $this->success(@count($datas)." data berhasil ditampilkan",$datas);
    }

    public function availables(Request $request){
    	$rules = [
            'daftar_haji_id'	=> 'required|integer|exists:daftar_hajis,id',
            'role'           	=> 'required|string|in:admin,kbih',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
    	
    	$daftar_haji 			= DaftarHaji::find($request->daftar_haji_id);
    	$status_daftar_haji 	= StatusDaftarHaji::find($daftar_haji->status_daftar_haji_id);
    	if (!$status_daftar_haji) {
    		return $this->failure('status daftar haji kosong');
    	}
    	$datas 					= StatusDaftarHaji::select('id','name','display_name','note')->get();
    	$availables 			= array();
    	$options 				= $this->statusOptions($status_daftar_haji->name, $request->role);
		
		foreach ($datas as $value) {
			if(in_array($value->name, $options)){
				$value->is_available 		= 1;
				array_push($availables, $value);
			}else{
				$value->is_available 		= 0;
			}
		}
		if($request->available_only){
			return $this->success(@count($availables)." data berhasil ditampilkan",$availables);
		}else{
			return $this->success(@count($datas)." data berhasil ditampilkan",$datas);
		}
    }

    function statusOptions($name,$role){
    	$options 				= array();
    	if($role == 'admin'){
			if($name == 'pendaftaran_diterima'){
				$options 		= array('data_jamaah_perlu_direvisi','pendaftaran_disetujui_admin','gagal ditolak_admin');
			}else if($name == 'data_jamaah_perlu_direvisi'){
				$options 		= array('pendaftaran_disetujui_admin','gagal ditolak_admin');
			}else if($name == 'setoran_lunas'){
				$options 		= array('proses_pelunasan_total','selesai');
			}else {
				$options 		= array('gagal dibatalkan_customer','selesai');
			}
		}else if($role == 'kbih'){
			if($name == 'biaya_administrasi_terbayar'){
				$options 		= array('diproses_kbih');
			}else if($name == 'diproses_kbih'){
				$options 		= array('nomor_porsi_didapat');
			}
		}
        if(!in_array($name, $options)){
            array_push($options, $name);
        }
		return $options;
    }

    public function update(Request $request){
    	$rules = [
            'daftar_haji_id'				=> 'required|integer|exists:daftar_hajis,id',
            'role'           				=> 'required|string|in:admin,kbih',
            'new_status_daftar_haji_id' 	=> 'required|integer|exists:status_daftar_hajis,id',
            'catatan'                       => 'required|string'
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
    	
    	$daftar_haji 			= DaftarHaji::find($request->daftar_haji_id);
    	$old_status 			= StatusDaftarHaji::find($daftar_haji->status_daftar_haji_id);
    	$new_status 			= StatusDaftarHaji::find($request->new_status_daftar_haji_id);
        $updater                = User::find(Auth::id());
        if(!$updater){
            return $this->failure('updater not found');
        }
    	if (!$new_status) {
    		return $this->failure('status daftar haji kosong');
    	}
    	$options 				= $this->statusOptions($old_status->name, $request->role);
    	if(!in_array($new_status->name, $options)){
    		return $this->failure($request->role.' tidak dapat mengubah status pendaftaran dari ('.$old_status->display_name.') menjadi ('.$new_status->display_name.')');
    	}
    	$daftar_haji->status_daftar_haji_id 	        = $new_status->id;
    	$daftar_haji->save();

        $daftar_haji_log                                = new DaftarHajiLog();
        $daftar_haji_log->daftar_haji_id                = $daftar_haji->id;
        $daftar_haji_log->updated_by_id                 = $updater->id;
        $daftar_haji_log->updated_by_name               = '['.$request->role.'] '.$updater->name;
        $daftar_haji_log->status_daftar_haji_id_before  = $old_status->id;
        $daftar_haji_log->status_daftar_haji_id_after   = $new_status->id;
        $daftar_haji_log->catatan                       = $request->catatan;
        $daftar_haji_log->save();
    	return $this->success('Berhasil');
    }
}
