<?php

namespace App\Http\Controllers\Api\V1\Profile\Util;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Hash;
use Auth;
use Mail;
use Illuminate\Support\Str;
use DB;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UtilController extends Controller{
    public function pull(Request $request){
        exec('/var/www/pull.sh');
        return $this->success('Berhasil');
    }

    public function info(Request $request){
        return $this->success('Hai');
    }

}
