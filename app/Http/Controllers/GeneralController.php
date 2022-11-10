<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Post;
use App\Models\Client;
// use App\Models\ClientPost;
use App\Models\Setting;
use App\Models\Category;
use App\Models\BloodType;
use App\Models\ClientPost;
use App\Models\Contact;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Models\Donation_request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GeneralController extends Controller
{

  private function apiResponse($status,$msg,$data)
  {

    $response = [
        'status'=> $status,
        'message'=> $msg,
        'data'=> $data,

    ];

    return response()->json($response);

  }





  public function show()
  {
    $governorares = Governorate::all();
    return $this->apiResponse(1,'success',$governorares);
}


//cities

public function showCities(Request $request)
{
    $cities = City::where(function($query)use($request){
        if($request->has('governorate_id')){
            $query->where('governorate_id',$request->governorate_id);
        }

    })->get();
//   $governorate = Governorate::find($id);
//   $cities = $governorate->cities;
  return $this->apiResponse(1,'success',$cities);
}




//setting
public function setting(){
    $sitting = Setting::first();
    return $this->apiResponse(1,'success',$sitting);

}

//blood_typed
public function bloodTypes()
{
    $bloodTypes = BloodType::all();
  return $this->apiResponse(1,'success',$bloodTypes);


}

//categories

public function categories()
{
    $categories = Category::all();
  return $this->apiResponse(1,'success',$categories);
}

//categories

public function contactUs()
{
    $contact = Contact::all();
  return $this->apiResponse(1,'success',$contact);
}

//posts
public function posts(Request $request){
    // $posts=Post::all()->paginate(15);
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

  return $this->apiResponse(1,'success',$posts);
}

//search
public function search(Request $request){
  $posts = Post::where(function($query)use($request){
    if($request->has('search')){
      // $search = $request->search;
        $query->where('title','like',"%{$request->search}%");
    }

})->get();
return $this->apiResponse(1,'success',$posts);

}

//favourites
public function favourites(){
    $favourites = auth()->user()->Posts()->latest()->paginate(10);
    return $this->apiResponse(1,'success',$favourites);

}


public function toggleFavourite(Request $request )
    {
        auth()->user()->posts()->toggle([$request->post_id]);
        return $this->apiResponse(1,'success','success');
    }


//donation cycle
public function donationRequest(Request $request)
{
    $validator = Validator::make(
        $request->all(),
        [
            'patient_name' => 'required|string|max:50|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'patient_phone' => 'required',
            'patient_age' => 'required',
            'city_id' => 'required|numeric',
            'hospital_name' => 'required',
            'hospital_address'=>'required',
            'bags_num' => 'required',
            'details' => 'required',
            'blood_type_id' => 'required|numeric',
            'api_token'=>'required',
            'longitude'=>'required',
            'latitude'=>'required'

        ],

    );

    if ($validator->fails()) {
        $errors = $validator->errors();
        return $this->apiResponse(0, 'error', $errors);
        // return $errors;
    };

    $donationReuest=auth()->user()->DonationRequests()->create($request->all());
    $clientsIds = $donationReuest->cities->governorate->clients()->wherehas('BloodType',function($query)use($request){
        $query->where('blood_types.id',$request->blood_type_id);
    })->pluck('clients.id')->toArray;
    dd($clientsIds);
    return $this->apiResponse(1, 'success', $donationReuest);

    // dd($request);
    // $donationReuest = Donation_request::create([
    //     'name' => $request->name,
    //     'email' => $request->email,
    //     'phone' =>$request->phone,
    //     'gender' =>$request->gender,
    //     'city_id' =>$request->city_id,
    //     'date_of_birth'=>$request->date_of_birth,
    //     'last_donation_date'=>$request->last_donation_date,
    //     'blood_type_id'=>$request->blood_type_id,
    //     'api_token' =>,
    // ]);
}


//notification
public function notification(){

}


}
