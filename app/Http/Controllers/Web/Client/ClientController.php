<?php

namespace App\Http\Controllers\Web\Client;

use App\Models\Post;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{

//contact

// public function contactUs()
// {
//     $contact = Contact::all();
//   return $this->apiResponse(1,'success',$contact);
// }

//posts
public function posts(Request $request){
    // $posts=Post::all()->paginate(15);
    // $posts = Post::where(function($query)use($request){
    //     if($request->has('category_id')){
    //         $query->where('category_id',$request->category_id);
    //     }

    //     if($request->has('search')){
    //         $search = $request->search;
    //         // dd($query->where('title','like',"%{$request->search}%"));
    //           $query->where('title','LIKE',"%{$search}%");
    //     }

    // })->get();
    $posts = Post::paginate(15);

    return view('site.home',['posts'=>$posts]);

//   return $this->apiResponse(1,'success',$posts);
}
}
