<?php

namespace App\Http\Controllers;

use App\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PropertyController extends Controller
{
    //if true will return a map with the properties location
    protected $setMap = true;

    public function getAllProperties() {

      $properties = DB::table('properties')->get();

      if($this->setMap != false)
          return view('map', ['properties' => $properties]);

      return response()->json($properties, 200);

    }

    public function getPropertiesByID(Request $request) {

      $properties = DB::table('properties')->where('user_id', $request->user_id)->get();

      if($this->setMap != false)
          return view('map', ['properties' => $properties]);

      return response()->json($properties, 200);

    }

    public function getPropertiesByRadius(Request $request) {

      $properties = DB::table('properties');
      $properties = Property::scopeDistance($properties, $request->latitude, $request->longitude, $request->radius, $request->unit);

      if($this->setMap != false)
          return view('map', ['properties' => $properties]);

      return response()->json($properties, 200);

    }

    public function updateProperty(Request $request) {

      $property = DB::table('properties')->where('id', $request->id)->where('user_id', Auth::guard('api')->id())->update([$request->field => $request->value]);

      if($property != true)
        return response()->json(array('error' => 'Wrong Request!'), 200);

      return response()->json(array('message' => 'Property updated successfully!'), 200);

    }
}
