<?php

namespace App\Http\Controllers\Dashboard\Artikel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Inspirasi;

class ArtikelController extends Controller
{
    protected $sidebar;
    protected $route;
    protected $view;

    public function __construct()
    {
        $this->sidebar  = 'artikel';
        $this->route    = 'dashboard.artikel.';
        $this->view     = 'dashboard.artikel.';
    }

    public function index()
    {
        $datas = Inspirasi::query();

        $datas = $datas->get();
        $arrReturn  = [
            'datas'      => $datas,
        ];
        return view($this->view.'index',$arrReturn)->with('sidebar',$this->sidebar);
    }

    public function create()
    {
        $arrReturn=[];
        return view($this->view.'create',$arrReturn)->with('sidebar',$this->sidebar);
    }

    public function store(Request $request)
    {
        $arrCreate = $request->all();
        $arrCreate['artikel'] = $this->replaceNewLines($arrCreate['artikel']);
        $arrCreate['is_active'] = 1;
        // dd($input);
        $model = Inspirasi::create($arrCreate);
        return redirect()->route($this->route.'index');
    }

    public function edit($id,Request $request)
    {
        $arrReturn['data'] = Artikel::find($id);
        return view($this->view.'edit',$arrReturn)->with('sidebar',$this->sidebar);
    }

    public function update($id,Request $request)
    {
        $arrUpdate = $request->all();
        $arrUpdate['artikel'] = $this->replaceNewLines($arrUpdate['artikel']);
        $arrUpdate['is_active'] = 1;
        
        $model = Artikel::find($id);
        $model->update($arrUpdate);
        return redirect()->route($this->route.'index');
    }

    private function replaceNewLines($content)
    {
        $newContent = preg_replace("/\r\n|\r|\n/", '<br/>', $content);
        return $newContent;
    }
}
