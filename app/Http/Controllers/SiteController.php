<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::all();
        return view('sites.index', compact('sites'));
    }

    public function create()
    {
        return view('sites.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|url|unique:sites',
            'tenant_id' => 'required|exists:tenants,id',
        ]);

        Site::create($request->get('name'));

        return redirect()->route('sites.index')->with('success', 'Site created successfully.');
    }

    public function show(Site $site)
    {
        return view('sites.show', compact('site'));
    }

    public function edit(Site $site)
    {
        return view('sites.edit', compact('site'));
    }

    public function update(Request $request, Site $site)
    {
        $request->validate([
            'name' => 'required',
            'tenant_id' => 'required|exists:tenants,id',
        ]);

        $site->update($request->all());

        return redirect()->route('sites.index')->with('success', 'Site updated successfully.');
    }

    public function destroy(Site $site)
    {
        $site->delete();

        return redirect()->route('sites.index')->with('success', 'Site deleted successfully.');
    }
}
