<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccommodationApplication;


class ApplicationController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Hardcoded applications data (with only site and no room information)
        $applications = [
            [
                'tenant_name' => 'John Doe',
                'application_date' => '2025-01-05',
                'status' => 'Submitted',
                'tenant_email' => 'john.doe@example.com',
                'tenant_phone' => '555-5555',
                'site_name' => 'Site A',
            ],
            [
                'tenant_name' => 'Jane Smith',
                'application_date' => '2025-01-06',
                'status' => 'Submitted',
                'tenant_email' => 'jane.smith@example.com',
                'tenant_phone' => '555-5556',
                'site_name' => 'Site B',
            ],
            [
                'tenant_name' => 'Michael Johnson',
                'application_date' => '2025-01-07',
                'status' => 'Approved',
                'tenant_email' => 'michael.johnson@example.com',
                'tenant_phone' => '555-5557',
                'site_name' => 'Site C',
            ],
        ];

        return view('applications.index', compact('applications'));
    }

    /**
     * Summary of applyForAccommodation
     * @param \Illuminate\Http\Request $request
     * @param mixed $siteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function applyForAccommodation(Request $request, $siteId)
    {
        $request->validate([
            'site_id' => 'required|exists:sites,id',
        ]);

        // Retrieve the authenticated user's ID
        $tenantId = auth()->user()->id;

        // Check if an application already exists for this tenant and site
        $existingApplication = AccommodationApplication::where('tenant_id', $tenantId)
            ->where('site_id', $siteId)
            ->first();

        if ($existingApplication) {
            return redirect('/accommodations')->with('error', 'You have already applied for this accommodation.');
        }

        // Create a new application
        AccommodationApplication::create([
            'tenant_id' => $tenantId, // Use the authenticated user's ID
            'site_id' => $siteId,
            'status' => 'pending',
        ]);

        // Redirect to the accommodations page
        return redirect('/accommodations')->with('success', 'Application submitted.');
    }
    public function removeTenantFromAccommodation($applicationId)
    {
        $application = AccommodationApplication::findOrFail($applicationId);

        // Option 1: Mark as rejected or canceled
        $application->status = 'rejected';
        $application->save();

        // Option 2: Delete the application if no longer relevant
        // $application->delete();

        return redirect()->route('landlord.applications')->with('success', 'Tenant removed from accommodation.');
    }
}
