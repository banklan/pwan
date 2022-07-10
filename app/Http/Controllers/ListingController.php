<?php

namespace App\Http\Controllers;

use App\PropertyListing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function getFeatured(){
        $props = PropertyListing::where(['is_approved' => true, 'is_featured' => true])->take(3)->get();

        // foreach($props as $prop){

        // }
        return response()->json($props, 200);
    }

    public function getLatest(){
        $props = PropertyListing::where('is_approved', true)->take(3)->latest()->get();

        return response()->json($props, 200);
    }
}
