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

    // View all jobs
    public function jobs()
    {
        return JobListing::with('company', 'postedBy')->get();
    }

    // View all applications
    public function applications()
    {
        return Application::with('user', 'jobListing')->get();
    }
}

