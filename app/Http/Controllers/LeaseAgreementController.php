<?php

// app/Http/Controllers/LeaseAgreementController.php

namespace App\Http\Controllers;

use App\Models\LeaseAgreement;
use Illuminate\Http\Request;

class LeaseAgreementController extends Controller
{
    public function index()
    {
        $leaseAgreements = LeaseAgreement::with(['room', 'tenant'])->get();
        return view('lease_agreements.index', compact('leaseAgreements'));
    }

    public function create()
    {
        return view('lease_agreements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Set 'is_terminated' to false by default
        $leaseData = $request->all();
        $leaseData['is_terminated'] = false;

        LeaseAgreement::create($leaseData);

        // Redirect back to the previous page or the same route, causing a page refresh
        return redirect()->back()->with('success', 'Lease agreement created successfully.');
    }

    public function show($id)
    {
        $leaseAgreement = LeaseAgreement::with(['room', 'tenant'])->findOrFail($id);
        return view('lease_agreements.show', compact('leaseAgreement'));
    }

    public function edit($id)
    {
        $leaseAgreement = LeaseAgreement::findOrFail($id);
        return view('lease_agreements.edit', compact('leaseAgreement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_terminated' => 'required|boolean',
        ]);

        $leaseAgreement = LeaseAgreement::findOrFail($id);
        $leaseAgreement->update($request->all());

        return redirect()->route('lease_agreements.index')->with('success', 'Lease agreement updated successfully.');
    }

    public function destroy($id)
    {
        $leaseAgreement = LeaseAgreement::findOrFail($id);
        $leaseAgreement->delete();

        return redirect()->route('lease_agreements.index')->with('success', 'Lease agreement deleted successfully.');
    }
}
