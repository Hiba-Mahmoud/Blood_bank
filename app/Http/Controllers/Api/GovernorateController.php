<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;

class GovernorateController extends Controller
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

}


