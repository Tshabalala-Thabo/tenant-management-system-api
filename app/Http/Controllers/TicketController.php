<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Site;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */

    public function index(): View
    {
        $userId = Auth::id();
        $user = Auth::user();

        if ($user->hasRole('tenant')) {
            // Retrieve all tickets that belong to the tenant
            $tickets = Ticket::with(['provider', 'tenant', 'room', 'site'])
                ->where('tenant_id', $userId)
                ->get();

            // Retrieve all rooms assigned to the tenant
            $rooms = Room::where('tenant_id', $userId)->get();

            // Retrieve sites that have the rooms assigned to the tenant
            $siteIds = $rooms->pluck('site_id')->unique();
            $sites = Site::whereIn('id', $siteIds)->get();
        } elseif ($user->hasRole('landlord')) {
            // Retrieve all tickets for sites belonging to the landlord
            $siteIds = Site::where('landlord_id', $userId)->pluck('id'); // Retrieve site IDs for the landlord
            $tickets = Ticket::with(['provider', 'tenant', 'room', 'site'])
                ->whereIn('site_id', $siteIds)
                ->get();

            // Retrieve all rooms for the landlord's sites
            $rooms = Room::whereIn('site_id', $siteIds)->get();

            // Retrieve sites for the landlord
            $sites = Site::whereIn('id', $siteIds)->get();
        } elseif ($user->hasRole('service_provider')) {
            // Retrieve all site IDs related to the service provider
            $siteIds = Site::whereIn('id', function ($query) use ($userId) {
                $query->select('site_id')
                    ->from('service_provider_site')
                    ->where('service_provider_id', $userId);
            })->pluck('id');

            // Retrieve tickets for those sites
            $tickets = Ticket::with(['provider', 'tenant', 'room', 'site'])
                ->whereIn('site_id', $siteIds)
                ->get();

            // Retrieve all rooms for the service provider's sites
            $rooms = Room::whereIn('site_id', $siteIds)->get();

            // Retrieve sites for the service provider
            $sites = Site::whereIn('id', $siteIds)->get();
        } else {
            // For users without specific roles, retrieve all tickets
            $tickets = Ticket::with(['provider', 'tenant', 'room', 'site'])->get();
            $rooms = [];
            $sites = [];
        }

        return view('tickets.index', compact('tickets', 'sites', 'rooms'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'details' => 'required|string',
            'provider_id' => 'nullable|exists:users,id',
            'response' => 'nullable|string',
            'room_id' => 'nullable|exists:rooms,id',
            'site_id' => 'required|exists:sites,id',
        ]);

        Ticket::create([
            'details' => $request->input('details'),
            'provider_id' => $request->input('provider_id'), // This can be null
            'response' => $request->input('response'),
            'tenant_id' => Auth::id(), // Set tenant_id as the ID of the logged-in user
            'status' => 'pending', // Set status to "pending" by default
            'room_id' => $request->input('room_id'),
            'site_id' => $request->input('site_id'),
        ]);
        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Ticket $ticket
     * @return View
     */
    public function show(Ticket $ticket): View
    {
        $ticket->load(['provider', 'tenant']);
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ticket $ticket
     * @return View
     */
    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Ticket $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Ticket $ticket)
    {
        $user = Auth::user();

        // Common validation rules for all users
        $rules = [
            'response' => 'nullable|string',
            'status' => 'required|string', // Status should always be required
        ];

        // Check if the user is a service provider
        if ($user->hasRole('service_provider')) {
            // For service providers, only validate response and status
            $request->validate($rules);

            // Update only the response and status fields
            $ticket->update([
                'response' => $request->input('response'),
                'status' => $request->input('status'),
                'provider_id' => $user->id, // Set provider_id to the logged-in user's ID
            ]);
        } else {
            // For other users, validate all fields
            $rules = array_merge($rules, [
                'details' => 'required|string',
                'provider_id' => 'nullable|exists:users,id',
                'tenant_id' => 'required|exists:users,id',
                'room_id' => 'nullable|exists:rooms,id',
                'site_id' => 'required|exists:sites,id',
            ]);

            $request->validate($rules);

            // Update the ticket with input values
            $ticket->update([
                'details' => $request->input('details'),
                'provider_id' => $request->input('provider_id'), // This can be null
                'response' => $request->input('response'),
                'tenant_id' => $user->id, // Ensure tenant_id is set to the ID of the logged-in user
                'status' => $request->input('status', 'pending'), // Set status to "pending" if not provided
                'room_id' => $request->input('room_id'),
                'site_id' => $request->input('site_id'),
            ]);
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Ticket $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
