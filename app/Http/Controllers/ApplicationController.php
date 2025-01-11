<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\AccommodationApplication;


class ApplicationController extends Controller
{
    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Retrieve all applications with tenant and site information
        $applications = AccommodationApplication::with(['tenant', 'site'])->get();

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
            // Allow reapplication only if the current status is "terminated" or "rejected"
            if (in_array($existingApplication->status, ['terminated', 'rejected'])) {
                // Update the existing application's status to "pending"
                $existingApplication->update(['status' => 'pending']);

                return redirect('/accommodations')->with('success', 'Your application has been resubmitted.');
            }

            // Block reapplication for other statuses
            return redirect('/accommodations')->with('error', 'You cannot reapply for this accommodation at this time.');
        }

        // Create a new application if none exists
        AccommodationApplication::create([
            'tenant_id' => $tenantId, // Use the authenticated user's ID
            'site_id' => $siteId,
            'status' => 'pending',
        ]);

        // Redirect to the accommodations page
        return redirect('/accommodations')->with('success', 'Application submitted.');
    }

    public function update(Request $request, $applicationId)
    {
        // Log the incoming request
        Log::info('Updating application with ID: ' . $applicationId, ['request' => $request->all()]);
    
        $application = AccommodationApplication::find($applicationId);
    
        if (!$application) {
            Log::error('Application not found', ['applicationId' => $applicationId]);
            return response()->json(['message' => 'Application not found'], 404);
        }
    
        $action = $request->input('action');
        $reason = $request->input('reason');
    
        Log::info('Action: ' . $action . ', Reason: ' . $reason);
    
        switch ($action) {
            case 'accept':
                $application->status = 'accepted';
                $application->termination_reason = null;
                $application->termination_date = null;
                $application->rejection_date = null;
                $application->rejection_reason = null;
                break;
    
            case 'reject':
                if ($application->status !== 'pending') {
                    Log::warning('Reject attempt on non-pending application', ['applicationId' => $applicationId]);
                    return response()->json(['message' => 'Only pending applications can be rejected'], 400);
                }
                $application->status = 'rejected';
                $application->rejection_reason = $reason;
                $application->previously_rejected = true;
                $application->rejection_date = now();
                break;
    
            case 'terminate':
                if ($application->status !== 'accepted') {
                    Log::warning('Terminate attempt on non-accepted application', ['applicationId' => $applicationId]);
                    return response()->json(['message' => 'Only accepted applications can be terminated'], 400);
                }
                $application->status = 'terminated';
                $application->termination_reason = $reason;
                $application->previously_terminated = true;
                $application->termination_date = now();
                break;
    
            default:
                Log::error('Invalid action provided', ['action' => $action]);
                return response()->json(['message' => 'Invalid action'], 400);
        }
    
        try {
            $application->save();
            Log::info('Application status updated successfully', ['applicationId' => $applicationId]);
        } catch (\Exception $e) {
            Log::error('Error saving application status', ['exception' => $e->getMessage()]);
            return response()->json(['message' => 'Internal server error'], 500);
        }
    
        return response()->json(['message' => 'Application status updated successfully'], 200);
    }
}
