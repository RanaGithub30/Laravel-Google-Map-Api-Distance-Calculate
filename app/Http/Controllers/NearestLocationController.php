<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NearestLocationController extends Controller
{
    //

    public function nearest_location(Request $request)
    {
        $lat = 22.5867;
        $lon = 88.4906;
            
        $datas = DB::table("user_locations")
            ->select("user_locations.user_id"
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(user_locations.latitude)) 
                * cos(radians(user_locations.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(user_locations.latitude))) AS distance"))
                ->having('distance', '<', 10) // 10 in km..& 6371 - Radius of Earth
                ->get();

        foreach($datas as $data){
              $user_ids[] = $data->user_id;
        }

        $user_details = DB::table('users')->whereIn('id', $user_ids)->get();

        return view('nearest_location', compact('user_details'));
        
    }
}