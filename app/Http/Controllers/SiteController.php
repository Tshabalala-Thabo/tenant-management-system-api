<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::where('landlord_id', Auth::id())->get();
        return view('sites', compact('sites'));
    }
    public function show(Site $site)
    {
        $this->authorize('view', $site);

        return view('sites.show', compact('site'));
    }

    public function create()
    {
        return view('create');
    }

    public function edit($id)
    {
        $site = Site::findOrFail($id);

        // Check if the user can edit the site
        $this->authorize('edit', $site);

        // Your edit logic here
        return view('sites.edit', compact('site'));
    }

    public function view_site($id)
    {
        //$site = Site::findOrFail($id);


        // Your view logic here
        //return view('sites.view', compact('site'));
        $site = Site::with('rooms.tenant')->findOrFail($id);

        // Check if the user can view the site
        $this->authorize('view', $site);

        return view('sites.view', compact('site'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $site = new Site();
        $site->name = $request->name;
        $site->landlord_id = Auth::id(); // Set the landlord (user) ID
        $site->save();

        return redirect()->route('sites.index')->with('success', 'Site created successfully!');
    }
}
