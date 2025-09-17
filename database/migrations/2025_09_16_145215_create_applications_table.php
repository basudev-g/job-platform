<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_listing_id');
            $table->unsignedBigInteger('user_id');
            $table->string('cv_path');
            $table->enum('status', ['pending','accepted','rejected'])->default('pending');
            $table->enum('payment_status', ['unpaid','paid'])->default('unpaid');
            $table->timestamps();

            $table->foreign('job_listing_id')->references('id')->on('job_listings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
