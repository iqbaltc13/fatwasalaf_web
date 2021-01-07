<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use App\Models\File;
use App\Models\Fext;
use App\Models\Ftype;
use App\Models\FextFtype;
use Auth;
use DateTime;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Intervention\Image\ImageManager;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Exception\NotReadableException;

class UploadFileController extends Controller
{
    public function uploadFile($request,$attribute,$folder){
        if ($request->file($attribute)) {
	    	$uuid 					= Uuid::uuid4()->toString();
	    	$file 					= $request->file($attribute);
            $ext 					= $request->{$attribute}->extension();
            $fext                   = Fext::where('name',$ext)->first();
            $ftype                  = $fext->ftypes;
            if(!$ftype){
                return NULL;
            }
			try {
                if(($ftype->name == 'image')||$ftype->name == 'images'){
                    $gambar = $this->saveImage($uuid,$file,$ext,$request,$ftype,$attribute,$folder);
                }
                else{
                    $gambar = $this->saveFile($uuid,$file,$ext,$request,$ftype,$attribute,$folder);
                }
            } catch (\Throwable $th) {
                
                return NULL;
            }

		    return $gambar;
		}
        else
            return NULL;
			
    }
    public function uploadFileArray($request,$attribute,$folder){
        if ($request->file($attribute)) {
            $files                  = $request->file($attribute);
            $arrIdUploadFile        = [];
            foreach($files as $file){
                $uuid 					= Uuid::uuid4()->toString();
               
                $ext 					= $file->extension();
                $fext                   = Fext::where('name',$ext)->first();
                $ftype                  = $fext->ftypes;
                if(!$ftype){
                    array_push($arrIdUploadFile,0);
                }
                try {
                    if(($ftype->name == 'image')||$ftype->name == 'images'){
                        $gambar = $this->saveImageNewWithoutRequestAndAttribute($uuid,$file,$ext,$ftype,$folder);
                    }
                    else{
                        $gambar = $this->saveFileNewWithoutRequestAndAttribute($uuid,$file,$ext,$ftype,$folder);
                    }
                } catch (\Throwable $th) {
                    
                    array_push($arrIdUploadFile,0);
                }

                    array_push($arrIdUploadFile,$gambar->id);
            }
            return $arrIdUploadFile;
	    	
		}
        else
            return NULL;
			
    }

    public function saveImageNewWithoutRequestAndAttribute($uuid,$file,$ext,$ftype,$folder){
        $imageManager 			= new ImageManager(array('driver' => 'imagick'));
        $thumb 					= Image::make($file->getRealPath())->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio(); 
        });
        $name   				= $uuid.'.'.$ext;
        $path   				= '/uploads/'.$folder.'/';
        $size                   = $file->getSize();
        $file->move(public_path($path), $name);
        $thumb->save(public_path($path).'thumb_'.$name);
        $gambar = File::create([
                'id' 				   => $uuid,
                'folder' 			   => $folder,
                'path' 				   => $path.$name,
                'path_thumbnail'	   => $path.'thumb_'.$name,
                'ftype_id'             => $ftype->id,
                'user_id'              => Auth::user()->id,
                'ext'				   => $ext,
                'full_path' 		   => asset($path.$name),
                'full_path_thumbnail'  => asset($path.'thumb_'.$name),
                'size_in_bytes'        => $size,
            ]);
        
        return $gambar;
    }

    public function saveFileNewWithoutRequestAndAttribute($uuid,$file,$ext,$ftype,$folder){
        $name   				= $uuid.'.'.$ext;
        $path   				= '/uploads/'.$folder.'/';
        $size                   = $file->getSize();
        $file->move(public_path($path), $name);
        $upload = File::create([
                'id' 				   => $uuid,
                'folder' 			   => $folder,
                'path' 				   => $path.$name,
                'path_thumbnail' 	   => $path.$name,
                // 'path_thumbnail'	   => $path.'thumb_'.$name,
                'ext'				   => $ext,
                'user_id'              => Auth::user()->id,
                'ftype_id'             => $ftype->id,
                'full_path' 		   => asset($path.$name),
                'full_path_thumbnail'  => asset($path.$name),
                'size_in_bytes'        => $size,
                // 'full_path_thumbnail'  => asset($path.'thumb_'.$name),
            ]);

        return $upload;
    }
    
    public function saveImage($uuid,$file,$ext,$request,$ftype,$attribute,$folder)
    {
        $imageManager 			= new ImageManager(array('driver' => 'imagick'));
        $thumb 					= Image::make($file->getRealPath())->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio(); //maintain image ratio
        });
        $name   				= $uuid.'.'.$ext;
        $path   				= '/uploads/'.$folder.'/';
        $size                   = $request->file($attribute)->getSize();
        $file->move(public_path($path), $name);
        $thumb->save(public_path($path).'thumb_'.$name);
        $gambar = File::create([
                'id' 				   => $uuid,
                'folder' 			   => $folder,
                'path' 				   => $path.$name,
                'path_thumbnail'	   => $path.'thumb_'.$name,
                'ftype_id'             => $ftype->id,
                'user_id'              => Auth::user()->id,
                'ext'				   => $ext,
                'full_path' 		   => asset($path.$name),
                'full_path_thumbnail'  => asset($path.'thumb_'.$name),
                'size_in_bytes'        => $size,
            ]);
        
        return $gambar;
    }

    public function saveFile($uuid,$file,$ext,$request,$ftype,$attribute,$folder)
    {
        // $imageManager 			= new ImageManager(array('driver' => 'imagick'));
        // $thumb 					= Image::make($file->getRealPath())->resize(200, 200, function ($constraint) {
        //     $constraint->aspectRatio(); //maintain image ratio
        // });
        $name   				= $uuid.'.'.$ext;
        $path   				= '/uploads/'.$folder.'/';
        $size                   = $request->file($attribute)->getSize();
        $file->move(public_path($path), $name);
        $upload = File::create([
                'id' 				   => $uuid,
                'folder' 			   => $folder,
                'path' 				   => $path.$name,
                'path_thumbnail' 				   => $path.$name,
                // 'path_thumbnail'	   => $path.'thumb_'.$name,
                'ext'				   => $ext,
                'user_id'              => Auth::user()->id,
                'ftype_id'             => $ftype->id,
                'full_path' 		   => asset($path.$name),
                'full_path_thumbnail' 		   => asset($path.$name),
                'size_in_bytes'        => $size,
                // 'full_path_thumbnail'  => asset($path.'thumb_'.$name),
            ]);

        return $upload;
    }
}
