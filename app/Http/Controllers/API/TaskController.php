<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Services\Task\TaskService;

class TaskController extends Controller
{
    use ApiResponseTrait;
    protected $taskService;
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
        //$this->middleware('auth:api');
    }
    public function index()
    {
        return $tasks = $this->taskService->getAll();

    }
    public function show($id)
    {
        $task = $this->taskService->getById($id);
        if (!$task) {
            return $this->errorResponse('Task not found', 404);
        }
        return $task;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'sometimes|string',
            'estimated_time' => 'required|string|max:255',
        ]);
        $task = $this->taskService->create($validated);
        return $this->successResponse($task, 'Task created successfully', 201);
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|required|string',
            'estimated_time' => 'required|string|max:255',
            'status' => 'sometimes|string|max:255',

        ]);
        $task = $this->taskService->update($id, $validated);
        if (!$task) {
            return $this->errorResponse('Task not found', 404);
        }
        return $this->successResponse($task, 'Task updated successfully', 200);
    }
    public function destroy($id)
    {
        $task = $this->taskService->delete($id);
        if (!$task) {
            return $this->errorResponse('Task not found', 404);
        }
        return $this->successResponse(null, 'Task deleted successfully', 200);
    }
    public function submit($id)
    {
        
        $check = task::where()
        if ()
        $task = $this->taskService->update($id, ['status' => 'submitted']);
        if (!$task) {
            return $this->errorResponse('Task not found', 404);
    }
        return $this->successResponse($task, 'Task submitted successfully', 200);
    }
}
