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
use App\Models\Faq;


class FaqController extends Controller{
    public function gets(Request $request){
        $results = Faq::all();
        return $this->success(@count($results).' data berhasil ditampilkan',$results);
    }
}
