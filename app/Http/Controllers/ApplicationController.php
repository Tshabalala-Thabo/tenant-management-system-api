<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplicationController extends Controller
{
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
}
