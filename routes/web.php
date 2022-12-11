<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DistanceCalculateController;
use App\Http\Controllers\MultipleDistanceCalculateController;
use App\Http\Controllers\BothsideDistanceCalculateController;
use App\Http\Controllers\NearestLocationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/////// (https://www.codexworld.com/distance-between-two-addresses-google-maps-api-php/)

Route::get('calculate-distance', [DistanceCalculateController::class, 'calculate_distance'])->name('calculate-distance');

///

Route::get('calculate-multiple-distance', [MultipleDistanceCalculateController::class, 'calculate_multiple_distance'])->name('calculate-multiple-distance');

/// 

// Route::get('multiple-distance-advance', [BothsideDistanceCalculateController::class, 'multiple_distance'])->name('multiple-distance-advance');


/////////////// Find Nearest Places (https://www.codegrepper.com/code-examples/php/how+to+find+nearest+location+using+latitude+and+longitude+in+laravel)

Route::get('near-places', [NearestLocationController::class, 'nearest_location'])->name('near-places');