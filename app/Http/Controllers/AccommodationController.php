<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;

class AccommodationController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Retrieve all sites
        $sites = Site::all();
    
        // Return the data with the Blade view
        return view('accommodations.index', compact('sites'));
    }
    
}
