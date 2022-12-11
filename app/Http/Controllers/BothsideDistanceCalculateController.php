<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BothsideDistanceCalculateController extends Controller
{
    /*
        To calculate distance between multiple origins & multiple destinations..
    */

    public function multiple_distance()
    {
        // Google API key
        $apiKey = 'AIzaSyBjp1PUT6lnBxjXBj7yS0sQ_k99wFmeyHA';
            
        $addressFrom = ["kolkata", "delhi", "agra"];
        $addressTo =["nagpur", "dhaka", "shimla"];

        // Change address format
        for($i1 = 0; $i1<count($addressTo); $i1++){
        $formattedAddrFrom[]    = str_replace(' ', '+', $addressFrom[$i1]);
        }

        for($i = 0; $i<count($addressTo); $i++){
            $formattedAddrTo[]     = str_replace(' ', '+', $addressTo[$i]);
        }


        // Geocoding API request with start address
        for($j1=0; $j1<count($formattedAddrTo); $j1++){
        $geocodeFrom[] = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddrFrom[$j1].'&sensor=false&key='.$apiKey);
        $outputFrom[] = json_decode($geocodeFrom[$j1]);
        if(!empty($outputFrom->error_message)){
            return $outputFrom->error_message;
        }
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

        for($k1=0; $k1<count($outputTo); $k1++){
        $latitudeFrom[]    = $outputFrom[$k1]->results[0]->geometry->location->lat;
        $longitudeFrom[]    = $outputFrom[$k1]->results[0]->geometry->location->lng;
        }

        //// Get Latitude & Longitude of Other Places..

        for($k=0; $k<count($outputTo); $k++){
            $latitudeTo[]        = $outputTo[$k]->results[0]->geometry->location->lat;
            $longitudeTo[]    = $outputTo[$k]->results[0]->geometry->location->lng;
        }

        //// Calculate distance between starting place to others places..

        $km[] = array();

        for($l=0; $l<count($latitudeFrom); $l++){
            for($l1=0; $l1<count($latitudeTo); $l1++){
                $theta    = $longitudeFrom[$l] - $longitudeTo[$l1];
                $dist    = sin(deg2rad($latitudeFrom[$l])) * sin(deg2rad($latitudeTo[$l1])) +  cos(deg2rad($latitudeFrom[$l])) * cos(deg2rad($latitudeTo[$l1])) * cos(deg2rad($theta));
                $dist_1    = acos($dist);
                $dist_2    = rad2deg($dist_1);
                $miles[]    = $dist_2 * 60 * 1.1515;
                $km[] = round($miles[$l] * 1.609344, 2);
          }
        }

        dd($km);
    }
}