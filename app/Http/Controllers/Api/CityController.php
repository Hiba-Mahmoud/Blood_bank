<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;

class CityController extends Controller
{




  public function show($id)
  {
    $governorate = Governorate::find($id);
    $cities = $governorate->cities;


  }
}
