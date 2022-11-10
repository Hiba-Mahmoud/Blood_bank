<?php

namespace App\Http\Controllers\Web\Client;

use App\Models\Post;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{



// public function categories()
// {
//     $categories = Category::all();
//   return $this->apiResponse(1,'success',$categories);
// }

//categories

public function contactUs()
{
    $contact = Contact::all();
  return $this->apiResponse(1,'success',$contact);
}

//posts
public function posts(Request $request){
    $posts = Post::where(function($query)use($request){
        if($request->has('category_id')){
            $query->where('category_id',$request->category_id);
        }

        if($request->has('search')){
            $search = $request->search;
            // dd($query->where('title','like',"%{$request->search}%"));
              $query->where('title','LIKE',"%{$search}%");
        }

    })->get()->paginate(15);
    return view('site.home',['posts'=>$posts]);
}

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {

  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {

  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {

  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {

  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {

  }

}

?>
