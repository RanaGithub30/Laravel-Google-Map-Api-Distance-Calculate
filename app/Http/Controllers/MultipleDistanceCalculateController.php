<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MultipleDistanceCalculateController extends Controller
{

    /*
        To calculate distance between one origin & multiple destinations..
    */

    public function calculate_multiple_distance()
    {

        // Google API key
        $apiKey = 'AIzaSyBjp1PUT6lnBxjXBj7yS0sQ_k99wFmeyHA';
            
        $addressFrom = "kolkata";
        $addressTo =["nagpur", "dhaka", "shimla"];

        // Change address format
        $formattedAddrFrom    = str_replace(' ', '+', $addressFrom);

        for($i = 0; $i<count($addressTo); $i++){
            $formattedAddrTo[]     = str_replace(' ', '+', $addressTo[$i]);
        }


        // Geocoding API request with start address
        $geocodeFrom = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false&key='.$apiKey);
        $outputFrom = json_decode($geocodeFrom);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }


        // Geocoding API request with end address

        for($j=0; $j<count($formattedAddrTo); $j++){
            $geocodeTo[] = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrTo[$j].'&sensor=false&key='.$apiKey);
            $outputTo[] = json_decode($geocodeTo[$j]);
            if(!empty($outputTo->error_message)){
                return $outputTo->error_message;
            }
        }


        // Get latitude and longitude from the geodata

        $latitudeFrom    = $outputFrom->results[0]->geometry->location->lat;
        $longitudeFrom    = $outputFrom->results[0]->geometry->location->lng;


        //// Get Latitude & Longitude of Other Places..

        for($k=0; $k<count($outputTo); $k++){
            $latitudeTo[]        = $outputTo[$k]->results[0]->geometry->location->lat;
            $longitudeTo[]    = $outputTo[$k]->results[0]->geometry->location->lng;
        }


        //// Calculate distance between starting place to others places..

        for($l=0; $l<count($outputTo); $l++){
            $theta[]    = $longitudeFrom - $longitudeTo[$l];
            $dist[]    = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo[$l])) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo[$l])) * cos(deg2rad($theta[$l]));
            $dist_1[]    = acos($dist[$l]);
            $dist_2[]    = rad2deg($dist_1[$l]);
            $miles[]    = $dist_2[$l] * 60 * 1.1515;
            $km[] = round($miles[$l] * 1.609344, 2);
        }


       // display the distance of locations..

       for($m=0; $m<count($km); $m++){
             $datas[] = "Distance between ".$addressFrom." to ".$addressTo[$m]." is ".$km[$m]." KM ";
       }

       return view("distance_show", compact('datas'));
        
       
    }
}