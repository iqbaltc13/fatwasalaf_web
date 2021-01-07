<?php

namespace App\Http\Controllers\Dashboard\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nasabah;
use App\Models\Pembayaran;
use App\Models\TabunganHaji;
use App\Models\TabunganUmrah;
use Carbon\Carbon;
use Auth;
use DB;
use App\Models\DumaCash;
use App\User;

class PembayaranController extends Controller
{
    //
    protected $sidebar;
    protected $route;
    protected $view;

    public function __construct()
    {
        $this->sidebar  = 'pembayaran';
        $this->route    = 'dashboard.master.pembayaran.';
        $this->view     = 'dashboard.master.pembayaran.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datas = Pembayaran::query();

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
        
        $arrReturn = [
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
            'nomor_va'                     =>'required',
            'nominal'                      =>'required',
            'remarks'                      =>'required',
        ]);
        
        $input = $request->except('_method','_token');

        $nasabah = Nasabah::where('nomor_va',$input['nomor_va'])->first();
        if(!$nasabah){
            return redirect()->route($this->route.'index')->with('error','Nasabah tidak ditemukan');
        }

        if($nasabah->jenis_layanan_id == 1){
            $tabungan = TabunganHaji::where('nasabah_id',$nasabah->id)->first();
        }
        else if($nasabah->jenis_layanan_id == 2){
            $tabungan = TabunganUmrah::where('nasabah_id',$nasabah->id)->first();
        }

        if(!$tabungan){
            return redirect()->route($this->route.'index')->with('error','Tabungan tidak ditemukan');
        }

        $pembayaran_type                    = get_class($tabungan);
        DB::beginTransaction();
        $user                               = User::find(Auth::id());
        $duma_cash                          = new DumaCash();
        $duma_cash->in                      = $request->nominal;
        $duma_cash->nasabah_id              = $nasabah->id;
        $duma_cash->description             = 'diinput oleh '.$user->name.', sebesar '.$request->nominal;
        $duma_cash->save();

        $new_data                           = new Pembayaran();
        $new_data->nasabah_id               = $nasabah->id;
        $new_data->jenis_pembayaran_id      = 2;
        $new_data->jenis_layanan_id         = $nasabah->jenis_layanan_id;
        $new_data->pembayaran_type          = $pembayaran_type;
        $new_data->pembayaran_id            = $tabungan->id;
        $new_data->nominal                  = $input['nominal'];
        $new_data->verified_at              = Carbon::now();
        $new_data->verified_by_id           = $user->id;
        $new_data->verified_by_name         = $user->name;
        $new_data->verified_result          = 'accepted';
        $new_data->catatan_verifikator      = $input['remarks'];
        $new_data->duma_cash_id             = $duma_cash->id;
        $new_data->save();
                
        DB::commit();
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

        $data = Pembayaran::find($id);
        $arrReturn  = [
            'data'      => $data,
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
            'nomor_va'                     =>'required',
            'nominal'                      =>'required',
            'remarks'                      =>'required',
        ]);
        
        $input = $request->except('_method','_token');

        $nasabah = Nasabah::where('nomor_va',$input['nomor_va'])->first();
        if(!$nasabah){
            return redirect()->route($this->route.'index')->with('error','Nasabah tidak ditemukan');
        }

        if($nasabah->jenis_layanan_id == 1){
            $tabungan = TabunganHaji::where('nasabah_id',$nasabah->id)->first();
        }
        else if($nasabah->jenis_layanan_id == 2){
            $tabungan = TabunganUmrah::where('nasabah_id',$nasabah->id)->first();
        }

        if(!$tabungan){
            return redirect()->route($this->route.'index')->with('error','Tabungan tidak ditemukan');
        }

        $tabunganType = get_class($tabungan);
        $arrUpdate = [
            'nasabah_id'            => $nasabah->id,
            'jenis_layanan_id'      => $nasabah->jenis_layanan_id,
            'jenis_pembayaran_id'   => 2,
            'pembayaran_type'       => $tabunganType,
            'pembayaran_id'         => $tabungan->id,
            'nominal'               => $input['nominal'],
            'verified_at'           => Carbon::now(),
            'verified_by_id'        => Auth::id(),
            'verified_by_name'      => Auth::user()->name,
            'verified_result'       => 'accept',
            'catatan_customer'      => null,
            'catatan_verifikator'   => $input['remarks'],
        ];
        $data = Pembayaran::find($id);
        $data->update($arrUpdate);
        return redirect()->route($this->route.'index')->with('success','Data berhasil ditambahkan');
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
