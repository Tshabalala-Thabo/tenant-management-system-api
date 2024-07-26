<?php

namespace App\Http\Controllers;
use App\Models\Invoice;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        // Retrieve all invoices
        $invoices = Invoice::with(['tenant', 'room', 'site'])->get();
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
            'tenant_id' => 'required|exists:tenants,id',
            'room_id' => 'nullable|exists:rooms,id',
            'site_id' => 'nullable|exists:sites,id',
            'invoice_number' => 'required|unique:invoices',
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
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
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
            'tenant_id' => 'required|exists:tenants,id',
            'room_id' => 'nullable|exists:rooms,id',
            'site_id' => 'nullable|exists:sites,id',
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $invoice->id,
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

        $invoice->update($validated);
        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        // Delete an existing invoice
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
