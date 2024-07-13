<?php
namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'site_id' => 'required|integer',
            'cost' => 'required|numeric',
            'tenant_id' => 'nullable|integer|exists:users,id',
        ]);

        // Room::create($validatedData);
        Room::create([
            'name' => $request->name,
            'description' => $request->description,
            'site_id' => $request->site_id,
            'cost' => $request->cost,
            'tenant_id' => $request->tenant_id,
        ]);
        return redirect()->route('sites.view', $validatedData['site_id'])->with('success', 'Room created successfully.');
    }

    public function getRoomsBySite($siteId)
    {
        $userId = Auth::id();
        $rooms = Room::where('tenant_id', $userId)->where('site_id', $siteId)->get();
        return response()->json($rooms);
    }
    public function assignUser(Request $request, Room $room)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $room->tenant_id = $request->user_id;
        $room->save();

        return response()->json(['message' => 'User assigned successfully.'], 200);
    }

    public function removeTenant($roomId)
    {
        try {
            $room = Room::findOrFail($roomId);

            // Check if room has a tenant
            if ($room->tenant_id) {
                // Remove the tenant from the room
                $room->update(['tenant_id' => null]);

                return response()->json(['message' => 'Tenant removed successfully.'], 200);
            } else {
                return response()->json(['message' => 'No tenant assigned to this room.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error removing tenant.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($roomId)
    {
        $room = Room::findOrFail($roomId);

        $room->delete();

        return response()->json(['message' => 'Room deleted successfully.'], 200);
    }
}
