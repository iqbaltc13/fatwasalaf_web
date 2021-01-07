<?php

namespace App\Http\Controllers\Dashboard\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jamaah;
use DataTables;


class JamaahController extends Controller
{
    protected $sidebar;
    protected $route;
    protected $view;

    public function __construct()
    {
        $this->sidebar  = 'master';
        $this->route    = 'dashboard.master.jamaah.';
        $this->view     = 'dashboard.master.jamaah.';
    }

    public function index()
    {
        $sidebar = $this->sidebar;

        return view($this->view.'index')->with('sidebar',$sidebar);
    }

    public function datatable(Request $request)
    {
        $datas = Jamaah::with('user','pendaftar');
        if(isset($request->jenis_kelamin)){
            $datas = $datas->where('jenis_kelamin',$request->jenis_kelamin);
        }
        $datas = $datas->get();
        return Datatables::of($datas)->toJson();
    }

    public function create()
    {
        
    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
    //get jamaah yang didaftarkan
    
}
