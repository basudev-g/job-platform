<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;

// Public Routes

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');


// Protected Routes (JWT required)
Route::middleware('auth:api')->group(function () {

    // 🔹 Common Routes
    Route::get('jobs', [JobController::class, 'index']); // Everyone can view jobs

    // 🔹 Job Seeker Routes
    Route::middleware('role:job_seeker')->group(function () {
        Route::post('jobs/{jobListingId}/apply', [ApplicationController::class, 'apply']);
        Route::get('my-applications', [ApplicationController::class, 'myApplications']);
    });

    // 🔹 Employee (Recruiter) Routes
    Route::middleware('role:employee')->group(function () {
        Route::post('jobs', [JobController::class, 'store']);
        Route::put('jobs/{jobListing}', [JobController::class, 'update']);
        Route::delete('jobs/{jobListing}', [JobController::class, 'destroy']);

        // View applications for a specific job
        Route::get('jobs/{jobListingId}/applications', [ApplicationController::class, 'jobApplications']);

        // Accept / Reject an application
        Route::put('applications/{application}/status', [ApplicationController::class, 'updateStatus']);
    });

    // 🔹 Admin Routes
    Route::middleware('role:admin')->group(function () {
        Route::get('admin/users', [AdminController::class, 'users']);
        Route::get('admin/jobs', [AdminController::class, 'jobs']);
        Route::get('admin/applications', [AdminController::class, 'applications']);

        // 🔹 Admin Manage Users
        Route::post('admin/users', [AdminController::class, 'createUser']);
        Route::put('admin/users/{user}', [AdminController::class, 'updateUser']);
        Route::delete('admin/users/{user}', [AdminController::class, 'deleteUser']);
        Route::put('admin/users/{user}/reset-password', [AdminController::class, 'resetPassword']);

        // 🔹 Admin Manage Jobs
        Route::post('admin/jobs', [AdminController::class, 'createJob']);
        Route::put('admin/jobs/{jobListing}', [AdminController::class, 'updateJob']);
        Route::delete('admin/jobs/{jobListing}', [AdminController::class, 'deleteJob']);
    });
});
