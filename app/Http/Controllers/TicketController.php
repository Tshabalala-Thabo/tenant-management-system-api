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
        $tickets = Ticket::with(['provider', 'tenant', 'room', 'site'])->get();
        $userId = Auth::id();

        // Retrieve all rooms assigned to the user
        $rooms = Room::where('tenant_id', $userId)->get();

        // Retrieve sites that have the rooms assigned to the user
        $siteIds = $rooms->pluck('site_id')->unique();
        $sites = Site::whereIn('id', $siteIds)->get();

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
     * @param  Request  $request
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
     * @param  Ticket  $ticket
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
     * @param  Ticket  $ticket
     * @return View
     */
    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Ticket  $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'details' => 'required|string',
            'provider_id' => 'nullable|exists:users,id',
            'response' => 'nullable|string',
            'tenant_id' => 'required|exists:users,id',
            'room_id' => 'nullable|exists:rooms,id',
            'site_id' => 'required|exists:sites,id',
        ]);

        $ticket->update([
            'details' => $request->input('details'),
            'provider_id' => $request->input('provider_id'), // This can be null
            'response' => $request->input('response'),
            'tenant_id' => Auth::id(), // Ensure tenant_id is set to the ID of the logged-in user
            'status' => $request->input('status', 'pending'), // Set status to "pending" if not provided
            'room_id' => $request->input('room_id'),
            'site_id' => $request->input('site_id'),
        ]);
        return redirect()->route('tickets.index')->with('success', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Ticket  $ticket
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }
}
