<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;

class WebHelperController extends Controller
{
    
    public function __construct()
    {
        $this->view_error='errors.';
    }
    public function error404(Request $request, $arrParse=[]){
        return view($this->view_error.'404error',$arrParse);
    }
    public function error500(Request $request, $arrParse=[]){
        return view($this->view_error.'500error',$arrParse);
    }
    public function olahTanggalToBaku ($dateTime)
    {
        $objDateTime=new DateTime($dateTime);
        $waktu3= explode(" ",$objDateTime->format('Y-m-d H:i:s'));
            
        $waktu2= explode("-",$waktu3[0]);
        if($waktu2[1]=="1" ||$waktu2[1]=="01"){
            $bulan="Januari";
        }
        if($waktu2[1]=="2" ||$waktu2[1]=="02"){
            $bulan="Februari";
        }
        if($waktu2[1]=="3" ||$waktu2[1]=="03"){
            $bulan="Maret";
        }
        if($waktu2[1]=="4" ||$waktu2[1]=="04"){
            $bulan="April";
        }
        if($waktu2[1]=="5" ||$waktu2[1]=="05"){
            $bulan="Mei";
        }
        if($waktu2[1]=="6" ||$waktu2[1]=="06"){
            $bulan="Juni";
        }
        if($waktu2[1]=="7" ||$waktu2[1]=="07"){
            $bulan="Juli";
        }
        if($waktu2[1]=="8" ||$waktu2[1]=="08"){
            $bulan="Agustus";
        }
        if($waktu2[1]=="9" ||$waktu2[1]=="09"){
            $bulan="September";
        }
        if($waktu2[1]=="10" ){
            $bulan="Oktober";
        }
        if($waktu2[1]=="11" ){
            $bulan="Nopember";
        }
        if($waktu2[1]=="12" ){
            $bulan="Desember";
        }
         
        $tanggal=$waktu2[2]." ".$bulan." ".$waktu2[0].', '.$objDateTime->format('H.i'). ' WIB';
        return $tanggal;
    }
}
