<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');
        $users = User::where('name', 'like', "%{$query}%")->get();
        //$users = User::all();

        return response()->json($users);
    }

    public function getTenantsByLandlord($landlordId)
    {
        $landlord = User::with(['sites.rooms.tenant'])->findOrFail($landlordId);

        $tenants = $landlord->sites->flatMap(function ($site) {
            return $site->rooms->map(function ($room) {
                return $room->tenant;
            });
        })->filter();

        return response()->json($tenants);
    }
}
