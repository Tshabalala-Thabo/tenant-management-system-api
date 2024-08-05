<?php
namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\User;
use Illuminate\Http\Request;

class SiteServiceProviderController extends Controller
{
// Assign a service provider to a site
public function assign(Request $request, $siteId)
{
$validated = $request->validate([
'service_provider_id' => 'required|exists:users,id'
]);

$site = Site::findOrFail($siteId);
$site->serviceProviders()->attach($validated['service_provider_id']);

return response()->json(['message' => 'Service provider assigned successfully.']);
}

// Unassign a service provider from a site
public function unassign(Request $request, $siteId)
{
$validated = $request->validate([
'service_provider_id' => 'required|exists:users,id'
]);

$site = Site::findOrFail($siteId);
$site->serviceProviders()->detach($validated['service_provider_id']);

return response()->json(['message' => 'Service provider unassigned successfully.']);
}

// Search for service providers
public function search(Request $request)
{
$query = $request->input('search', '');

// Ensure search query is a string
if (!is_string($query) || strlen($query) < 3) {
return response()->json([]);
}

// Search for users with the role of service_provider
$serviceProviders = User::role('service_provider')
->where('name', 'like', '%' . $query . '%')
->orWhere('email', 'like', '%' . $query . '%')
->get();

return response()->json($serviceProviders);
}
}
