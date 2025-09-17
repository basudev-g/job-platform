<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobListing;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    // Apply for a job (Job Seeker only)
    public function apply(Request $request, $jobListingId)
    {
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:5120'
        ]);

        $cvPath = $request->file('cv')->store('cvs');

        $application = Application::create([
            'job_listing_id' => $jobListingId,
            'user_id' => auth('api')->id(),
            'cv_path' => $cvPath,
            'status' => 'pending',
            'payment_status' => 'paid' // mock payment success
        ]);

        Invoice::create([
            'user_id' => auth('api')->id(),
            'amount' => 100,
            'time' => now()
        ]);

        return response()->json($application, 201);
    }

    // View own applications
    public function myApplications()
    {
        return Application::with('jobListing')->where('user_id', auth('api')->id())->get();
    }

    // Recruiter view applications for their jobs
    public function jobApplications($jobListingId)
    {
        $job = JobListing::findOrFail($jobListingId);

        if ($job->posted_by !== auth('api')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $job->applications()->with('user')->get();
    }

    // Accept/Reject application (Recruiter only)
    public function updateStatus(Request $request, Application $application)
    {
        $job = $application->jobListing;

        if ($job->posted_by !== auth('api')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected'
        ]);

        $application->status = $request->status;
        $application->save();

        return response()->json($application);
    }
}

