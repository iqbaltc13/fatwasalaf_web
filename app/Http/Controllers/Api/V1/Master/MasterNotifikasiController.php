<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use App\Models\NotifikasiGroup;
use App\Models\NotifikasiAction;


class MasterNotifikasiController extends Controller{
    public function actions(Request $request){
        $results = NotifikasiAction::select('id','name','display_name','description')->get();
        return $this->success(@count($results).' data berhasil ditampilkan',$results);
    }

    public function groups(Request $request){
        $results = NotifikasiGroup::select('id','name','display_name','description')->get();
        return $this->success(@count($results).' data berhasil ditampilkan',$results);
    }
}
