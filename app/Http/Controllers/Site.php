<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function show(Site $site)
    {
        $this->authorize('view', $site);

        return view('sites.show', compact('site'));
    }

    public function edit($id)
    {
        $site = Site::findOrFail($id);

        // Check if the user can edit the site
        $this->authorize('edit', $site);

        // Your edit logic here
        return view('sites.edit', compact('site'));
    }
}
