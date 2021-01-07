<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaraMenabung;


class CaraMenabungController extends Controller{
    public function all(Request $request){
        $results = CaraMenabung::select('nomor','judul')->orderBy('nomor')->get();
        return $this->success(@count($results).' data berhasil ditampilkan',$results);
    }
}
