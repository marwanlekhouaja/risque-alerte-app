<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
class LocationController extends Controller
{
    //use Stevebauman\Location\Facades\Location;

public function index(Request $request)
{
    $ip = $request->ip(); // Or use a static IP for testing
    // $location = Location::get($ip);
    $location = Location::get("66.102.0.0");


    dd($location);

    
}
}
