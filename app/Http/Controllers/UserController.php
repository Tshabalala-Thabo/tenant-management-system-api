<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');
        $siteId = $request->input('site_id'); // Get the current site ID from the request

        $users = User::whereHas('accommodationApplications', function ($query) use ($siteId) {
                $query->where('site_id', $siteId)
                      ->where('status', 'accepted'); // Ensure the application is accepted
            })
            ->get(['id', 'name', 'last_name', 'email']);

        return response()->json($users);
    }
    public function show($id)
    {
        // Fetch the tenant with their tickets and lease agreements including room and site information
        $tenant = User::with([
            'invoices.room.site',  // This ensures we load the site with each invoice
            'leaseAgreements.room.site',
            'tenantTickets'
        ])->findOrFail($id);

        // Fetch rooms assigned to this tenant
        $rooms = Room::where('tenant_id', $id)->with('site')->get();

        // Pass $tenant and $rooms data to the view
        return view('tenants.profile', compact('tenant', 'rooms'));
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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'required|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Registration successful'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Create a new token for the user
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login successful'
        ]);
    }
}
