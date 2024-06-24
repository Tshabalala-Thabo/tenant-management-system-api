<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class LandlordSiteController extends Controller
{
    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        dd($request->get('name')) ;
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
        ]);

        if(Auth::check()){
            
        Site::create([
            'name' => $request->name,
            'description' => $request->description,
            'landlord_id' => Auth::id(), // Assuming landlord is also a tenant
        ]);
    }

        return redirect()->route('sites')->with('success', 'Site added successfully.');
    }
}
