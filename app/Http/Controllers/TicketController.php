<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $tickets = Ticket::with(['provider', 'tenant'])->get();
        return view('tickets.index', compact('tickets'));
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
            'details' => 'required|string|max:255',
            'provider_id' => 'required|integer|exists:users,id',
            'response' => 'nullable|string|max:255',
            'tenant_id' => 'required|integer|exists:users,id',
            'status' => 'required|string|max:255',
        ]);

        Ticket::create($request->all());

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
            'details' => 'required|string|max:255',
            'provider_id' => 'required|integer|exists:users,id',
            'response' => 'nullable|string|max:255',
            'tenant_id' => 'required|integer|exists:users,id',
            'status' => 'required|string|max:255',
        ]);

        $ticket->update($request->all());

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
