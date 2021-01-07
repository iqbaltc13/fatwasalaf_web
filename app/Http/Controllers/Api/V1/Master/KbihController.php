<?php

namespace App\Http\Controllers\Api\V1\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kbih;


use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Validator;
use Carbon\Carbon;
use Auth;
use DB;
use App\User;
use App\Notifications\FirebasePushNotif;
use App\Models\Role;
use App\Models\RoleUser;


class KbihController extends Controller
{
    //
    public function list(Request $request)
    {
        $rules = [
            // 'per_page'              => 'required|integer'
        ];
        $validator      =  $this->customValidation($request, $rules);
        if ($validator !== TRUE) {
            return $validator;
        }
        $result = Kbih::all();
        $result->load('kota');
        return $this->success(@count($result).' data berhasil ditampilkan',$result);
    }

}
