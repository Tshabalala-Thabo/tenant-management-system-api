<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Invoice;
use App\Models\LeaseAgreement;

class DashboardController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $userId = Auth::id();
        $user = User::with(['sites.rooms'])->findOrFail($userId);

        if ($user->hasRole('landlord')) {
            $rooms = $user->sites->flatMap(function ($site) {
                return $site->rooms;
            });

            $nullRoomsCount = $rooms->whereNull('tenant_id')->count();
            $occupiedRoomsCount = $rooms->whereNotNull('tenant_id')->count();
            $siteCount = $user->sites->count();

            // Get the IDs of the landlord's sites
            $siteIds = $user->sites->pluck('id');

            // Count the solved and pending tickets associated with the landlord's sites
            $solvedTicketsCount = Ticket::whereIn('site_id', $siteIds)->where('status', 'solved')->count();
            $pendingTicketsCount = Ticket::whereIn('site_id', $siteIds)->where('status', 'pending')->count();

            // Count the number of unique tenants assigned to rooms in the landlord's sites
            $tenantIds = Room::whereIn('site_id', $siteIds)->whereNotNull('tenant_id')->pluck('tenant_id')->unique();
            $tenantsCount = $tenantIds->count();

            // Get the IDs of the rooms that belong to the landlord's sites
            $roomIds = Room::whereIn('site_id', $siteIds)->pluck('id');

            // Count the number of invoices associated with these rooms
            $invoicesCount = Invoice::whereIn('room_id', $roomIds)->count();

            return view('dashboard', [
                'nullRoomsCount' => $nullRoomsCount,
                'occupiedRoomsCount' => $occupiedRoomsCount,
                'rooms' => $rooms,
                'siteCount' => $siteCount,
                'solvedTicketsCount' => $solvedTicketsCount,
                'pendingTicketsCount' => $pendingTicketsCount,
                'tenantsCount' => $tenantsCount,
                'invoicesCount' => $invoicesCount,
            ]);
        } elseif ($user->hasRole('tenant')) {
            $ticketsCount = Ticket::where('tenant_id', $userId)->count();
            $leaseAgreementsCount = LeaseAgreement::where('tenant_id', $userId)->count();
            $invoicesCount = Invoice::where('tenant_id', $userId)->count();

            // Count the number of rooms assigned to the tenant
            $assignedRoomsCount = Room::where('tenant_id', $userId)->count();

            return view('dashboard', [
                'ticketsCount' => $ticketsCount,
                'leaseAgreementsCount' => $leaseAgreementsCount,
                'invoicesCount' => $invoicesCount,
                'assignedRoomsCount' => $assignedRoomsCount,
            ]);
        } elseif ($user->hasRole('service_provider')) {
            // Get the IDs of the sites assigned to the current service provider
            $siteIds = \DB::table('service_provider_site')
                ->where('service_provider_id', $userId)
                ->pluck('site_id');

            // Check if the service provider is assigned to any sites
            if ($siteIds->isEmpty()) {
                // If no sites are assigned, pass a message to the view
                return view('dashboard', [
                    'message' => 'You are not assigned to any sites, a landlord has to assing you as a site service provider.'
                ]);
            }

            // Count the solved and pending tickets for these sites
            $solvedTicketsCount = Ticket::whereIn('site_id', $siteIds)
                ->where('status', 'solved')
                ->count();

            $pendingTicketsCount = Ticket::whereIn('site_id', $siteIds)
                ->where('status', 'pending')
                ->count();

            return view('dashboard', [
                'solvedTicketsCount' => $solvedTicketsCount,
                'pendingTicketsCount' => $pendingTicketsCount,
            ]);
        } else {
            // Handle cases where the user does not have a recognized role
            return abort(403, 'Unauthorized');
        }
    }
}
