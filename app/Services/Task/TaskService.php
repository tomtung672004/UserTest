<?php
namespace App\Services\Task;
use App\Repositories\Task\ITaskRepository;
use App\Services\BaseService;

class TaskService extends BaseService implements ITaskService
{
    protected $taskRepository;

    public function __construct(ITaskRepository $taskRepository)
    {
        parent::__construct($taskRepository);
        $this->taskRepository = $taskRepository;
    }
    public function submit($id)
    {
        // Implement the logic to submit a task by its ID
        $task = $this->taskRepository->find($id);
        if ($task) {
            $task->status = 'submitted';
            $this->taskRepository->update($id, $task->toArray());
            return $task;
        }
        return null;
    }
}
