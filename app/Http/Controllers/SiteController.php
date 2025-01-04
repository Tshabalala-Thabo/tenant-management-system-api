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
        // Retrieve the site along with its rooms, tenants, and service providers
        $site = Site::with(['rooms.tenant', 'serviceProviders'])->findOrFail($id);

        // Check if the user can view the site
        $this->authorize('view', $site);

        return view('sites.view', compact('site'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $validated['landlord_id'] = auth()->id();

        Site::create($validated);

        return redirect()->route('sites.index')->with('success', 'Site created successfully.');
    }

    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        $site->update($validated);

        return redirect()->back()->with('success', 'Site updated successfully.');
    }
}
