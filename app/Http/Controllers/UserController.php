<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');
        $users = User::where('name', 'like', "%{$query}%")->get();
        //$users = User::all();

        return response()->json($users);
    }

    public function show($id)
    {
        $tenant = User::findOrFail($id); // Assuming Tenant model exists and has necessary fields

        // Pass $tenant data to the view
        return view('tenants.profile', compact('tenant'));
    }

    public function getTenantsByLandlord()
    {

        if (Auth::check()) {
            $landlordId = Auth::id();
        }

        $landlord = User::with(['sites.rooms.tenant'])->findOrFail($landlordId);

        if (!empty($landlord)) {
            // Collect tenants and their rooms grouped by site
            $tenants = $landlord->sites->flatMap(function ($site) {
                return $site->rooms->map(function ($room) use ($site) {
                    if ($room->tenant) {
                        return [
                            'tenant' => $room->tenant,
                            'room' => $room,
                            'site' => $site,
                        ];
                    }
                    return null;
                });
            })->filter();
        }
        // Group tenants by tenant ID to ensure uniqueness
        $groupedTenants = $tenants->groupBy('tenant.id');

        //return response()->json($tenants);
        //return view('tenants', ['tenants' => $tenants]);
        return view('tenants', ['groupedTenants' => $groupedTenants]);
    }
}
