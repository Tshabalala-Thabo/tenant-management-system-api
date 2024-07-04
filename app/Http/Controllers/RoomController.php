<?php
namespace App\Http\Controllers;

use App\Models\Room;
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
    public function assignUser(Request $request, Room $room)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $room->tenant_id = $request->user_id;
        $room->save();

        return response()->json(['message' => 'User assigned successfully.'], 200);
    }
}
