<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;

class JobController extends Controller
{
    // List all jobs
    public function index()
    {
        return JobListing::with('company', 'postedBy')->get();
    }

    // Create new job (Employee only)
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string'
        ]);

        $data['company_id'] = auth('api')->user()->company_id;
        $data['posted_by'] = auth('api')->id();

        $job = JobListing::create($data);

        return response()->json($job, 201);
    }

    // Update job (only if employee owns it)
    public function update(Request $request, JobListing $jobListing)
    {
        if ($jobListing->posted_by !== auth('api')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $jobListing->update($request->only('title', 'description'));
        return response()->json($jobListing);
    }

    // Delete job (only if employee owns it)
    public function destroy(JobListing $jobListing)
    {
        if ($jobListing->posted_by !== auth('api')->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $jobListing->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
