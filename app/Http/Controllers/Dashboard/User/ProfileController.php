<?php

namespace App\Http\Controllers\Dashboard\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->route      ='dashboard.profil.';
        $this->view       ='dashboard.profile.';
        $this->sidebar    ='pengaturan';
         
    }
    public function index(Request $request){
        $data=Auth::user();
        $arrReturn=[
            'data'=>$data,
        ];
        return view($this->view.'index',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function edit(Request $request){
        $data=Auth::user();
        $arrReturn=[
            'data'=>$data,
        ];
        return view($this->view.'edit',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function update(Request $request)
    {
        $id= Auth::id();
        $this->validate($request, [
            'name' => 'required|string|max:255',
            //'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            //'username' => 'required|string|max:255|unique:users,username,'.$id,
            'phone_number' => 'required|string|max:255|unique:users,phone_number,'.$id,
            
        ]);
        
        $updateteUser=[
            'name'                  =>$request->name,
            // 'username'              =>$request->username,
            // 'email'                 =>$request->email,
            //'password'              =>$request->password,
            'address'               =>$request->address,
            'date_of_birth'         =>$request->date_of_birth,
            'self_description'      =>$request->self_description,
            'phone_number'          =>$request->phone_number,
            'office_name'           =>$request->office_name,
       
        ];
        
        $create = User::where('id',$id)->update($updateteUser);
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengedit profil');
    }

    public function changePassword(Request $request){
        $data=Auth::user();
        $arrReturn=[
            'data'=>$data,
        ];
        return view($this->view.'change_password',$arrReturn)->with('sidebar', $this->sidebar);
    }
    public function updatePassword(Request $request){
        $id= Auth::id();
        $this->validate($request, [
            'old_password' => 'required|string',
            'password'     => 'required|string|min:8|confirmed',
           
        ]);
        if(Hash::check($request->old_password,Auth::user()->password)){
            $updateteUser=[
            
                'password'              => bcrypt($request->password),
                
           
            ];
            
            $create = User::where('id',$id)->update($updateteUser);
        }
        
        return redirect()->route($this->route.'index')
        ->with('success', 'Sukses mengubah password');
        
    }
}
