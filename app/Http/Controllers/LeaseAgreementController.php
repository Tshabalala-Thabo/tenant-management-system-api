<?php

// app/Http/Controllers/LeaseAgreementController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaseAgreement;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Site;
use Dompdf\Dompdf;
use Dompdf\Options;

class LeaseAgreementController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id;

        if ($user->hasRole('tenant')) {
            // Retrieve lease agreements for the tenant
            $leaseAgreements = LeaseAgreement::with(['room', 'tenant'])
                ->where('tenant_id', $userId)
                ->get();
        } elseif ($user->hasRole('landlord')) {
            // Retrieve lease agreements for rooms associated with sites of the landlord
            $siteIds = Site::where('landlord_id', $userId)->pluck('id'); // Get site IDs for the landlord
            $roomIds = Room::whereIn('site_id', $siteIds)->pluck('id'); // Get room IDs for those sites
            $leaseAgreements = LeaseAgreement::with(['room', 'tenant'])
                ->whereIn('room_id', $roomIds)
                ->get();
        } else {
            // Optionally handle users without specific roles
            $leaseAgreements = LeaseAgreement::with(['room', 'tenant'])->get();
        }

        return view('lease-agreements.index', compact('leaseAgreements'));
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

    public function update(Request $request, LeaseAgreement $leaseAgreement)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Handle termination status
        $wasTerminated = $leaseAgreement->is_terminated;
        $isNowTerminated = $request->has('is_terminated');

        // Update basic fields
        $leaseAgreement->room_id = $validated['room_id'];
        $leaseAgreement->start_date = $validated['start_date'];
        $leaseAgreement->end_date = $validated['end_date'];
        
        // Update termination status and date
        $leaseAgreement->is_terminated = $isNowTerminated;
        if (!$wasTerminated && $isNowTerminated) {
            $leaseAgreement->termination_date = now();
        } elseif (!$isNowTerminated) {
            $leaseAgreement->termination_date = null;
        }

        $leaseAgreement->save();

        return redirect()->back()->with('success', 'Lease agreement updated successfully.');
    }

    public function destroy($id)
    {
        $leaseAgreement = LeaseAgreement::findOrFail($id);
        $leaseAgreement->delete();

        return redirect()->route('lease_agreements.index')->with('success', 'Lease agreement deleted successfully.');
    }

    public function print($id)
    {
        $leaseAgreement = LeaseAgreement::with(['room.site', 'tenant'])->findOrFail($id);

        // Load the view and pass the lease agreement data
        $pdf = new Dompdf();
        $pdf->setOptions(new Options(['defaultFont' => 'Arial'])); // Set default font

        $html = view('lease-agreements.print', compact('leaseAgreement'))->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'portrait'); // Set paper size and orientation
        $pdf->render();

        // Output the generated PDF to Browser
        return $pdf->stream("lease_agreement_{$leaseAgreement->id}.pdf", ["Attachment" => false]);
    }
}
