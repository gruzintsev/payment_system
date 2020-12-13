<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Services\JobService;

class JobController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index()
    {
        $jobs = $this->jobService->get();

        return view('jobs.index', ['jobs' => $jobs]);
    }
    public function view(Job $job)
    {

        return view('jobs.view', [
            'job' => $job,
        ]);
    }

}
