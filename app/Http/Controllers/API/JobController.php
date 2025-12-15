<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Services\Job\jobService;

class JobController extends Controller
{
    use ApiResponseTrait;
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
        $this->middleware('auth:api');
    }
    public function index()
    {
        return $jobs = $this->jobService->getAll();

    }
    public function show($id)
    {
        $job = $this->jobService->getById($id);
        if (!$job) {
            return $this->errorResponse('Job not found', 404);
        }
        return $job;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric',
        ]);

        $job = $this->jobService->create($validated);
        return $this->successResponse($job, 'Job created successfully', 201);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'location' => 'sometimes|required|string|max:255',
            'salary' => 'sometimes|required|numeric',
        ]);
        $job = $this->jobService->update($id, $validated);
        if (!$job) {
            return $this->errorResponse('Job not found', 404);
        }
        return $this->successResponse($job, 'Job updated successfully', 200);
    }
    public function destroy($id)
    {
        $deleted = $this->jobService->delete($id);
        if (!$deleted) {
            return $this->errorResponse('Job not found', 404);
        }
        return $this->successResponse(null, 'Job deleted successfully', 200);
    }
}
