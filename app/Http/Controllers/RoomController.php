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
            'description' => 'nullable|string',
            'site_id' => 'required|exists:sites,id',
        ]);

        Room::create($validatedData);

        return redirect()->route('sites.view', $validatedData['site_id'])->with('success', 'Room created successfully.');
    }
}
