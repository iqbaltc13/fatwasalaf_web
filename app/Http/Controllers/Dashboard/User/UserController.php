<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Helpers\WebHelperController;
use DataTables;
use DateTime;
use stdClass;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use App\Role;
use App\Models\RoleUser;
use DB;
use App\Models\UserXRole;

class UserController extends Controller {
    
    public function __construct()
    {
        $this->route      ='dashboard.user.';
        $this->view       ='dashboard.user.';
        $this->web_helper =new WebHelperController();
        $this->sidebar    ='pengaturan'; 
    }
    public function index(Request $request){
        return view($this->view.'index')->with('sidebar', $this->sidebar);
    }

    public function data(Request $request){
        $user                   = User::all(); 
        $errors                 =[];
        $return                 = new stdClass;
        $return->response_code  = 200;
        $return->errors         = $errors;
        $return->data           = $user;
        return response()->json($return);

    }
    public function edit($id){
        $user       = User::query()
        ->where('id',$id)->first();
        $role = Role::query()->get();
        if(is_null($user)){
            return $this->web_helper->error404();
        }
        $myRole = DB::table('role_user')->where('user_id',$id)->get();
        $arrReturn=[
            'data' => $user,
            'role' => $role,
            'myRole'=>$myRole,
        ];
        return view($this->view.'edit',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function update(Request $request,$id){
       
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            
            'phone' => 'required|string|max:255|unique:users,phone,'.$id,
            
           
        ]);
        if(!isset($request->role)){
            return redirect()->back()
            ->withErrors('role', 'role harus diisi');
        }
        DB::table('role_user')->where('user_id',$id)->delete();
        $arrSetRole = $request->role;
        foreach ($arrSetRole as $key => $value) {
            UserXRole::create([
                'role_id' => $value,
                'user_id' => $id,
                'user_type' =>  'App\User',
            ]);
        } 
        $updateteUser=[
            'name'                  =>$request->name,
           
            'email'                 =>$request->email,
           
           
            'phone'                 =>$request->phone,
           
       
        ];
       
        $create = User::where('id',$id)->update($updateteUser);
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit user');
    }
    public function create(Request $request){
        $role = Role::query()->get();
 
        $arrReturn=[
            'role' => $role,
        ];
        return view($this->view.'create',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
           
            'phone' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if(!isset($request->role)){
            return redirect()->back()
            ->withErrors('role', 'role harus diisi');
        }
        
        $arrSetRole = $request->role;
        
        $createUser=[
            'name'                  =>$request->name,
           
            'email'                 =>$request->email,
            'password'              =>$request->password,
            
            'phone'                 =>$request->phone,
            
       
        ];
        $create = User::create($createUser);
        $idUser = $create->id;
        foreach ($arrSetRole as $key => $value) {
            UserXRole::create([
                'role_id' => $value,
                'user_id' => $idUser,
                'user_type' =>  'App\User',
            ]);
        } 
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menambah user');
    }
    public function destroy(Request $request,$id){
        $deleteInstansi=User::where('id',$id)->delete();
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses menghapus user');
    }
    public function destroyJson(Request $request){
        $id                     = $request->id;
        $deleteInstansi         = User::where('id',$id)->delete();
        $errors                 = [];
        $data                   = new stdClass;
        $data->result           = $deleteInstansi;
        $data->id               = $id;
        $return                 = new stdClass;
        $return->response_code  = 200;
        $return->errors         = $errors;
        $return->data           = $data;
        return response()->json($return);
    }
    public function detail(Request $request,$id){
        $data           = User::find($id);
        $arrReturn      =[
            'data'=>$data,
        ];
        return view($this->view.'detail',$arrReturn)->with('sidebar', $this->sidebar);

    }

    public function detailJson(Request $request,$id){
        $data       = User::find($id);
        $errors     = [];
        $return     = new stdClass;
        if($data){
            $return->response_code  = 200;
            $return->errors         = $errors;
            $return->data           = $data;
            return response()->json($return);
        }
        else{
            $return->response_code  = 500;
            $errors['message']      = 'Data Not Found';
            $return->errors         = $errors;
            $return->data           = $data;
            return response()->json($return);
        }
        
    }
}
