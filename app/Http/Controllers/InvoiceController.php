<?php

namespace App\Http\Controllers;
use App\Models\Invoice;
use App\Models\Site;
use App\Models\Tenant;
use App\Models\Room;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index()
    {
        // Check if the user has the 'landlord' role
        if (auth()->user()->hasRole('landlord')) {
            // Retrieve the landlord_id of the current user
            $landlordId = auth()->user()->id;
    
            // Fetch the Site_ids that belong to the landlord
            $siteIds = Site::where('landlord_id', $landlordId)->pluck('id');
    
            // Retrieve rooms that belong to these sites
            $rooms = Room::whereIn('site_id', $siteIds)->with('site')->get();
    
            // Retrieve invoices that have rooms belonging to the landlord's sites
            $invoices = Invoice::with(['tenant', 'room.site'])
                ->whereHas('room', function ($query) use ($siteIds) {
                    $query->whereIn('site_id', $siteIds);
                })
                ->get();
        }
        // Check if the user has the 'tenant' role
        else if (auth()->user()->hasRole('tenant')) {
            // Retrieve the tenant_id of the current user
            $tenantId = auth()->user()->id;
    
            // Retrieve invoices that belong to the tenant
            $invoices = Invoice::with(['tenant', 'room.site'])
                ->where('tenant_id', $tenantId)
                ->get();
        }
        else {
            // For users who are neither landlords nor tenants, return an empty collection
            $invoices = collect();
            // Optionally, you can return a 403 response
            // abort(403, 'Unauthorized action.');
        }
    
        return view('invoices.index', compact('invoices'));
    }
    


    public function show(Invoice $invoice)
    {
        // Show a specific invoice
        $invoice->load(['tenant', 'room', 'site']);
        return view('invoices.show', compact('invoice'));
    }

    public function create()
    {
        // Show form to create a new invoice
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        // Validate and store a new invoice
        $validated = $request->validate([
            'tenant_id' => 'required|exists:users,id',
            'room_id' => 'nullable|exists:rooms,id',
            'site_id' => 'nullable|exists:sites,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date',
            'amount' => 'required|numeric',
            'paid_amount' => 'nullable|numeric',
            'status' => 'required|in:pending,paid,overdue,canceled',
            'water_charge' => 'nullable|numeric',
            'electricity_charge' => 'nullable|numeric',
            'other_charges' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        Invoice::create($validated);
        return redirect()->back()->with('success', 'Invoice agreement created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        // Show form to edit an existing invoice
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        // Validate and update an existing invoice
        $validated = $request->validate([
            'tenant_id' => 'nullable|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date',
            'amount' => 'required|numeric',
            'paid_amount' => 'nullable|numeric',
            'status' => 'required|in:pending,paid,overdue,canceled',
            'water_charge' => 'nullable|numeric',
            'electricity_charge' => 'nullable|numeric',
            'other_charges' => 'nullable|numeric',
            'description' => 'nullable|string',
        ]);

        // Keep the existing tenant_id if not provided
        if (!isset($validated['tenant_id'])) {
            $validated['tenant_id'] = $invoice->tenant_id;
        }

        $invoice->update($validated);
        return redirect()->back()->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->back()->with('success', 'Invoice deleted successfully');
    }

    public function printInvoice(Invoice $invoice)
    {
        $invoice->load(['tenant', 'room.site']);
        
        // Calculate total amount
        $totalAmount = $invoice->amount +
            ($invoice->water_charge ?? 0) +
            ($invoice->electricity_charge ?? 0) +
            ($invoice->other_charges ?? 0);

        $pdf = Pdf::loadView('invoices.print', [
            'invoice' => $invoice,
            'totalAmount' => $totalAmount
        ]);

        // Configure PDF options
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif',
            'chroot' => public_path(),
            'enable_remote' => true,
        ]);

        return $pdf->stream('invoice-' . $invoice->id . '.pdf');
    }
}
