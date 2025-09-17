<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobListing;
use App\Models\Application;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // View all users
    public function users()
    {
        return User::with('company')->get();
    }

    // Create a new user
    public function createUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,employee,job_seeker',
            'company_id' => 'nullable|exists:companies,id'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    // Update an existing user
    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'sometimes|in:admin,employee,job_seeker',
            'company_id' => 'nullable|exists:companies,id'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }

    // Delete a user
    public function deleteUser(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // View all jobs
    public function jobs()
    {
        return JobListing::with('company', 'postedBy')->get();
    }

    // Create a new job
    public function createJob(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'posted_by' => 'required|exists:users,id'
        ]);

        $job = JobListing::create($data);
        return response()->json($job, 201);
    }

    // Update an existing job
    public function updateJob(Request $request, JobListing $jobListing)
    {
        $data = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'company_id' => 'sometimes|exists:companies,id',
            'posted_by' => 'sometimes|exists:users,id'
        ]);

        $jobListing->update($data);
        return response()->json($jobListing);
    }

    // Delete a job
    public function deleteJob(JobListing $jobListing)
    {
        $jobListing->delete();
        return response()->json(['message' => 'Job deleted successfully']);
    }

    // View all applications
    public function applications()
    {
        return Application::with('user', 'jobListing')->get();
    }
}

