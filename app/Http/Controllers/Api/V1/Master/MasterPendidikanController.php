<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPendidikan;

class MasterPendidikanController extends Controller
{
    //
    public function get()
    {
        $datas = MasterPendidikan::select('id','nama','is_active')->get();
        return $this->success(@count($datas)." data berhasil ditampilkan",$datas);
    }
}
