<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterPekerjaan;

class MasterPekerjaanController extends Controller
{
    //
    public function get()
    {
        $datas = MasterPekerjaan::select('id','nama','is_active')->get();
        return $this->success(@count($datas)." data berhasil ditampilkan",$datas);
    }
}
