<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function postList(){
        $posts = Post::orderBy('created_at','desc')->withCount(['comments','zans'])->paginate(6);

        return view('postList',compact('posts'));
    }

    public function postAdd(){
        return view('postAdd');
    }

    public function postDetail($id){
        $post = Post::with('user','comments')->find($id);

        return view('postDetail',compact('post'));
    }

    public function postEdit($id){
        $post = Post::find($id);

        return view('postEdit',compact('post'));
    }

    public function login(){
        return view('login');
    }

    public function register(){
        return view('register');
    }

    public function userSetting(){
        return view('userSetting');
    }
}
