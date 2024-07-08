<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $landlordId = Auth::id();
        $landlord = User::with(['sites.rooms'])->findOrFail($landlordId);

        $rooms = $landlord->sites->flatMap(function ($site) {
            return $site->rooms;
        });

        $nullRoomsCount = $rooms->whereNull('tenant_id')->count();
       $occupiedRoomsCount = $rooms->whereNotNull('tenant_id')->count();

   return view('dashboard', [
       'nullRoomsCount' => $nullRoomsCount,
       'occupiedRoomsCount' => $occupiedRoomsCount,
       'rooms' => $rooms,
   ]);

}
}