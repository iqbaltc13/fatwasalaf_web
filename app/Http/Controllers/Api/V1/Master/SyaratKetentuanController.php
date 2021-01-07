<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kbih;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;
use App\Models\SyaratKetentuan;


class SyaratKetentuanController extends Controller{
    public function all(Request $request){
        $results = SyaratKetentuan::all();
        return $this->success(@count($results).' data berhasil ditampilkan',$results);
    }

    public function get(Request $request){
    	$rules = [
            'jenis'             => 'required|string|exists:syarat_ketentuans,jenis',
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $result = SyaratKetentuan::where('jenis',$request->jenis)->first();
        return $this->success('Berhasil',$result);
    }
}
