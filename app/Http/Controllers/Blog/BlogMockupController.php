<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class BlogMockupController extends Controller
{
    public function index(Request $request){
        $arrReturn= [
            'navbar' => 'index',
        ];
        return view('blog_mockup.index',$arrReturn);
    }
    public function blog(Request $request){
        $arrReturn= [
            'navbar' => 'blog',
        ];
        return view('blog_mockup.blog',$arrReturn);
    }
    public function post(Request $request){
        $arrReturn= [
            'navbar' => 'post',
        ];
        return view('blog_mockup.post',$arrReturn);
    }
}
