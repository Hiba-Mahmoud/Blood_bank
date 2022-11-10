<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showPosts(){
        $posts =Post::all();
        return view('site.home');


    }
}
