<?php

namespace App\Http\Controllers\Dashboard\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kbih;

class KbihController extends Controller
{
    protected $sidebar;
    protected $route;
    protected $view;

    public function __construct()
    {
        $this->sidebar  = 'master';
        $this->route    = 'dashboard.master.kbih.';
        $this->view     = 'dashboard.master.kbih.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datas = Kbih::query();

        $datas = $datas->get();
        $arrReturn  = [
            'datas'      => $datas,
        ];
        return view($this->view.'index',$arrReturn)->with('sidebar',$this->sidebar);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $provinces = \App\Models\Provinsi::all();
        $cities = [];
        foreach($provinces as $province){
            $cityGroupModel = \App\Models\Kota::where('provinsi_id',$province->id)->get()->pluck('nama','id');
            $cityGroup = [
                'nama'      => $province->nama,
                'cities'    => $cityGroupModel,
            ];

            array_push($cities,$cityGroup);
        }
        
        $arrReturn = [
            'kota'=>$cities,
        ];
        return view($this->view.'create',$arrReturn)->with('sidebar',$this->sidebar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'name'                     =>'required',
            'status_aktif'             =>'required',
        ]);
        
        $input = $request->except('_method','_token');
        $arrCreate = $input;
        Kbih::create($arrCreate);
        return redirect()->route($this->route.'index')->with('success','Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Kbih::find($id);
        $provinces = \App\Models\Provinsi::all();
        $cities = [];
        foreach($provinces as $province){
            $cityGroupModel = \App\Models\Kota::where('provinsi_id',$province->id)->get()->pluck('nama','id');
            $cityGroup = [
                'nama'      => $province->nama,
                'cities'    => $cityGroupModel,
            ];

            array_push($cities,$cityGroup);
        }
        $arrReturn  = [
            'data'      => $data,
            'kota'      => $cities,
        ];
        return view($this->view.'edit',$arrReturn)->with('sidebar',$this->sidebar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name'                     =>'required',
            'status_aktif'             =>'required',
        ]);
        $input = $request->except('_method','_token');
        $updateData = Kbih::find($id);
        $arrUpdate = $input;
        $updateData->update($arrUpdate);
        return redirect()->route($this->route.'index')->with('success','Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $deleteData = Kbih::find($id);
        $deleteData->delete();
        return redirect()->route($this->route.'index')->with('success','Data berhasil dihapus');
    }
}
